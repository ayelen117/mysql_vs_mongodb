<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
	
	public function getSql($modelName, $operation, $maxAllowedRecords, $qty, $data = null, $ids = null)
	{
		if ($qty > $maxAllowedRecords) {
			if($operation === 'update'){
				foreach (array_chunk($ids, $maxAllowedRecords) as $id) {
					$sql[] = $this->getSqlData($operation, $modelName, $qty, $data, $id);
				}
			} else {
				foreach (array_chunk($data, $maxAllowedRecords) as $datum) {
					$sql[] = $this->getSqlData($operation, $modelName, $qty, $datum);
				}
			}
		} else {
			if($operation === 'update'){
				$sql = $this->getSqlData($operation, $modelName, $qty, $data, $ids);
			} else {
				$sql = $this->getSqlData($operation, $modelName, $qty, $data);
			}
		}
		
		return $sql;
	}
	
	public function getSqlData($operation, $modelName, $qty, $data = null, $ids = null)
	{
		DB::beginTransaction();
		DB::connection()->enableQueryLog();
		switch ($operation) {
			case 'list':
				switch ($modelName) {
					case 'users':
						$query = DB::table($modelName)
							->limit($qty)
							->get();
						break;
					case 'companies':
						$query = DB::table($modelName)
							->leftJoin('company_currency', 'companies.id', '=', 'company_currency.company_id')
							->leftJoin('currencies', 'currencies.id', '=', 'company_currency.currency_id')
							->select($modelName . '.*')
							->limit($qty)
							->get();
						break;
					case 'categories':
						$query = DB::table($modelName)
							->limit($qty)
							->get();
						break;
					case 'pricelists':
						$query = DB::table($modelName)
							->limit($qty)
							->get();
						break;
					case 'entities':
						$query = DB::table($modelName)
							->leftJoin('transactions', 'entities.id', '=', 'transactions.entity_id')
							->select($modelName . '.*')
							->limit($qty)
							->get();
						break;
					case 'documents':
						$query = DB::table($modelName)
							->leftJoin('details', 'documents.id', '=', 'details.document_id')
							->select($modelName . '.*')
							->limit($qty)
							->get();
						break;
					case 'products':
						$query = DB::table($modelName)
							->leftJoin('pricelist_product', 'products.id', '=', 'pricelist_product.product_id')
							->leftJoin('pricelists', 'pricelists.id', '=', 'pricelist_product.pricelist_id')
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
				$query = DB::table($modelName)->whereIn('id', $ids)->update($data);
				break;
			case 'delete':
				switch ($modelName) {
					default:
						$query = DB::table($modelName)->whereIn('id', $ids)->delete();
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
		$function = 'remove' . ucfirst($modelName) . 'FromMongoBD';
		$result = $this->$function($db, 'range', $start_id, $end_id);

		return $result;
	}
	
	private function removeUsersFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		$result = null;
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$users_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'users');
			$users_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $users_ids);
			
			$companies_ids = $this->getIdsFromArray($db, $users_ids, 'user_id', 'companies');
			$this->removeCompaniesFromMongoBD($db, 'array', null, null, $companies_ids);
			
			$products_ids = $this->getIdsFromArray($db, $users_ids, 'user_id', 'products');
			$this->removeProductsFromMongoBD($db, 'array', null, null, $products_ids);
			
			$documents_ids = $this->getIdsFromArray($db, $users_ids, 'user_id', 'documents');
			$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents_ids);
			
			$entities_ids = $this->getIdsFromArray($db, $users_ids, 'user_id', 'entities');
			$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities_ids);
			
			$result = $db->users->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		
		} else if ($type === 'array') {
			$array = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->users->deleteMany(['_id' => ['$in' => $array]]);
		}
		
		return $result;
	}
	
	private function getIdsFromArray($db, $parent_ids, $foreign_key, $modelName){
		$ids = $db->$modelName->find([$foreign_key => ['$in' => $parent_ids]], ['projection' => ['_id' => 1]])->toArray();
		
		return $ids;
	}
	
	private function getIdsFromRange($db, $start_id, $end_id, $modelName){
		$ids = $db->$modelName->find(['_id' => ['$gte' => $start_id, '$lte' => $end_id]], ['projection' => ['_id' => 1]])->toArray();
		
		return $ids;
	}
	
	private function removeCompaniesFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$companies_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'companies');
			$companies_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $companies_ids);
			$result = $db->companies->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
		} else if ($type === 'array'){
//			$array = array_map(function($a) { foreach ($a as $item) { return new ObjectID((string) $item);} }, $array);
			$companies_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->companies->deleteMany(['_id' => ['$in' => $companies_ids]]);
		}
		
		$companies_ids = array_map(function($a) { return (string) $a; }, $companies_ids);
		
		$entities_ids = $this->getIdsFromArray($db, $companies_ids, 'company_id', 'entities');
		$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities_ids);
		
		$fiscalpos_ids = $this->getIdsFromArray($db, $companies_ids, 'company_id', 'fiscalpos');
		$this->removeFiscalposFromMongoBD($db, 'array', null, null, $fiscalpos_ids);
		
		$products_ids = $this->getIdsFromArray($db, $companies_ids, 'company_id', 'products');
		$this->removeProductsFromMongoBD($db, 'array', null, null, $products_ids);
		
		$categories_ids = $this->getIdsFromArray($db, $companies_ids, 'company_id', 'categories');
		$this->removeCategoriesFromMongoBD($db, 'array', null, null, $categories_ids);
		
		$documents_ids = $this->getIdsFromArray($db, $companies_ids, 'company_id', 'documents');
		$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents_ids);
		
		$pricelists_ids = $this->getIdsFromArray($db, $companies_ids, 'company_id', 'pricelists');
		$this->removePricelistsFromMongoBD($db, 'array', null, null, $pricelists_ids);
		
		return $result;
	}
	
	private function removeProductsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$products_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'products');
			$products_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $products_ids);
			$result = $db->products->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		} else if ($type === 'array'){
			$products_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->products->deleteMany(['_id' => ['$in' => $products_ids]]);
		}
		
		$products_ids = array_map(function($a) { return (string) $a; }, $products_ids);
		
		$details_ids = $this->getIdsFromArray($db, $products_ids, 'product_id', 'details');
		$this->removeDetailsFromMongoBD($db, 'array', null, null, $details_ids);
		
		$inventories_ids = $this->getIdsFromArray($db, $products_ids, 'product_id', 'inventories');
		$this->removeInventoriesFromMongoBD($db, 'array', null, null, $inventories_ids);
		
		return $result;
	}
	
	private function removeDocumentsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$documents_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'documents');
			$documents_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $documents_ids);
			$result = $db->documents->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
		} else if ($type === 'array'){
			$documents_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->documents->deleteMany(['_id' => ['$in' => $documents_ids]]);
		}
		
		$documents_ids = array_map(function($a) { return (string) $a; }, $documents_ids);
		
		$details_ids = $this->getIdsFromArray($db, $documents_ids, 'document_id', 'details');
		$this->removeDetailsFromMongoBD($db, 'array', null, null, $details_ids);

//			$documents = $db->documents->find(['document_id' => ['$in' => $documents_ids]])->toArray();
//			$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents);
		
		$inventories_ids = $this->getIdsFromArray($db, $documents_ids, 'document_id', 'inventories');
		$this->removeInventoriesFromMongoBD($db, 'array', null, null, $inventories_ids);
		
		return $result;
	}
	
	private function removeEntitiesFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$entities_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'entities');
			$entities_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $entities_ids);
			$result = $db->entities->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		} else if ($type === 'array'){
			$entities_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->entities->deleteMany(['_id' => ['$in' => $entities_ids]]);
		}
		$entities_ids = array_map(function($a) { return (string) $a; }, $entities_ids);
		
		$documents_ids = $this->getIdsFromArray($db, $entities_ids, 'entity_id', 'documents');
		$this->removeDocumentsFromMongoBD($db, 'array', null, null, $documents_ids);
		
		$transactions_ids = $this->getIdsFromArray($db, $entities_ids, 'entity_id', 'transactions');
		$this->removeTransactionsFromMongoBD($db, 'array', null, null, $transactions_ids);

//			$entities = $db->entities->find(['entity_id' => ['$in' => $entities_ids]])->toArray();
//			$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities);
		
		return $result;
	}
	
	private function removeFiscalposFromMongoBD($db, $type, $start_id, $end_id, $array = []){
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
			
			$categories_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'categories');
			$categories_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $categories_ids);
			$result = $db->categories->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
		} else if ($type === 'array'){
			$categories_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->categories->deleteMany(['_id' => ['$in' => $categories_ids]]);
		}
		
		$categories_ids = array_map(function($a) { return (string) $a; }, $categories_ids);
		
		$products_ids = $this->getIdsFromArray($db, $categories_ids, 'category_id', 'products');
		$this->removeProductsFromMongoBD($db, 'array', null, null, $products_ids);
		
		return $result;
	}
	
	private function removePricelistsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);
			
			$pricelists_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'pricelists');
			$pricelists_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $pricelists_ids);
			$result = $db->pricelists->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
			
		} else if ($type === 'array'){
			$pricelists_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->pricelists->deleteMany(['_id' => ['$in' => $pricelists_ids]]);
		}
		
		$pricelists_ids = array_map(function($a) { return (string) $a; }, $pricelists_ids);
		
		$entities_ids = $this->getIdsFromArray($db, $pricelists_ids, 'pricelist_id', 'entities');
		$this->removeEntitiesFromMongoBD($db, 'array', null, null, $entities_ids);
		
		return $result;
	}
	
	private function removeTransactionsFromMongoBD($db, $type, $start_id, $end_id, $array = []){
		if ($type === 'range'){
			$start_id = new ObjectID($start_id);
			$end_id = new ObjectID($end_id);

//			$transactions_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'transactions');
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

			$details_ids = $this->getIdsFromRange($db, $start_id, $end_id, 'details');
			$details_ids = array_map(function($a) { foreach ($a as $item) { return (string) $item; } }, $details_ids);
			$result = $db->details->deleteMany(['_id' => ['$gte' => $start_id, '$lte' => $end_id]]);
		
		} else if ($type === 'array'){
			$details_ids = array_map(function($a) { foreach ($a as $item) { return $item;} }, $array);
			$result = $db->details->deleteMany(['_id' => ['$in' => $details_ids]]);
		}
		
		$details_ids = array_map(function($a) { return (string) $a; }, $details_ids);
		
		$inventories_ids = $this->getIdsFromArray($db, $details_ids, 'detail_id', 'inventories');
		$this->removeInventoriesFromMongoBD($db, 'array', null, null, $inventories_ids);
		
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
	
	public function getChildMongoDeletionQueries($modelName){
		$childDeletion = '';
		switch ($modelName){
			case 'users':
//				$childDeletion .= "<br>\$this->client->tesis->" . $modelName . "->find(['_id' => ['\$gte' => \$start_id, '\$lte' => \$end_id]], ['projection' => ['_id' => 1]])->toArray();";
				$childDeletion .= "<br>\$this->client->tesis->companies->deleteMany(['_id' => ['\$in' => \$companies_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('companies');
				$childDeletion .= "<br>\$this->client->tesis->documents->deleteMany(['_id' => ['\$in' => \$documents_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('documents');
				$childDeletion .= "<br>\$this->client->tesis->products->deleteMany(['_id' => ['\$in' => \$products_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('products');
				$childDeletion .= "<br>\$this->client->tesis->entities->deleteMany(['_id' => ['\$in' => \$entities_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('entities');
				$childDeletion .= "<br>\$this->client->tesis->documents->deleteMany(['_id' => ['\$in' => \$_ids]])";
				break;
			case 'companies':
				$childDeletion .= "<br>\$this->client->tesis->entities->deleteMany(['_id' => ['\$in' => \$entities_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('entities');
				$childDeletion .= "<br>\$this->client->tesis->fiscalpos->deleteMany(['_id' => ['\$in' => \$fiscalpos_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('fiscalpos');
				$childDeletion .= "<br>\$this->client->tesis->products->deleteMany(['_id' => ['\$in' => \$products_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('products');
				$childDeletion .= "<br>\$this->client->tesis->categories->deleteMany(['_id' => ['\$in' => \$categories_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('categories');
				$childDeletion .= "<br>\$this->client->tesis->documents->deleteMany(['_id' => ['\$in' => \$documents_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('documents');
				$childDeletion .= "<br>\$this->client->tesis->pricelists->deleteMany(['_id' => ['\$in' => \$pricelists_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('pricelists');
				break;
			case 'categories':
				$childDeletion .= "<br>\$this->client->tesis->products->deleteMany(['_id' => ['\$in' => \$products_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('products');
				break;
			case 'pricelists':
				$childDeletion .= "<br>\$this->client->tesis->entities->deleteMany(['_id' => ['\$in' => \$entities_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('entities');
				break;
			case 'entities':
				$childDeletion .= "<br>\$this->client->tesis->documents->deleteMany(['_id' => ['\$in' => \$documents_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('documents');
				$childDeletion .= "<br>\$this->client->tesis->transactions->deleteMany(['_id' => ['\$in' => \$transactions_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('transactions');
				break;
			case 'documents':
				$childDeletion .= "<br>\$this->client->tesis->details->deleteMany(['_id' => ['\$in' => \$details_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('details');
				$childDeletion .= "<br>\$this->client->tesis->inventories->deleteMany(['_id' => ['\$in' => \$inventories_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('inventories');
				break;
			case 'products':
				$childDeletion .= "<br>\$this->client->tesis->details->deleteMany(['_id' => ['\$in' => \$details_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('details');
				$childDeletion .= "<br>\$this->client->tesis->inventories->deleteMany(['_id' => ['\$in' => \$inventories_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('inventories');
				break;
			case 'details':
				$childDeletion .= "<br>\$this->client->tesis->inventories->deleteMany(['_id' => ['\$in' => \$inventories_ids]])";
				$childDeletion .= $this->getChildMongoDeletionQueries('inventories');
				break;
//			case 'fiscalpos':
//				break;
//			case 'transactions':
//				break;
//			case 'inventories':
//				break;
			default:
				break;
		}
		
		return $childDeletion;
	}
	
	public function clearCache($modelName){
		Log::info('Limpiando la cache...');
		$os = strtoupper(substr(PHP_OS, 0, 3));
		if($os === 'DAR'){
			shell_exec('sync && echo ' . env('PASS') . ' | sudo purge -S ');
		} else if ($os === 'LIN'){
			shell_exec('sync && sudo sysctl -w vm.drop_caches=3'); // funciona
		}
		
		DB::statement("RESET QUERY CACHE;");
		DB::statement("FLUSH TABLES;");
		
		$this->client->tesis->command(['planCacheClear' => $modelName])->toArray();
		$this->client->tesis->command([ 'planCacheClearFilters' => $modelName])->toArray();
	}
	
}