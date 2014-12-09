<?php namespace Pizarra\Managers;

class RegisterManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'username' => 'required',
			'password' => 'required|confirmed',
			'password_confirmation' => 'required'
		];

		return $rules;
	}
}