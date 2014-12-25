<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Escenario;
use Pizarra\Managers\EscenarioManager;

class EscenarioRepo extends BaseRepo
{
	public function getModel()
	{
		return new Escenario();
	}

	public function getManager($entity, $datos)
	{
		return new EscenarioManager($entity, $datos);
	}

	public function getTable()
	{
		return 'escenarios';
	}
	
	public function borrarEscenarios($data)
	{
		$dir = public_path() . '/images/Escenarios';
		foreach ($data as $id)
		{
			//Borramos el archivo del servidor
			$element = $this->find($id);
			unlink($dir . '/' . $element->fullname);
			
			//Borramos el registro de la base de datos
			$this->deleteRecord($id);

		}
	}

}