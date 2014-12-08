<?php namespace Pizarra\Repositories;

abstract class BaseRepo
{
	public function __construct()
	{
		$this->model = $this->getModel();
	}

	abstract public function getModel();

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function findAll()
	{
		return $this->model->all();
	}

	//Crea un nuevo registro en base a un array de datos y un array con los nombres de los campos a rellenar
	public function createNewRecord(array $datos, array $nombres)
	{
		$cDatos   = count($datos);
		$cNombres = count($nombres);

		if ($cDatos === $cNombres && $cDatos > 1)
		{
			for ($i = 0; $i < $cDatos; $i++)
			{
				$this->model->$nombres[$i] = $datos[$i];
			}

			$this->model->save();
		}
		elseif ($cDatos === $cNombres && $cDatos === 1)
		{
			$this->model->$nombres[0] = $datos[0];

			$this->model->save();
		}
	}
}