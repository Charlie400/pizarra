<?php namespace Pizarra\Entities;

class Pregunta extends \Eloquent {
	protected $fillable = ['pregunta', 'respuestas', 'id_test'];
	protected $table    = 'preguntas';

	public function getTable()
	{
		return $this->table;
	}
}