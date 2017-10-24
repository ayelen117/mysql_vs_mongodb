<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class PricelistProduct extends Moloquent {

    protected $connection = 'mongodb';

}

