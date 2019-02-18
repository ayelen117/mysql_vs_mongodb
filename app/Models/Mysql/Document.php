<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'author_id',
		'company_id',
		'entity_id',
		'seller_id',
		'currency_id',
		'receipt_id',
		'section',
		'receipt_type',
		'receipt_volume',
		'receipt_number',
		'total_commission',
		'total_cost',
		'total_net_price',
		'total_final_price',
		'emission_date',
		'cae',
		'cae_expiration_date',
		'observation',
		'status',
		'parent_id',
		'fiscal_observation',
		'canceled',
		'show_amounts',
	];
 
}
