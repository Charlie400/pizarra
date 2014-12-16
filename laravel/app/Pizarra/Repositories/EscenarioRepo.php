<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Escenario;
//use Pizarra\Managers\EscenarioManager;

class EscenarioRepo extends BaseRepo
{
	public function getModel()
	{
		return new Escenario();
	}

	public function getManager($entity, $datos)
	{
		//return new EscenarioManager($entity, $datos);
	}

	public function borrarEscenarios($data)
	{
		foreach ($data as $id)
		{
			$this->deleteRecord($id);
		}
	}
}