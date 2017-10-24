<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Receipt extends Moloquent {

    protected $connection = 'mongodb';

}

