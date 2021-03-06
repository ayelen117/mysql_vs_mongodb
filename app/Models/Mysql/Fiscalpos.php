<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Fiscalpos extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'number',
		'pos_type',
		'alias',
		'status',
		'company_id',
		'default',
		'fiscaltoken',
    ];

}
