<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
}
