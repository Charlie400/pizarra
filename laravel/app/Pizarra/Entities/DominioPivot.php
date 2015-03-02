<?php namespace Pizarra\Entities;

class DominioPivot extends \Eloquent {
	protected $fillable = ['id_dominio', 'id_user'];
	protected $table 	= 'dominiopivot';

	public function dominio()
	{
		return $this->hasOne('Pizarra\Entities\Dominio', 'id', 'id_dominio');
	}

	public function user()
	{
		return $this->hasOne('Pizarra\Entities\User', 'id', 'id_user');
	}
}