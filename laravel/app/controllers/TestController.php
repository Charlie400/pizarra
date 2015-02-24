<?php

use Pizarra\Entities\Test;
use Pizarra\Entities\Respuesta;
use Pizarra\Entities\Pregunta;
use Pizarra\Entities\TestCategory as Category;

use Pizarra\Managers\RespuestaManager;
use Pizarra\Managers\PreguntaManager;

use Pizarra\Repositories\TestRepo;

class TestController extends BaseController {

	protected $testRepo;

	public function __construct(TestRepo $testRepo)
	{
		$this->testRepo = $testRepo;
	}

	public function index()
	{
		return View::make('tests/config_test');
	}

	public function getTestTypes($penaliza, $multirespuesta)
	{
		$category = Category::where('penaliza', (int) $penaliza)
					->where('multirespuesta', (int) $multirespuesta)
					->get();
		echo json_encode($category[0]->id);
	}

	public function createTest()
	{
		$data = Input::only('titulo', 'id_clase', 'id_category', 'multirespuesta', 'preguntas', 'respuestas', 
							'puntuacion');
		$data['active'] = 0;

		if ( ! is_numeric($data['id_clase'])) unset($data['id_clase']);

		$manager = $this->testRepo->getManager($this->testRepo->getModel(), $data);

		if ($test = $manager->save())
		{	
			$test->errors = false;
			echo json_encode($test);
		}
		else
		{
			$errors = $manager->errors();
			$errors->errors = true;

			echo json_encode($errors);			
		}
	}
}