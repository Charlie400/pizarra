<?php namespace Pizarra\Repositories;

use Pizarra\Entities\DominioPivot;
use Pizarra\Managers\DominioPivotManager;

class DominioPivotRepo extends BaseRepo
{
	public function getModel()
	{
		return new DominioPivot();
	}

	public function getManager($entity, $datos)
	{
		return new DominioPivotManager($entity, $datos);
	}

	public function getTable()
	{
		return 'dominiopivot';
	}
}