<?php namespace Pizarra\Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $fillable = ['firstname', 'lastname', 'username', 'password', 'email', 'borndate',
						   'phone', 'roles', 'nif', 'adress', 'locality', 'province', 'cp', 'obs'];
	protected $format   = 'Y-m-d H:i:s';

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = \Hash::make($value);
	}

	public function dominioPivot()
	{
		return $this->hasMany('Pizarra\Entities\DominioPivot', 'id_user', 'id');
	}

	public function setBorndateAttribute($value)
	{
		$this->attributes['borndate'] = $this->dateFormat($value);
	}

	public function dateFormat($date)
	{
		$check = explode('/', $date);
		if (count($check) > 1) $date = implode('-', $check);

		$date = new \DateTime($date);

		return $date->format($this->format);
	}

}