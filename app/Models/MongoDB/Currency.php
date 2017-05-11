<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Currency extends Moloquent {

    protected $connection = 'mongodb';

}

