<?php

namespace App\Services;
ini_set('max_execution_time', 180);

use App\Helpers\GeneralHelper;
use App\Models\Mysql\Product;
use Illuminate\Support\Facades\DB;
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
	 * Toma los tiempos de
	 */
	public function index($qty)
	{
		$mongo_start = microtime(true);
		$result_mongo = $this->mongoInstance->find([], ['limit' => $qty]);
		$mongo_total = microtime(true) - $mongo_start;
		
		$mysql_start = microtime(true);
		$result_mysql = DB::select("SELECT * FROM $this->modelName LIMIT $qty");
		$mysql_total = microtime(true) - $mysql_start;
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => $mongo_total
			],
			'mysql' => [
				'time' => $mysql_total
			],
			'data' => $qty,
		];
		
		return response($comparison, 201);
	}
	
	public function store($qty, $random_data, $mysqlModelClass, $mongoModelModel)
	{
		$mongo_objects = [];
		$mysql_objects = [];
		
		if ($random_data === 'true') {
			$mongo_objects = factory($mysqlModelClass, 'mongo', $qty)->make()->toArray();
			foreach ($mongo_objects as &$mongo_object) {
				($mongoModelModel)->setRelationships($mongo_object);
			}
			
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
		$a = $myModel->getFillable();
		$b = floor(65536 / count($a));

		$sql = $this->helper->getSql($this->modelName, $mysql_objects, 'store', $b, $qty);
		$mysql_start = microtime(true);
		if (is_array($sql)) {
			foreach ($sql as $item){
				$result_mysql[] = DB::insert($item->query, $item->bindings);
			}
		} else {
			$result_mysql = DB::insert($sql->query, $sql->bindings);
		}
		$mysql_total = microtime(true) - $mysql_start;
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => $mongo_total
			],
			'mysql' => [
				'time' => $mysql_total
			],
			'data' => $result->getInsertedCount(),
		];
		
		return response($comparison, 201);
	}
	
	public function update($qty, $mysqlModelClass)
	{
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
		
		$mysql_start = microtime(true);
		DB::table($this->modelName)->where('id', '!=', 0)->limit($qty)->update($mysql_object);
		$mysql_total = microtime(true) - $mysql_start;
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => $mongo_total
			],
			'mysql' => [
				'time' => $mysql_total
			],
			'data' => $result->getModifiedCount(),
		];
		
		return response($comparison, 200);
	}
	
	public function destroy($qty)
	{
		$start_id = $this->mongoInstance->find([], ['limit' => 1])->toArray()[0]->_id;
		$end_id = $this->mongoInstance->find([], ['limit' => 1, 'skip' => ($qty - 1)])->toArray()[0]->_id;
		
		$mongo_start = microtime(true);
		$result = $this->mongoInstance->deleteMany(
			['_id' => ['$gte' => $start_id, '$lte' => $end_id]]
		);
		$mongo_total = microtime(true) - $mongo_start;
		
		$mysql_start = microtime(true);
		DB::table($this->modelName)->where('id', '!=', 0)->limit($qty)->delete();
		$mysql_total = microtime(true) - $mysql_start;
		
		$comparison = [
			'qty' => $qty,
			'mongo' => [
				'time' => $mongo_total
			],
			'mysql' => [
				'time' => $mysql_total
			],
			'data' => $result->getDeletedCount(),
		];
		
		return response($comparison, 200);
	}
}