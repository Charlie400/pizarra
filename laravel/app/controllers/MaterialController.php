<?php

use Pizarra\Repositories\MaterialRepo;
use Pizarra\Repositories\MaterialesPivotRepo as PivotRepo;

//for get FileController
use Pizarra\Repositories\EscenarioRepo;
use Pizarra\Repositories\ElementoRepo;

use Pizarra\Managers\TaskMaterialManager as TaskManager;

class MaterialController extends BaseController {

	protected $materialRepo;
	protected $fileController;

	public function __construct(MaterialRepo $materialRepo, PivotRepo $pivotRepo, EscenarioRepo $escenarioRepo, 
								ElementoRepo $elementoRepo)
	{
		$this->materialRepo   = $materialRepo;
		$this->pivotRepo      = $pivotRepo;
		$this->fileController = new FileController($escenarioRepo, $elementoRepo);
	}

	//BEGIN CRUD

	public function baseEditCreateMaterial($preFuncion, $material = false, $manager = false)
	{
		$type = Input::only('typeAsignacion')['typeAsignacion'];

		if ( ! is_null($type) )
		{
			if ( $type ) 
			{
				$data  = Input::only('titulo', 'descripcion', 'testType', 'time', 'examen', 'desde', 'hasta', 
									 'visible', 'id_dominio');				

				$manager = new TaskManager($this->materialRepo->getModel(), $data);

				$checkboxs = ['examen', 'visible'];

				$funcion = $preFuncion . 'TaskMaterial';
			}
			else
			{ 
				$data  = Input::only('titulo', 'descripcion', 'desde', 'hasta', 'visible', 'id_dominio');

				$checkboxs = ['visible'];

				$funcion = $preFuncion . 'SupportMaterial';
			}
			
			$data = $this->materialRepo->processCheckboxs($data, $checkboxs);			

			return $this->{$funcion}($data, $manager, $material);
		}

		return Redirect::back();
	}

	public function createMaterial()
	{
		dd($this->baseEditCreateMaterial('create'));
	}

	public function createSupportMaterial($data, $manager, $material)
	{
		return $this->supportMaterial($data, $manager, $material);
	}

	public function createTaskMaterial($data, $manager, $material)
	{
		return $this->taskMaterial($data, $manager, $material);
	}

	public function supportMaterial($data, $manager, $material)
	{
		if ( ! isset($_FILES['documento'])) return false;

		$hasDocument = false;
		$file  = $_FILES['documento'];

		if ( ! empty($file['name']) && ! empty($file['tmp_name']))
		{
			$dir   = public_path() . '/Documentos/' . $file['name'];		
			$allow = ['pdf', 'doc', 'odt', 'avi', 'wmv', 'mpeg', 'mov', 'flv', 'jpg'];
			$hasDocument = true;

			$data['documento'] = $dir;
		}

		if ( ! $hasDocument or $this->fileController->uploadFooFile($file, $allow, $dir))
		{
			return $this->materialRepo->newCreateNewRecord($data, false, $material);
		}

		return false;
	}

	public function taskMaterial($data, $manager, $material)
	{
		if ( ! $data['examen']) unset($data['time']);

		return $this->materialRepo->newCreateNewRecord($data, $manager, $material);
	}

	/*FUNCIONALIDADES POR CONECTAR*/

	public function editMaterial()
	{
		$idMaterial = Input::only('id_material')['id_material'];

		if ( ! is_null($idMaterial) )
		{
			$material = $this->materialRepo->find($idMaterial);

			if( ! is_null($material) ) dd($this->baseEditCreateMaterial('edit', $material));
		}

		echo "Debes pasar una id de material válida";
	}

	public function editSupportMaterial($data, $manager, $material)
	{
		return $this->supportMaterial($data, $manager, $material);
	}

	public function editTaskMaterial($data, $manager, $material)
	{
		return $this->taskMaterial($data, $manager, $material);
	}

	//END CRUD

	public function subscribeUserToMaterial()
	{
		$data = Input::only('id_user', 'id_material');

		$this->pivotRepo->subscribeMaterial($data['id_user'], $data['id_material']);
	}

	public function getMaterial($id)
	{
		$material = $this->materialRepo->find($id);

		if ( ! is_null($material))
		{
			echo json_encode($material);
		}
		else
		{
			throw new Error("No existe el material consultado.");
		}
	}

	/*FIN FUNCIONALIDADES POR CONECTAR*/

}