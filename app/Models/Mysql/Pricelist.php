<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
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
		'percent_price',
		'percent_subdist',
		'percent_prevent',
    ];
	
	
	public function entities()
	{
		return $this->hasMany(Entity::class);
	}
	
	public function products()
	{
		return $this->belongsToMany(Product::class);
	}
}
