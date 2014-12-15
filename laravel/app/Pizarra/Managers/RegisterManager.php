<?php namespace Pizarra\Managers;

class RegisterManager extends BaseManager
{
	public function getRules()
	{
		$rules = [
			'firstname' => 'required|max:120',
			'lastname'  => 'required|max:120',
			'roles'		=> 'required|in:"alumno","admin"',
			'phone' 	=> 'digits:9',
			'email'     => 'required|email|max:120|unique:users,email',
			'username'  => 'required|max:120',
			'password'  => 'required|confirmed|max:150',
			'password_confirmation' => 'required|max:150'
		];

		return $rules;
	}
}