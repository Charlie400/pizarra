<?php namespace Pizarra\Managers;

class MaterialesPivotManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'id_material' => 'required|numeric',
			'id_user'     => 'required|numeric'
		];

		return $rules;
	}
}