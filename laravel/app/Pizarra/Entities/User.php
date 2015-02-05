<?php namespace Pizarra\Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $fillable = ['firstname', 'lastname', 'username', 'password', 'email', 'id_dominio',
						   'phone', 'roles', 'nif', 'adress', 'locality', 'province', 'cp', 'obs'];

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = \Hash::make($value);
	}

	public function getIdDominioAttribute($value)
	{
		return explode(',', $value);
	}

	public function setIdDominioAttribute($value)
	{
		return $this->attributes['id_dominio'] = implode(',', $value);
	}
}