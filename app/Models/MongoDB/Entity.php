<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Entity extends Moloquent {

    protected $connection = 'mongodb';

}

