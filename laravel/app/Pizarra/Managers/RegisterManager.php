<?php namespace Pizarra\Managers;

class RegisterManager extends BaseManager
{
	public function getRules()
	{
		\Validator::extend('hashmatch', function($attribute, $value, $parameters)
		{	
		    return \Hash::check($value, \Auth::user()->password);
		});

		$rules = [
			'firstname'   => 'required|max:120',
			'lastname'    => 'required|max:120',
			'roles'		  => 'required|in:"alumno","admin"',
			'phone' 	  => 'digits:9',
			'email'       => 'required|email|max:120|unique:users,email,' . \Auth::user()->id,
			'username'    => 'required|max:120',
			'password'    => 'confirmed|max:150',
			'password_confirmation' => 'max:150',
			'oldpassword' => 'hashmatch:password',
			'nif'         => 'max:9',
			'adress'      => 'max:255',
			'locality'    => 'max:120',
			'province'    => 'max:120:',
			'cp'          => 'digits:5',
			'borndate'    => 'required',
			'obs'         => 'max:255',
			'id_dominio'  => 'required|numeric'
		];

		return $rules;
	}
}