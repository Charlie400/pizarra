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
		$category = Category::where('penaliza', $penaliza)
					->where('multirespuesta', $multirespuesta)
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
			$errors->add('errors', true);

			echo json_encode($errors);			
		}
	}

	public function createPreguntas($idTest)
	{
		$data  = \Input::all();
		$save  = [];

		$test = $this->testRepo->find($idTest);

		DB::transaction(function() use ($save, $data, $test)
		{	
			for ($i = 1; $i <= $test->preguntas; $i++)
			{
				$save['pregunta']   = $data['pregunta' . $i];
				$save['respuestas'] = $test->respuestas;
				$save['id_test']    = $test->id;
				$save['valor']      = $test->puntuacion/$test->preguntas;

				$manager = new PreguntaManager(new Pregunta(), $save);

				if ( ! $manager->save()) 
				{
					DB::rollback(); 

					echo json_encode($manager->errors());
					break;
				}
			}
		});

		echo json_encode("");
		exit();
	}

	public function createRespuestas($idTest)
	{
		$data  = \Input::all();	
		$save  = [];
		$checks = 0;

		$data['checkradio'] = explode(',', $data['checkradio']);

		$test = $this->testRepo->find($idTest);

		DB::transaction(function() use ($save, $data, $test, $checks)
		{	
			for ($i = 1; $i <= $test->preguntas; $i++)
			{
				for ($a = 1; $a <= $test->respuestas; $a++)
				{
					$save['respuesta']   = $data['respuesta' . $i . $a];
					$save['id_pregunta'] = $test->pregunta[$i-1]->id;
					$save['id_test']     = $test->id;
					$save['correcta']    = $data['checkradio'][$checks++];

					$manager = new RespuestaManager(new Respuesta(), $save);


					if ( ! $manager->save()) 
					{
						DB::rollback(); 

						echo json_encode($manager->errors());
						exit();
					}
				}
			}

			$test->active = 1;
			$test->save();
		});	

		echo json_encode("");
	}
}