<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'due_date',
		'amount',
		'currency_id',
		'observations',
    ];
}
