<?php namespace Pizarra\Managers;

class ElementoManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'Nombre'   => 'required|max:255',
			'fullname' => 'required|max:255',
			'clase_id' => 'required|digits_between:1,11'
		];

		return $rules;
	}
}