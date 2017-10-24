<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Category extends Moloquent {

    protected $connection = 'mongodb';

}

