<?php namespace Pizarra\Repositories;

use Pizarra\Entities\User;
use Pizarra\Managers\RegisterManager;

class AlumnosRepo extends BaseRepo
{
	public function getModel()
	{
		return new User();
	}

	public function getManager($entity, $datos)
	{
		return new RegisterManager($entity, $datos);
	}
}