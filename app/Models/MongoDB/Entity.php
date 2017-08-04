<?php

namespace App\Models\MongoDB;

use App\Helpers\GeneralHelper;
use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Entity extends Moloquent {

    protected $connection = 'mongodb';

    const RELATIONS = [
        'companies' => 'company_id',
        'users' => 'author_id',
        'identifications' => 'identification_id',
        'pricelists' => 'pricelist_id',
        'responsibilities' => 'responsibility_id',
    ];

    public function setRelationships(&$object){
        $helper = new GeneralHelper();

        foreach (self::RELATIONS as $relationship => $foreign_key){
            $helper->setRelationships($object, $relationship, $foreign_key);
        }
    }

}

