<?php namespace Pizarra\Entities;

class Respuesta extends \Eloquent {
	protected $fillable = ['respuesta', 'id_test', 'id_pregunta', 'correcta'];
	protected $table    = 'respuestas';

	public function getTable()
	{
		return $this->table;
	}

	public function test()
	{
		return $this->hasOne('Pizarra\Entities\Test', 'id', 'id_test');
	}

	public function pregunta()
	{
		return $this->hasOne('Pizarra\Entities\Pregunta', 'id_pregunta', 'id');
	}
}