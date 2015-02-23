<?php namespace Pizarra\Managers;

class PreguntaManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'pregunta'   => 'required|max:255', 
			'respuestas' => 'required|numeric', 
			'id_test'    => 'required|numeric'
		];

		return $rules;
	}
}