<?php namespace Pizarra\Entities;

class Dominio extends \Eloquent {
	protected $fillable = ['Nombre'];

	public function clase()
	{
		return $this->hasMany('Pizarra\Entities\Clase', 'id_dominio', 'id');
	}

}