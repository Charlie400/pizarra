<?php namespace Pizarra\Managers;

class LoginManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'username' => 'required|exists:users',
			'password' => 'required'
		];

		return $rules;
	}
}