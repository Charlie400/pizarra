<?php namespace Pizarra\Managers;

class RespuestaManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'respuesta'   => 'required|max:255', 
			'id_test'     => 'required|numeric', 
			'id_pregunta' => 'required|numeric',
			'correcta'	  => 'required|in:0,1'
		];

		return $rules;
	}
}