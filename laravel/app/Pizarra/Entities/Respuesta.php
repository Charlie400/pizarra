<?php namespace Pizarra\Entities;

class Respuesta extends \Eloquent {
	protected $fillable = ['respuesta', 'id_test', 'id_pregunta'];
	protected $table    = 'respuestas';

	public function getTable()
	{
		return $this->table;
	}
}