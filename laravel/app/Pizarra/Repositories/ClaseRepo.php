<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Clase;
use Pizarra\Managers\ClaseManager;

class ClaseRepo extends BaseRepo
{
	public function getModel()
	{
		return new Clase();
	}

	public function getManager($entity, $datos)
	{
		return new ClaseManager($entity, $datos);
	}
}