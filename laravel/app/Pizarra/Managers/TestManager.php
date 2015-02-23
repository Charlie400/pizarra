<?php namespace Pizarra\Managers;

class TestManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'titulo'      => 'required|max:120',
			'id_clase'    => 'required|numeric',
			'type'        => 'required',
			'preguntas'   => 'required|numeric',
			'respuestas'  => 'required|numeric',
			'active'      => 'required|in:0,1'
		];

		return $rules;
	}
}