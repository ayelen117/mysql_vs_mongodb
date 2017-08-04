<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'name',
        'code_afip',
        'percent_value',
    ];

    /* belongsToMany */

    public function documents()
    {
        return $this->belongsToMany(Document::class)->withPivot('base_amount', 'differential_amount');
    }

    /* hasMany */

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
