<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Detail extends Model
{
    protected $connection = 'mysql';
    protected $fillable = [
    	'document_id',
		'qty',
		'product_id',
		'calculated_inventory_cost',
		'net_unit_price',
		'final_unit_price',
		'commission',
		'subdist_price' ,
	];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $guarded = [];
	
	
	public function inventories()
	{
		return $this->hasMany(Inventory::class);
	}
}
