<?php namespace Pizarra\Entities;

class Material extends \Eloquent {
	protected $fillable = ['time', 'testtype', 'examen', 'titulo', 'descripcion', 'documento', 'desde', 'hasta', 'visible'];
	protected $table    = 'materiales';

	public function getTable()
	{
		return $this->table;
	}
}