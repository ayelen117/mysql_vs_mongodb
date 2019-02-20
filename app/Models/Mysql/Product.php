<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $guarded = [];
    protected $fillable = [
		'name',
		'description',
		'barcode',
		'product_type',
		'duration',
		'stock_type',
		'replacement_cost',
		'author_id',
		'company_id',
		'category_id',
		'tax_id',
		'currency_id',
		'stock',
		'stock_alert',
		'stock_desired',
		'high',
		'width',
		'length',
		'weight',
		'weight_element',
	];

}
