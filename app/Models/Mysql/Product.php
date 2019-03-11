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
	
	/* belongsTo */
	
	public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}
	
	public function company()
	{
		return $this->belongsTo(Company::class);
	}
	
	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}
	
	public function tax()
	{
		return $this->belongsTo(Tax::class);
	}
	
	public function measure()
	{
		return $this->belongsTo(Measure::class);
	}
	
	public function parent()
	{
		return $this->belongsTo(Product::class, 'parent_id', 'id');
	}
	
	/* hasMany */
	
	public function details()
	{
		return $this->hasMany(Detail::class);
	}
	
	public function inventories()
	{
		return $this->hasMany(Inventory::class);
	}
	
	public function children()
	{
		return $this->hasMany(Product::class, 'parent_id', 'id');
	}
	
	// TODO: verificar relacion
	public function pricelistProducts()
	{
		return $this->hasMany(PricelistProduct::class);
	}
	
	/* belongsToMany */
	
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	
	public function pricelists()
	{
		return $this->belongsToMany(Pricelist::class, 'pricelist_product', 'product_id', 'pricelist_id')
			->withPivot('price', 'percent_subdist', 'percent_prevent');
	}
	
	public function measures()
	{
		return $this->belongsToMany(Measure::class)->withPivot('qty');
	}
	
	public function suppliers()
	{
		return $this->belongsToMany(Entity::class, 'product_supplier', 'product_id', 'supplier_id');
	}
	
	/* morphMany */
	
	public function photos()
	{
		return $this->morphMany(Photo::class, 'imageable');
	}
	
}
