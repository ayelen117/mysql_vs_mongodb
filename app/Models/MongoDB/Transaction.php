<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Transaction extends Moloquent {

    protected $connection = 'mongodb';

}

