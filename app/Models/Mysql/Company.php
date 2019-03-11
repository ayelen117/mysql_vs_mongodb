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
	
	/**
	 * ---------- BelongsTo
	 */
	
	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function responsibility()
	{
		return $this->belongsTo(Responsibility::class);
	}
	
	/**
	 * ---------- hasMany
	 */
	
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
	
	public function categories()
	{
		return $this->hasMany(Category::class);
	}
	
	public function documents()
	{
		return $this->hasMany(Document::class);
	}
	
	public function pricelists()
	{
		return $this->hasMany(Pricelist::class);
	}
	
	/**
	 * ---------- belongsToMany
	 */
	
	public function currencies()
	{
		return $this->belongsToMany(Currency::class);
	}
}
