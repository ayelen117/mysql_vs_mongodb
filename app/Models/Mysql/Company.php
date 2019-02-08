<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'mysql';
	protected $fillable = [
		'name',
		'status',
		'user_id',
		'abbreviation',
		'description',
		'cuit',
		'legal_name',
		'street_name',
		'street_number',
		'phone',
		'fiscal_ws',
		'fiscal_ws_status',
		'responsibility_id',
	];
	
	public function entities()
	{
		return $this->hasMany(Entity::class);
	}

	public function fiscalPointsOfSale()
	{
		return $this->hasMany(FiscalPos::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
	
}
