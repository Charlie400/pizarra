<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Clase;

class ClaseRepo extends BaseRepo
{
	public function getModel()
	{
		return new Clase();
	}
}