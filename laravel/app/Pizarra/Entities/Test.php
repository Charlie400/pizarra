<?php namespace Pizarra\Entities;

class Test extends \Eloquent {
	protected $fillable = ['titulo','id_clase','type','preguntas','respuestas','active'];
	protected $table    = 'tests';

	public function getTable()
	{
		return $this->table;
	}
}