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

	public function getTable()
	{
		return 'elementos';
	}
	
	public function borrarElementos($data)
	{
		$dir = public_path() . '/images/Elementos';
		foreach ($data as $id)
		{
			//Borramos el archivo del servidor
			$esc = $this->find($id);
			unlink($dir . '/' . $esc->fullname);
			
			//Borramos el registro de la base de datos
			$this->deleteRecord($id);

		}
	}

}