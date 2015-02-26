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

	public function isVisible($idMaterial)
	{
		$material = $this->find($idMaterial);

		if ( ! is_null($material) )
		{
			if ($material->visible) return true;

			$now = $this->currentDate();

			if ($now > $material->desde && $now < $material->hasta) return true;
		}

		return false;
	}

	public function areVisibles(array $idMaterial) //Recibe un array de ids y duevuelve solo las que son visibles
	{
		$materials = $this->model->whereIn('id', $idMaterial)->get();

		$visibles  = array();

		foreach ($materials as $material)
		{
			if ( ! is_null($material) )
			{
				if ($material->visible) array_push($visibles, $material->id);

				$now = $this->currentDate();

				if ( ! $material->visible && $now > $material->desde && $now < $material->hasta) 
					array_push($visibles, $material->id);
			}
		}

		return $visibles;
	}

	public function getVisibles()
	{
		$now = $this->currentDate();

		return $this->model
				->where('desde', '<', $now)
				->where('hasta', '>', $now)
				->orWhere('visible', 1)
				->get();
	}

	public function deleteMaterial($idMaterial)
	{
		return $this->find($idMaterial)->delete();
	}	
}