<?php namespace Pizarra\Repositories;

use Pizarra\Entities\User;

class AlumnosRepo extends BaseRepo
{
	public function getModel()
	{
		return new User();
	}
}