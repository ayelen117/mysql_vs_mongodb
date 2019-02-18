<?php

namespace App\Models\Mysql;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class User extends Authenticatable
{
    use Notifiable, HybridRelations;

    protected $connection = 'mysql';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'remember_token',
		'activated',
		'banned',
		'super_admin',
		'activation_code',
		'activated_at',
		'last_login',
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];
}
