<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Dominio;
use Pizarra\Managers\DominioManager;

class DominioRepo extends BaseRepo
{
	public function getModel()
	{
		return new Dominio();
	}

	public function getManager($entity, $datos)
	{
		return new DominioManager($entity, $datos);
	}

	public function getTable()
	{
		return 'dominios';
	}
}