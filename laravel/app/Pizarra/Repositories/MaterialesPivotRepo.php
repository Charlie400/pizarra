<?php namespace Pizarra\Repositories;

use Pizarra\Entities\MaterialPivot;
use Pizarra\Managers\MaterialesPivotManager;

class MaterialesPivotRepo extends BaseRepo
{
	public function getModel()
	{
		return new MaterialPivot();
	}

	public function getManager($entity, $datos)
	{
		return new MaterialesPivotManager($entity, $datos);
	}

	public function getTable()
	{
		return 'materialespivot';
	}

	public function getUserMaterials($idUser) //Trae los materiales que tiene asignados un usuario
	{
		$pivots = $this->model
				->with('material')
				->where('id_user', $idUser)
				->get();

		$materials = array();

		foreach ($pivots as $pivot)
		{
			array_push($materials, $pivot->material);
		}

		return $materials;
	}

	public function getMaterialUsers($idMaterial) //Trae los usuarios que tiene asignados un material
	{
		$pivots = $this->model
				->with('user')
				->where('id_material', $idMaterial)
				->get();

		$users = array();

		foreach ($pivots as $pivot)
		{
			array_push($users, $pivot->user);
		}

		return $users;
	}
}