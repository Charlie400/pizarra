<?php namespace Pizarra\Managers;

class ImageManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'url'        => 'required|max:255',
			'id_dominio' => 'required|numeric'
		];

		return $rules;
	}
}