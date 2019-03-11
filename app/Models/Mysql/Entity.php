<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
	protected $connection = 'mysql';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'company_id',
		'author_id',
		'identification_id',
		'identification_number',
		'contact_name',
		'street_name',
		'street_number',
		'latitude',
		'longitude',
		'additional_info',
		'email',
		'phone',
		'pricelist_id',
		'entity_type',
		'responsibility_id',
		'observations',
		'has_account',
		'balance',
		'balance_at',
	];
	
	public function documents()
	{
		return $this->hasMany(Document::class);
	}
	
	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
	
	public function entities()
	{
		return $this->hasMany(Entity::class);
	}
}
