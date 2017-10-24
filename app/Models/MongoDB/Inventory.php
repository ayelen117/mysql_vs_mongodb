<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Inventory extends Moloquent {

    protected $connection = 'mongodb';

}

