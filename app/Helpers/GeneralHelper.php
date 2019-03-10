<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectID;
use function MongoDB\BSON\toPHP;
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
		if ($qty > $maxAllowedRecords) {
			foreach (array_chunk($data, $maxAllowedRecords) as $datum) {
				$sql[] = $this->getSqlData($operation, $modelName, $qty, $datum);
			}
		} else {
			$sql = $this->getSqlData($operation, $modelName, $qty, $data);
		}
		
		return $sql;
	}
	
	public function getSqlData($operation, $modelName, $qty, $data = null)
	{
		DB::beginTransaction();
		DB::connection()->enableQueryLog();
		switch ($operation) {
			case 'list':
				switch ($modelName) {
					case 'users':
						$query = DB::table($modelName)
//							->leftJoin('companies', 'users.id', '=', 'companies.user_id')
//							->leftJoin('products', 'users.id', '=', 'products.author_id')
//							->leftJoin('documents', 'users.id', '=', 'documents.author_id')
//							->leftJoin('entities', 'users.id', '=', 'entities.author_id')
							->select($modelName . '.*')
							->limit($qty)
							->get();
						break;
					default:
						$query = DB::table($modelName)->limit($qty)->get();
						break;
				}
				break;
			case 'store':
				$query = DB::table($modelName)->insert($data);
				break;
			case 'update':
				$query = DB::table($modelName)->where('id', '!=', 0)->limit($qty)->update($data);
				break;
			case 'delete':
				switch ($modelName) {
					case 'users':
						DB::table($modelName)
							->limit($qty)
							->delete();
						break;
					default:
						$query = DB::table($modelName)->where('id', '!=', 0)->limit($qty)->delete();
						break;
				}
				break;
		}
		$queries = DB::getQueryLog();
		DB::connection()->disableQueryLog();
		DB::connection()->flushQueryLog();
		DB::rollback();
		$query = $queries[0]['query'];
		$bindings = $queries[0]['bindings'];
		
		$sql = new \stdClass();
		$sql->query = $query;
		$sql->bindings = $bindings;
		
		return $sql;
	}
	
	public function runMongoQuery($db, $modelName, $start_id, $end_id){
		switch ($modelName){
			case 'users':
				$result = $this->removeUsersFromMongoBD($db, 'range', $start_id, $end_id);
				break;
			default:
				$result = $db->$modelName->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
				break;
		}
		
		return $result;
	}
	
	private function removeUsersFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		$result = null;
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$users_ids = $db->users->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$users_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $users_ids);
			$result = $db->users->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$companies_ids = $db->companies->find(['user_id' => ['$in' => $users_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeCompaniesFromMongoBD($db, 'array', null, null, $companies_ids);
			
			$products = $db->products->find(['user_id' => ['$in' => $users_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeProductsFromMongoBD($db, 'array', null, null, $products);
			
			$documents = $db->documents->find(['user_id' => ['$in' => $users_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents);
			
			$entities = $db->entities->find(['user_id' => ['$in' => $users_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities);
		
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->users->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeCompaniesFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$companies_ids = $db->companies->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$companies_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $companies_ids);
			$result = $db->companies->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$entities = $db->entities->find(['company_id' => ['$in' => $companies_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities);
			
			$fiscalpos = $db->fiscalpos->find(['company_id' => ['$in' => $companies_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeFiscalPointOfSaleFromMongoBD($db, 'array', null, null, $fiscalpos);
			
			$products = $db->products->find(['company_id' => ['$in' => $companies_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeProductsFromMongoBD($db, 'array', null, null, $products);
			
			$categories = $db->categories->find(['company_id' => ['$in' => $companies_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeCategoriesFromMongoBD($db, 'array', null, null, $categories);
			
			$documents = $db->documents->find(['company_id' => ['$in' => $companies_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents);
			
			$pricelists = $db->pricelists->find(['company_id' => ['$in' => $companies_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removePricelistsFromMongoBD($db, 'array', null, null, $pricelists);
			
		} else if ($type === 'array'){
//			$array = array_map(function($a) { foreach ($a as $item) { return new ObjectID((string) $item);} }, $array);
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->companies->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeProductsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$products_ids = $db->products->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$products_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $products_ids);
			$result = $db->products->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$details = $db->details->find(['product_id' => ['$in' => $products_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeDetailsFromMongoBD($db, 'array', null, null, $details);
			
			$inventories = $db->inventories->find(['product_id' => ['$in' => $products_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeInventoriesFromMongoBD($db, 'array', null, null, $inventories);
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->products->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeDocumentsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$documents_ids = $db->documents->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$documents_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $documents_ids);
			$result = $db->documents->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$details = $db->details->find(['document_id' => ['$in' => $documents_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeDetailsFromMongoBD($db, 'array', null, null, $details);

//			$documents = $db->documents->find(['document_id' => ['$in' => $documents_ids]])->toArray();
//			$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents);
			
			$inventories = $db->inventories->find(['document_id' => ['$in' => $documents_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeInventoriesFromMongoBD($db, 'array', null, null, $inventories);
			
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->documents->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeEntitiesFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$entities_ids = $db->entities->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$entities_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $entities_ids);
			$result = $db->entities->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$documents = $db->documents->find(['entity_id' => ['$in' => $entities_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents);
			
			$transactions = $db->transactions->find(['entity_id' => ['$in' => $entities_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeTransactionsFromMongoBD($db, 'array', null, null, $transactions);
			
//			$entities = $db->entities->find(['entity_id' => ['$in' => $entities_ids]])->toArray();
//			$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities);
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->entities->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeFiscalPointOfSaleFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$result = $db->fiscalpos->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->fiscalpos->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeCategoriesFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$categories_ids = $db->categories->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$categories_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $categories_ids);
			$result = $db->categories->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$products = $db->products->find(['category_id' => ['$in' => $categories_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeProductsFromMongoBD($db, 'array', null, null, $products);
			
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->categories->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removePricelistsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$pricelists_ids = $db->pricelists->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$pricelists_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $pricelists_ids);
			$result = $db->pricelists->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
			$entities = $db->entities->find(['pricelist_id' => ['$in' => $pricelists_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities);
			
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->pricelists->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeTransactionsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);

//			$transactions_ids = $db->transactions->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
//			$transactions_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $transactions_ids);
			$result = $db->transactions->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->transactions->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeDetailsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);

			$details_ids = $db->details->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
			$details_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $details_ids);
			$result = $db->details->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);

			$inventories = $db->inventories->find(['detail_id' => ['$in' => $details_ids]], ['projection' => ['_id' => 1]])->toArray();
			$this->removeInventoriesFromMongoBD($db, 'array', null, null, $inventories);
		
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->details->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function removeInventoriesFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$result = $db->inventories->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		} else if ($type === 'array'){
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->inventories->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
}