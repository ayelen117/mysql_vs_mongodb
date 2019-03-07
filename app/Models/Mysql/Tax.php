<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $dates = ['created_at', 'updated_at'];
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
