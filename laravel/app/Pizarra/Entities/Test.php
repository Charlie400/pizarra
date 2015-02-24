<?php namespace Pizarra\Entities;

class Test extends \Eloquent {
	protected $fillable = ['titulo','id_clase','id_category','preguntas','respuestas','active', 'puntuacion'];
	protected $table    = 'tests';

	public function getTable()
	{
		return $this->table;
	}

	public function pregunta()
	{
		return $this->hasMany('Pizarra\Entities\Pregunta', 'id_test', 'id');
	}

	public function respuesta()
	{
		return $this->hasMany('Pizarra\Entities\Respuesta', 'id_test', 'id');	
	}
}