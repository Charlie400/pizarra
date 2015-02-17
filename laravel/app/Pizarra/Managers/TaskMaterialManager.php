<?php namespace Pizarra\Managers;

class TaskMaterialManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'titulo'      => 'required|max:150',
			'descripcion' => 'required|max:1000',
			'time'        => 'required',
			'testType'    => 'required',
			'examen'      => 'required|in:0,1',
			'desde' 	  => '',
			'hasta'       => '',
			'visible'     => 'required|in:0,1'	
		];

		return $rules;
	}
}