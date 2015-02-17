<?php namespace Pizarra\Managers;

class SupportMaterialManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'titulo'      => 'required|max:150',
			'descripcion' => 'required|max:1000',
			'documento'   => '',
			'desde' 	  => 'required',
			'hasta'       => 'required',
			'visible'     => 'required|in:0,1'			
		];

		return $rules;
	}
}