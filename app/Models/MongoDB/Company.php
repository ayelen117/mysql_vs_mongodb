<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Company extends Moloquent {

    protected $connection = 'mongodb';

}

