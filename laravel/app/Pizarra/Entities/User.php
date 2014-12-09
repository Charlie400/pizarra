<?php namespace Pizarra\Entities;

class User extends \Eloquent {
	protected $fillable = ['username', 'password'];

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = \Hash::make($value);
	}
}