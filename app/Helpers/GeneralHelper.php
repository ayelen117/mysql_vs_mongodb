<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectID;
use MongoDB\Client;

/**
 * Created by PhpStorm.
 * User: ayelen
 * Date: 27/07/17
 * Time: 18:06
 */
class GeneralHelper
{
	public $client;
	
	public function __construct()
	{
		$this->client = new Client(env('MONGODB_URL'));
	}
	
	public function getRelationships($data, $collection_name, $key)
	{
		$this->$collection_name = $this->client->tesis->$collection_name;
		$relationships_id = $data[$key];
		
		$relationships = null;
		if ($relationships_id) {
			if (is_array($relationships_id)) {
				foreach ($relationships_id as $ky => $relationship_id) {
					$relationships_id[$ky] = new ObjectID($relationship_id);
				}
				$relationships = $this->$collection_name->find(['_id' => ['$in' => $relationships_id]]);
				
			} else {
				$relationships = $this->$collection_name->findOne(['_id' => new ObjectID($relationships_id)]);
			}
		}
		
		return $relationships;
	}
	
	public function setRelationships(&$data, $collection_name, $key)
	{
		$relationships = $this->getRelationships($data, $collection_name, $key);
		$cursor_class = 'MongoDB\Driver\Cursor';
		
		if ($relationships) {
			if ($relationships instanceof $cursor_class) {
				$data[$key] = null;
				foreach ($relationships as $relationship) {
					$data[$key][] = new ObjectID($relationship->_id);
				}
			} else {
				$data[$key] = new ObjectID($relationships->_id);
			}
		}
	}
	
	public function getSql($modelName, $operation, $maxAllowedRecords, $qty, $data = null)
	{
		if($qty > $maxAllowedRecords){
			foreach (array_chunk($data,$maxAllowedRecords) as $datum) {
				$sql[] = $this->getSqlData($operation, $modelName, $qty, $datum);
			}
		} else {
			$sql = $this->getSqlData($operation, $modelName, $qty, $data);
		}
		
		return $sql;
	}
	
	public function getSqlData($operation, $modelName, $qty, $data = null){
		DB::connection()->enableQueryLog();
		switch ($operation){
			case 'store':
				$query = DB::table($modelName)->insert($data);
				break;
			case 'update':
				$query = DB::table($modelName)->where('id', '!=', 0)->limit($qty)->update($data);
				break;
			case 'delete':
				$query = DB::table($modelName)->where('id', '!=', 0)->limit($qty)->delete();
				break;
		}
		$queries = DB::getQueryLog();
		DB::connection()->disableQueryLog();
		DB::connection()->flushQueryLog();
		$query = $queries[0]['query'];
		$bindings = $queries[0]['bindings'];
		
		$sql = new \stdClass();
		$sql->query = $query;
		$sql->bindings = $bindings;
		
		return $sql;
	}
}