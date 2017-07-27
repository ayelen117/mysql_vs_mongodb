<?php

namespace App\Helpers;

use MongoDB\Client;
/**
 * Created by PhpStorm.
 * User: ayelen
 * Date: 27/07/17
 * Time: 18:06
 */
class TestHelper
{
    public $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function getRandomObjects($collection_name, $limit){
        $this->$collection_name = $this->client->tesis->$collection_name;
        $total = $this->$collection_name->count();
        $skip = mt_rand(0, $total);
        $options = [
            'skip' => $skip < 0 ? 0 : $skip,
            'limit' => $limit,
        ];
        if ($limit > 1){
            $objects = $this->$collection_name->find([], $options);
        } else {
            $objects = $this->$collection_name->findOne([], $options);
        }

        return $objects;
    }

    public function addRandomObjectToArray($array, $collection_name, $key, $limit = 1){
        $objects = $this->getRandomObjects($collection_name, $limit);
        if ($limit > 1) {
            foreach ($objects as $object){
                $array[$key][] = (string)$object['_id'];
            }
        } else {
            $array[$key] = (string)$objects['_id'];
        }

        return $array;
    }
}