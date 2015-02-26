<?php namespace Pizarra\Entities;

class MaterialPivot extends \Eloquent {
	protected $fillable = ['id_material', 'id_user'];
	protected $table 	= 'materialespivot';

	public function material()
	{
		return $this->hasOne('Pizarra\Entities\Material', 'id', 'id_material');
	}

	public function user()
	{
		return $this->hasOne('Pizarra\Entities\User', 'id', 'id_user');
	}
}