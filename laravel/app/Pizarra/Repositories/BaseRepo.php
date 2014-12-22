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

	public function last()
	{
		$all = $this->findAll();
		return $all->last();
	}

	public function deleteRecord($id)
	{
		$model = $this->find($id);
		$model->delete();
	}

	//Crea un nuevo registro en base a un array de datos de los campos a rellenar
	public function createNewRecord(array $datos, $entity = "")
	{		
		if (empty($entity))
		{
			$entity = $this->model;
		}

		$manager = $this->getManager($entity, $datos);

		if ($manager->save())
		{
			return true;
		}

		return $manager->errors();
	}

	public function numberFromString($string)
	{
		return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
	}
}