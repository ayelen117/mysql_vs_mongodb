<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;
use App\Helpers\GeneralHelper;

class User extends Moloquent {

    protected $connection = 'mongodb';

    const RELATIONS = [];

    public function setRelationships(&$object){
        $helper = new GeneralHelper();

        foreach (self::RELATIONS as $relationship => $foreign_key){
            $helper->setRelationships($object, $relationship, $foreign_key);
        }
    }

}
