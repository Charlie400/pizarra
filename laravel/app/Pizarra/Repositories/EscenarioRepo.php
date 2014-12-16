<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Escenario;
use Pizarra\Managers\RegisterManager;

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

	public function getChecked(&$data)
	{
		//para que funcione hay que añadir un foreach a la vista en el que se valla concatenando un número incremental
		//al name; ejemplo: id . $i, checkbox . $i
		$null = array_where($data, function ($key, $val)
		{			
			return is_null($val);
		});

		$null  = array_keys($null);
		$count = count($null);

		for ($i = 0; $i < $count; $i++)
		{
			$n = $null[$i];

			$number = $this->numberFromString($n);

			unset($data['id' . $number], $data['checkbox' . $number]);
		}

		$keys    = array_keys($data);
		$count   = count($keys);
		$numbers = array();

		for ($i = 0; $i < $count; $i++)
		{
			$key = $this->numberFromString($keys[$i]);

			if ( isset($data['checkbox' . $key]) )
			{
				unset($data['checkbox' . $key]);
			}
		}
	}	

	public function borrarEscenarios($data)
	{
		$this->getChecked($data);

		foreach ($data as $key => $id)
		{
			$this->deleteRecord($id);
		}
	}
}