<?php

namespace App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measure extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
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
