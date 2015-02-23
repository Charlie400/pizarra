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

	public function getUserOrMaterials($relationship, $field, $id)
	{
		$pivots = $this->model
				->with($relationship)
				->where($field, $id)
				->get();

		$entity = array();

		foreach ($pivots as $pivot)
		{
			array_push($entity, $pivot->$relationship);
		}

		return $entity;
	}

	public function getUserMaterials($idUser) //Trae los materiales que tiene asignados un usuario
	{
		return $this->getUserOrMaterials('material', 'id_user', $idUser);
	}

	public function getMaterialUsers($idMaterial) //Trae los usuarios que tiene asignados un material
	{
		return $this->getUserOrMaterials('user', 'id_material', $idMaterial);
	}
}