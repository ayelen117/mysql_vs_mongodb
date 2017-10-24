<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Product extends Moloquent {

    protected $connection = 'mongodb';

}

