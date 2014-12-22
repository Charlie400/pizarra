<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Elemento;
use Pizarra\Managers\ElementoManager;

class ElementoRepo extends BaseRepo
{
	public function getModel()
	{
		return new Elemento();
	}

	public function getManager($entity, $datos)
	{
		return new ElementoManager($entity, $datos);
	}
}