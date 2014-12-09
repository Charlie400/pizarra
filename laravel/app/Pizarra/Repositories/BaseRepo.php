<?php namespace Pizarra\Repositories;

abstract class BaseRepo
{
	public function __construct()
	{
		$this->model = $this->getModel();
	}

	abstract public function getModel();

	abstract public function getManager($entity, $datos);

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function findAll()
	{
		return $this->model->all();
	}

	//Crea un nuevo registro en base a un array de datos de los campos a rellenar
	public function createNewRecord(array $datos)
	{
		$entity  = $this->model;		
		$manager = $this->getManager($entity, $datos);

		if ($manager->save())
		{
			return true;
		}

		return $manager->errors();
	}
}