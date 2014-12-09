<?php namespace Pizarra\Managers;

class DominioManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'Nombre'     => 'required'
		];

		return $rules;
	}
}