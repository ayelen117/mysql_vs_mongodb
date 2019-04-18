<?php

namespace App\Services;
ini_set('max_execution_time', 1800);

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;

class ServiceCrud
{
	public $client;
	public $mongoInstance;
	public $modelName;
	
	public function __construct($modelName)
	{
		$this->client = new Client(env('MONGODB_URL'));
		$this->mongoInstance = $this->client->tesis->$modelName;
		$this->modelName = $modelName;
		$this->helper = new GeneralHelper();
	}
	
	/**
	 * Toma los primeros registros porque al ser los primeros los que se actualizan son los que tienen más objetos
	 * relacionados.
	 * @param integer $qty
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function index($qty, $request)
	{
		Log::info('---------------- index start ----------------');
		$clean_cache = isset($request['clean_cache']) ? $request['clean_cache'] : null;
		
		$clean_cache ? $this->helper->clearCache($this->modelName): null ;
		
		/** MongoDB */
		$mongo_start = microtime(true);
		$result_mongo = $this->mongoInstance->find([], ['limit' => $qty]);
		$mongo_total = microtime(true) - $mongo_start;
		/** MongoDB */
		$result_mongo  = $result_mongo->toArray();
		
		$sql = $this->helper->getSqlData('list', $this->modelName, $qty);
		$clean_cache ? $this->helper->clearCache($this->modelName): null ;
		
		/** MySQL */
		$mysql_start = microtime(true);
		$result_mysql = DB::select($sql->query, $sql->bindings);
		$mysql_total = microtime(true) - $mysql_start;
		/** MySQL */
		$total = DB::select("select count(*) from $this->modelName")[0]->{'count(*)'};
		
		$mongo_query = '$this->client->tesis->' . $this->modelName .
			'->find([], ["limit" => ' . $qty . '])';
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => round($mongo_total, 4),
				'query' => $mongo_query,
			],
			'mysql' => [
				'time' => round($mysql_total, 4),
				'query' => $sql->query
			],
			'total' => $total,
			'data' => $qty,
		];
		Log::info('mongo => ' . round($mongo_total, 4));
		Log::info('mysql => ' . round($mysql_total, 4));
		Log::info('---------------- index end ----------------');
		
		return response($comparison, 201);
	}
	
	/**
	 * Almacena al final de la tabla
	 * @param integer $qty
	 * @param boolean $random_data
	 * @param string $mysqlModelClass
	 * @param string $mongoModelModel
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function store($qty, $random_data, $mysqlModelClass, $mongoModelModel)
	{
		Log::info('store');
		$mongo_objects = [];
		$mysql_objects = [];
		
		if ($random_data === 'true') {
			$mongo_objects = factory($mysqlModelClass, 'mongo', $qty)->make()->toArray();
			$mysql_objects = factory($mysqlModelClass, 'mysql', $qty)->make()->toArray();
		} else {
			$mongo_object = factory($mysqlModelClass, 'mongo')->make()->toArray();
			$mysql_object = factory($mysqlModelClass, 'mysql')->make()->toArray();
			for ($i = 0; $i < $qty; $i++) {
				$mongo_objects[] = $mongo_object;
				$mysql_objects[] = $mysql_object; // para que?: llena el array con tantos elementos como indica la variable qty
			}
			// todo: setear las relaciones para mysql
		}
		$mongo_start = microtime(true);
		$result = $this->mongoInstance->insertMany($mongo_objects);
		$mongo_total = microtime(true) - $mongo_start;
		
		$myModel = new $mysqlModelClass;
		$fieldsPerRecord = $myModel->getFillable();
		$maxAllowedRecords = floor(65536 / count($fieldsPerRecord));
		
		$sql = $this->helper->getSql($this->modelName, 'store', $maxAllowedRecords, $qty, $mysql_objects);
		$mysql_start = microtime(true);
		if (is_array($sql)) {
			foreach ($sql as $item) {
				$result_mysql[] = DB::insert($item->query, $item->bindings);
				$sql_bindings = $item->bindings;
				$sql_query = $item->query;
			}
		} else {
			$result_mysql = DB::insert($sql->query, $sql->bindings);
			$sql_query = $sql->query;
			$sql_bindings = $sql->bindings;
		}
		$mysql_total = microtime(true) - $mysql_start;
		
		$total = DB::table($this->modelName)->get()->count();
		$mongo_objects = json_encode($mongo_objects, true);
		$mongo_objects = str_replace(',', ', ', $mongo_objects);
		$mongo_query = '$this->client->tesis->' . $this->modelName . '->insertMany(' . $mongo_objects . ')';
		
		$sql_bindings = json_encode($sql_bindings, true);
		$sql_bindings = str_replace(',', ', ', $sql_bindings);
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => round($mongo_total, 4),
				'query' =>  substr($mongo_query, 0, 100)
			],
			'mysql' => [
				'time' => round($mysql_total, 4),
				'query' => substr($sql_query . ', ' . $sql_bindings, 0, 100)
			],
			'data' => $result->getInsertedCount(),
			'total' => $total,
		];
		Log::info('mongo => ' . round($mongo_total, 4));
		Log::info('mysql => ' . round($mysql_total, 4));
		
		return response($comparison, 201);
	}
	
	/**
	 * Actualiza los primeros
	 * @param integer $qty
	 * @param string $mysqlModelClass
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function update($qty, $mysqlModelClass)
	{
		Log::info('update');
		$mongo_object = factory($mysqlModelClass, 'mongo')->make()->toArray();
		$mysql_object = factory($mysqlModelClass, 'mysql')->make()->toArray();
		
		$start_id = $this->mongoInstance->find([], ['limit' => 1])->toArray()[0]->_id;
		$end_id = $this->mongoInstance->find([], ['limit' => 1, 'skip' => ($qty - 1)])->toArray()[0]->_id;
		
		$mongo_start = microtime(true);
		$result = $this->mongoInstance->updateMany(
			['_id' => ['$gte' => $start_id, '$lte' => $end_id]],
			['$set' => $mongo_object]
		);
		$mongo_total = microtime(true) - $mongo_start;
		
		$sql = $this->helper->getSqlData('update', $this->modelName, $qty, $mysql_object);
		
		$mysql_start = microtime(true);
		$result_mysql = DB::update($sql->query, $sql->bindings);
		$mysql_total = microtime(true) - $mysql_start;
		$total = DB::table($this->modelName)->get()->count();
		
		$mongo_object = json_encode($mongo_object, true);
		$mongo_object = str_replace(',', ', ', $mongo_object);
		$mongo_query = '$this->client->tesis->' . $this->modelName . '->updateMany(["_id" => ["$gte" => '
			. $start_id . ', "$lte" => ' . $end_id . ']],["$set" => ' . $mongo_object . '])';
		
		$sql_bindings = json_encode($sql->bindings, true);
		$sql_bindings = str_replace(',', ', ', $sql_bindings);
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => round($mongo_total, 4),
				'query' => $mongo_query
			],
			'mysql' => [
				'time' => round($mysql_total, 4),
				'query' => $sql->query . ', ' . $sql_bindings
			],
			'data' => $result->getModifiedCount(),
			'total' => $total,
		];
		Log::info('mongo => ' . round($mongo_total, 4));
		Log::info('mysql => ' . round($mysql_total, 4));
		
		return response($comparison, 200);
	}
	
	/**
	 * Elimina los primeros registros porque al ser los primeros los que se actualizan son los que tienen más objetos relacionados.
	 * @param integer $qty
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function destroy($qty)
	{
		Log::info('destroy');
		$start_id = $this->mongoInstance->find([], ['limit' => 1])->toArray()[0]->_id;
		$end_id = $this->mongoInstance->find([], ['limit' => 1, 'skip' => ($qty - 1)])->toArray()[0]->_id;
		
		$mongo_start = microtime(true);
		if($this->modelName == 'fiscalpos'){
			$result = $this->mongoInstance->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		} else {
			$result = $this->helper->runMongoQuery($this->client->tesis, $this->modelName, $start_id, $end_id);
		}
		$mongo_total = microtime(true) - $mongo_start;
		
		$sql = $this->helper->getSqlData('delete', $this->modelName, $qty);
		
		$mysql_start = microtime(true);
		$result_mysql = DB::delete($sql->query, $sql->bindings);
		$mysql_total = microtime(true) - $mysql_start;
		$total = DB::table($this->modelName)->get()->count();
		
		$mongo_query = "\$this->client->tesis->" . $this->modelName .
			"->deleteMany(['_id' => ['\$gte' => ' . $start_id . ', '\$lte'' => " . $end_id . "]])";
		$mongo_query .= $this->helper->getChildMongoDeletionQueries($this->modelName);
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => round($mongo_total, 4),
				'query' => $mongo_query
			],
			'mysql' => [
				'time' => round($mysql_total, 4),
				'query' => $sql->query
			],
			'data' => $result->getDeletedCount(),
			'total' => $total,
		];
		Log::info('mongo => ' . round($mongo_total, 4));
		Log::info('mysql => ' . round($mysql_total, 4));
		
		return response($comparison, 200);
	}
}