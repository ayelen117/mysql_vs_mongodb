<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'qty',
		'current_stock_qty',
		'product_id',
		'detail_id',
		'unit_price',
		'total_price',
		'total',
	];

}
