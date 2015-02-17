<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Material;
use Pizarra\Managers\SupportMaterialManager;

class MaterialRepo extends BaseRepo
{
	protected $manager;

	public function getModel()
	{
		return new Material();
	}

	public function getManager($entity, $datos)
	{
		return new SupportMaterialManager($entity, $datos);
	}

	public function defaultManager($entity, $datos)
	{
		$this->manager = new SupportMaterialManager($entity, $datos);
		return $this->manager;
	}

	public function newgetManager()
	{
		return $this->manager;
	}

	public function setManager($manager)
	{
		$this->manager = $manager;
	}

	public function getTable()
	{
		return $this->model->getTable();
	}	
}