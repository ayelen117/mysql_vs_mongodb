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
	
	public function children()
	{
		return $this->hasMany(Product::class, 'parent_id', 'id');
	}
	
	public function details()
	{
		return $this->hasMany(Detail::class);
	}
	
	// TODO: verificar relacion
	public function pricelistProducts()
	{
		return $this->hasMany(PricelistProduct::class);
	}
	
	public function recordPrices()
	{
		return $this->hasMany(RecordPrice::class);
	}
	
	public function futurePrices()
	{
		return $this->hasMany(FuturePrice::class);
	}
	
	public function productNameHistorials()
	{
		return $this->hasMany(ProductNameHistorial::class);
	}
	
	/* belongsToMany */
	
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	
	public function inventories()
	{
		return $this->hasMany(Inventory::class);
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
	
	public function getPrice($pricelist)
	{
		if (is_numeric($pricelist)) {
			$pricelist_id = $pricelist;
		} else {
			$pricelist_id = $pricelist->id;
		}
		
		$pricelistProduct = PricelistProduct::whereProductId($this->id)
			->wherePricelistId($pricelist_id)
			->first();
		
		if ($pricelistProduct) {
			$price = $pricelistProduct->price;
//			$price_subdist = $pricelistProduct->price_subdist_cache;
//			$price_prevent = $pricelistProduct->price_prevent_cache;
//			$pivot_price = $pricelistProduct->price;
//			$pivot_percent_prevent = $pricelistProduct->pivot_percent_prevent;
		} else {
			$pricelistProduct = new PricelistProduct();
			$pricelistProduct->product_id = $this->id;
			$pricelistProduct->pricelist_id = $pricelist_id;
			$pricelistProduct->price = rand(0, 100);
			$pricelistProduct->percent_subdist = rand(0, 100);
			$pricelistProduct->percent_prevent = rand(0, 100);
			$pricelistProduct->save();
			$price = $pricelistProduct->price;
//			$price_subdist = $pricelistProduct->price_subdist_cache;
//			$price_prevent = $pricelistProduct->price_prevent_cache;
//			$pivot_price = $pricelistProduct->price;
//			$pivot_percent_prevent = $pricelistProduct->pivot_percent_prevent;
		}
		
		//Devuelvo un objeto con todos los valores
		$stdClass = new \stdClass();
		$stdClass->price = round($price, 2);
//		$stdClass->price_prevent = round($price_prevent, 2);
//		$stdClass->price_subdist = round($price_subdist, 2);
//		$stdClass->pivot_price = $pivot_price;
//		$stdClass->pivot_percent_prevent = $pivot_percent_prevent;
		
		return $stdClass;
	}
	
	/**
	 * @param $value
	 *
	 * @return float
	 */
	public function applyTax($value)
	{
		$percent_value = $this->tax->percent_value;
		$result = $this->applyTaxToPrice($value, $percent_value);
		
		return $result;
	}
	
	/**
	 * @param $value
	 *
	 * @return float
	 */
	public function removeTax($value)
	{
		$percent_value = $this->tax->percent_value;
		$result = $this->removeTaxToPrice($value, $percent_value);
		
		return $result;
	}
	
	/**
	 * @param $value
	 * @param $taxValue
	 *
	 * @return float
	 */
	public function applyTaxToPrice($value, $taxValue)
	{
		$percentValue = $taxValue / 100;
		$costTax = $percentValue * $value;
		$costTax = $value + $costTax;
		
		return round($costTax, 2);
	}
	
	//Saco el impuesto
	/**
	 * @param $value
	 * @param $taxValue
	 *
	 * @return float
	 */
	public function removeTaxToPrice($value, $taxValue)
	{
		$percentValue = ($taxValue / 100) + 1;
		$costTax = $value / $percentValue;
		
		return round($costTax, 2);
	}
	
	public function updateParentStock($parent = null)
	{
		if (!$parent) {
			if ($this->conduct != 'variant_common') {
				return;
			}
			$parent = Product::find($this->parent_id);
		}
		
		$sum = Product::where('parent_id', $parent->id)->sum('stock');
		$parent->update(['stock' => $sum]);
	}
}
