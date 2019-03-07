<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
            'name',
            'code_afip',
            'short_name',
            'measure_type',
            'factor',
        ];

    /* belongsToMany */

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
