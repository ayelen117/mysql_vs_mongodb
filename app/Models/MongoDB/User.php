<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class User extends Moloquent {

    protected $connection = 'mongodb';

}
