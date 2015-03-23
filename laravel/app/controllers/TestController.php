<?php

use Pizarra\Entities\Test;
use Pizarra\Entities\Respuesta;
use Pizarra\Entities\Pregunta;
use Pizarra\Entities\TestCategory as Category;

use Pizarra\Managers\RespuestaManager;
use Pizarra\Managers\PreguntaManager;

use Pizarra\Repositories\TestRepo;
use Pizarra\Repositories\ClaseRepo;
use Pizarra\Repositories\DominioPivotRepo;

class TestController extends BaseController {

	protected $testRepo;
	protected $claseRepo;
	protected $dominioPivotRepo;

	public function __construct(TestRepo $testRepo, ClaseRepo $claseRepo, DominioPivotRepo $dominioPivotRepo)
	{
		$this->testRepo  		= $testRepo;
		$this->claseRepo 		= $claseRepo;
		$this->dominioPivotRepo = $dominioPivotRepo;
	}

	public function index($id_dominio)
	{
		$clases = $this->claseRepo
					->where('id_dominio', $id_dominio)
					->get();

		$pivots = $this->dominioPivotRepo
					->where('id_dominio', $id_dominio)
					->with('user')
					->get();

		return View::make('tests/config_test', compact('clases', 'pivots', 'id_dominio'));
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
		// Recibimos los datos por POST.
		$data = Input::only('titulo', 'id_clase', 'id_category', 'multirespuesta', 'preguntas', 'respuestas', 
							'puntuacion', 'id_dominio');

		// Al crear el test está inactivo por defecto hasta que tenga preguntas y respuestas relacionadas.
		$data['active'] = 0;

		// Si la clase no es numérica significa que no se ha seleccionado y se borra.
		if ( ! is_numeric($data['id_clase'])) unset($data['id_clase']);

		// Instanciamos el manager para validar e insertar los datos.
		$manager = $this->testRepo->getManager($this->testRepo->getModel(), $data);

		// Comprobamos si los datos son válidos y los insertamos.
		if ( $test = $manager->save() )
		{	
			// Entramos aquí en caso de éxito y devolvemos el test y una propiedad que determina que no hay errores.
			$test->errors = false;
			echo json_encode($test);
			exit;
		}

		// Entramos aquí en caso de error y devolvemos los mensajes dados por el manager.
		$errors = $manager->errors();
		//Añadimos una propiedad para determinar que hay errores.
		$errors->add('errors', true);

		echo json_encode($errors);			
	}

	// Crea las preguntas del test
	public function createPreguntas($idTest)
	{
		// Recibimos los datos por POST.
		$data  = \Input::all();		
		$save  = [];
		$response = "";

		// Buscamos al test en cuestión para saber sus características.
		$test = $this->testRepo->find($idTest);

		if ( ! is_null($test) )
		{
			// Creamos una transacción para insertar las preguntas, en caso de algún error todo quedará como estaba.

			DB::transaction(function() use ($save, $data, $test)
			{	
				for ($i = 1; $i <= $test->preguntas; $i++)
				{
					// Guardamos en un array los datos de las preguntas para luego validarlos e insertarlos.
					$save['pregunta']   = $data['pregunta' . $i];
					$save['respuestas'] = $test->respuestas;
					$save['id_test']    = $test->id;
					$save['valor']      = $data['pregunta' . $i . 'valor'];

					// Instanciamos el manager
					$manager = new PreguntaManager(new Pregunta(), $save);

					// Comprobamos si los datos son válidos y pudieron insertarse.
					if ( ! $manager->save()) 
					{
						// Entramos aquí cuando los datos no son válidos o no han podido insertarse.
						DB::rollback(); 

						// Almacenamos los errores para luego devolverlos al cliente.
						$response = $manager->errors();
						break;
					}
				}
			});		

			echo json_encode($response);
			exit;
		}			
	}

	public function createRespuestas($idTest)
	{
		// Recibimos los datos por POST.
		$data  	  = \Input::all();	
		$save  	  = [];
		$checks   = 0;
		$response = "";

		// Se obtienen los valores de los checks o radios y se convierte en array de nuevo.
		$data['checkradio'] = explode(',', $data['checkradio']);

		// Buscamos al test en cuestión para saber sus características.
		$test = $this->testRepo->find($idTest);

		// Creamos una transacción para insertar las preguntas, en caso de algún error todo quedará como estaba.

		DB::transaction(function() use ($save, $data, $test, $checks)
		{	
			for ($i = 1; $i <= $test->preguntas; $i++)
			{
				for ($a = 1; $a <= $test->respuestas; $a++)
				{
					// Guardamos en un array los datos de las preguntas para luego validarlos e insertarlos.					
					$save['respuesta']   = $data['respuesta' . $i . $a];
					$save['id_pregunta'] = $test->pregunta[$i-1]->id;
					$save['id_test']     = $test->id;
					$save['correcta']    = $data['checkradio'][$checks++];

					// Instanciamos el manager					
					$manager = new RespuestaManager(new Respuesta(), $save);

					// Comprobamos si los datos son válidos y pudieron insertarse.					
					if ( ! $manager->save()) 
					{
						// Entramos aquí cuando los datos no son válidos o no han podido insertarse.						
						DB::rollback(); 

						// Almacenamos los errores para luego devolverlos al cliente.
						$response = $manager->errors();
						$error    = true;
						break;
					}
				}
			}

			// Comprobamos que la respuesta 
			if ( ! isset($error) )
			{
				$test->active = 1;
				$test->save();
			}

		});	

		echo json_encode($response);
	}

	public function getDomainTests($id_dominio)
	{		
		$tests = $this->testRepo
			->with('testCategory')
			->where('id_dominio', $id_dominio)
			->get();

		echo json_encode($tests);
		exit;
	}
}