<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Dominio;

class DominioRepo extends BaseRepo
{
	public function getModel()
	{
		return new Dominio();
	}
}