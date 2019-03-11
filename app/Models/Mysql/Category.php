<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
		'parent_id',
	];
	
	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
