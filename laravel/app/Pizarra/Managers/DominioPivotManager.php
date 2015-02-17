<?php namespace Pizarra\Managers;

class DominioPivotManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'id_dominio' => 'required|numeric',
			'id_user'    => 'required|numeric'
		];

		return $rules;
	}
}