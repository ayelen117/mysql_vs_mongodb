<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	protected $guarded = [];
}
