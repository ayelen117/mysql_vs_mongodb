<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class PricelistProduct extends Model
{
    protected $connection = 'mysql';
    protected $table = 'pricelist_product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'pricelist_id',
		'price',
		'percent_subdist',
		'percent_prevent',
		'activated',
	];
}
