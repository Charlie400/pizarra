<?php namespace Pizarra\Managers;

class ClaseManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'Nombre'     => 'required',
			'id_dominio' => 'required'
		];

		return $rules;
	}
}