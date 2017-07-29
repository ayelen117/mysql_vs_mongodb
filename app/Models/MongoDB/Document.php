<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Document extends Moloquent {

    protected $connection = 'mongodb';

}

