<?php namespace Pizarra\Repositories;

use Pizarra\Entities\Test;
use Pizarra\Managers\TestManager;

class TestRepo extends BaseRepo
{
	protected $manager;

	public function getModel()
	{
		return new Test();
	}

	public function getManager($entity, $datos)
	{
		return new TestManager($entity, $datos);
	}

	public function defaultManager($entity, $datos)
	{
		$this->manager = new TestManager($entity, $datos);
		return $this->manager;
	}

	public function newGetManager()
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