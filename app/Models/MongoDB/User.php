<?php

namespace App\Models\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;
use App\Helpers\GeneralHelper;

class User extends Moloquent {

    protected $connection = 'mongodb';

    const RELATIONS = [];

    public function setRelationships(&$object){
        $helper = new GeneralHelper();

        foreach (self::RELATIONS as $relationship => $foreign_key){
            $helper->setRelationships($object, $relationship, $foreign_key);
        }
    }
	
	/**
	 * -------------------- HasMany
	 */
	
	/**
	 * Se referencia porque se de embeberlo superaría el límite disponible en los documentos.
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function companies()
	{
		return $this->hasMany(Company::class);
	}
	
	/**
	 * Se referencia porque se actualiza periódicamente
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function products()
	{
		return $this->hasMany(Product::class, 'author_id');
	}
	
	/**
	 * Se referencia porque se actualiza periódicamente
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function documents()
	{
		return $this->hasMany(Document::class, 'author_id');
	}
	
	/**
	 * Se referencia porque se actualiza periódicamente
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function entities()
	{
		return $this->hasMany(Entity::class, 'user_id');
	}
}
