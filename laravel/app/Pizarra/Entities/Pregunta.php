<?php namespace Pizarra\Entities;

class Pregunta extends \Eloquent {
	protected $fillable = ['pregunta', 'respuestas', 'id_test', 'valor'];
	protected $table    = 'preguntas';

	public function getTable()
	{
		return $this->table;
	}

	public function test()
	{
		return $this->hasOne('Pizarra\Entities\Test', 'id', 'id_test');
	}

	public function respuesta()
	{
		return $this->hasMany('Pizarra\Entities\Respuesta', 'id', 'id_pregunta');
	}
}