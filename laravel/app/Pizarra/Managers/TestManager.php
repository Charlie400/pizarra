<?php namespace Pizarra\Managers;

class TestManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'titulo'      => 'required|max:120',
			'id_clase'    => 'numeric',
			'id_category' => 'required|numeric',
			'preguntas'   => 'required|numeric',
			'respuestas'  => 'required|numeric',
			'active'      => 'required|in:0,1',
			'puntuacion'  => 'required|numeric'
		];

		return $rules;
	}
}