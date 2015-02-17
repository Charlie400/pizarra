<?php

use Pizarra\Repositories\MaterialRepo;

//for get FileController
use Pizarra\Repositories\EscenarioRepo;
use Pizarra\Repositories\ElementoRepo;

use Pizarra\Managers\TaskMaterialManager as TaskManager;

class MaterialController extends BaseController {

	protected $materialRepo;
	protected $fileController;

	public function __construct(MaterialRepo $materialRepo, EscenarioRepo $escenarioRepo, ElementoRepo $elementoRepo)
	{
		$this->materialRepo   = $materialRepo;
		$this->fileController = new FileController($escenarioRepo, $elementoRepo);
	}

	public function createMaterial()
	{
		$type = Input::only('typeAsignacion')['typeAsignacion'];

		if ( ! is_null($type) && $type) dd($this->createTaskMaterial());
		elseif ( ! is_null($type) && ! $type) dd($this->createSupportMaterial());

		return Redirect::back();
	}

	public function createSupportMaterial()
	{
		if ( ! isset($_FILES['documento'])) return false;

		$data  = Input::only('titulo', 'descripcion', 'desde', 'hasta', 'visible');
		$data  = $this->materialRepo->processCheckboxs($data, ['visible']);

		$hasDocument = false;
		$file  = $_FILES['documento'];

		if ( ! empty($file['name']) && ! empty($file['tmpname']))
		{
			$dir   = public_path() . '/Documentos/' . $file['name'];		
			$allow = ['pdf', 'doc', 'odt', 'avi', 'wmv', 'mpeg', 'mov', 'flv'];
			$hasDocument = true;
		}

		if ( ! $hasDocument or $this->fileController->uploadFooFile($file, $allow, $dir))
		{
			if ($hasDocument) $data['documento'] = $dir;			

			return $this->materialRepo->newCreateNewRecord($data);
		}
	}

	public function createTaskMaterial()
	{
		$data  = Input::only('titulo', 'descripcion', 'testType', 'time', 'examen', 'desde', 'hasta', 'visible');
		$data  = $this->materialRepo->processCheckboxs($data, ['examen', 'visible']);

		$manager = new TaskManager($this->materialRepo->getModel(), $data);
		
		if ( ! $data['examen']) unset($data['time']);

		return $this->materialRepo->newCreateNewRecord($data, $manager);

		//dd($this->materialRepo->timeStringToSeconds($this->materialRepo->findAll()[0]->time));
	}

}