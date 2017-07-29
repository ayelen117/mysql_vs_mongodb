<?php

namespace App\Helpers;

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
        $this->client = new Client();
    }

    public function getRelationships($data, $collection_name, $key){
        $this->$collection_name = $this->client->tesis->$collection_name;
        $relationships_id = $data[$key];

        $relationships = null;
        if ($relationships_id){
            if (is_array($relationships_id)){
                foreach ($relationships_id as $ky => $relationship_id){
                    $relationships_id[$ky] = new ObjectID($relationship_id);
                }
                $relationships = $this->$collection_name->find(['_id' => ['$in' => $relationships_id]]);

            } else {
                $relationships = $this->$collection_name->findOne(['_id' => new ObjectID($relationships_id)]);
            }
        }

        return $relationships;
    }

    public function setRelationships($data, $collection_name, $key){
        $relationships = $this->getRelationships($data, $collection_name, $key);
        $cursor_class = 'MongoDB\Driver\Cursor';

        if ($relationships){
            if ($relationships instanceof $cursor_class){
                $data[$key] = null;
                foreach ($relationships as $relationship){
                    $data[$key][] = new ObjectID($relationship->_id);
                }
            } else {
                $data[$key] = new ObjectID($relationships->_id);
            }
        }

        return $data;
    }
}