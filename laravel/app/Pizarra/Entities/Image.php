<?php namespace Pizarra\Entities;

class Image extends \Eloquent {
	protected $fillable = ['url', 'id_dominio'];
	protected $table    = 'images';

	public function dominio()
	{
		return $this->hasOne('Pizarra\Entities\Dominio', 'id_dominio', 'id');
	}
}