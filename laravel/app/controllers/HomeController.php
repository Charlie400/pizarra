<?php

use Pizarra\Repositories\EscenarioRepo;
use Pizarra\Repositories\ElementoRepo;
use Pizarra\Repositories\DominioRepo;
use Pizarra\Repositories\ClaseRepo;
use Pizarra\Components\Recorder\RecorderUtils as Recorder;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	protected $escenarioRepo;
	protected $elementoRepo;
	protected $dominioRepo;
	protected $claseRepo;

	public function __construct(DominioRepo $dominioRepo, ClaseRepo $claseRepo, EscenarioRepo $escenarioRepo,
								ElementoRepo $elementoRepo, Recorder $recorder)
	{
		$this->escenarioRepo = $escenarioRepo;	
		$this->elementoRepo  = $elementoRepo;	
		$this->dominioRepo   = $dominioRepo;
		$this->claseRepo     = $claseRepo;
		$this->recorder      = $recorder;
	}

	/*--------------EMPIEZAN MÉTODOS PARA MOSTRAR LA PANTALLA DE PROFESOR-----------------*/


	public function index()
	{
		$dominios = $this->dominioRepo->findAll();

		return View::make('pizarra', compact('dominios'));
	}

	public function getMenuImages($repo)
	{
		if (isset($_GET['data']) && is_numeric($_GET['data']))
		{
			$claseId = $_GET['data'];

			return $this->$repo->findCustomMenuImages($claseId);
		}
	}

	public function getEscenarios()
	{		
		echo json_encode($this->getMenuImages('escenarioRepo'));
	}

	public function getElementos()
	{
		echo json_encode($this->getMenuImages('elementoRepo'));
	}

	public function sendDominios()
	{
		echo json_encode($this->dominioRepo->findAll());
	}

	//MÉTODO QUE GESTIONA UNA PETICIÓN AJAX DANDO COMO RESULTADO LAS CLASES

	public function getClasses()
	{
		$id = $_GET['data'];
		$dominio = $this->dominioRepo->find($id);

		if ( ! is_null($dominio))
		{
			$clases  = $dominio->clase;
			echo json_encode($clases);
		}
		else
		{
			echo json_encode(null);
		}

	}

	/*--------------TERMINAN MÉTODOS PARA MOSTRAR LA PANTALLA DE PROFESOR-----------------*/

	/*--------------COMIENZAN MÉTODOS PARA AÑADIR DATOS A LA DB CON ALERTS-----------------*/

	//AQUÍ OBTENEMOS LA INFORMACIÓN DEL FORMULARIO DE LOS ALERTS PARA DECIDIR DE CUAL SE TRATA Y EJECUTAR
	//EL MÉTODO CORRESPONDIENTE
	public function addFoo()
	{
		$data     = Input::only('dominio', 'clase', 'selectDominio');
		$dominio  = $data['dominio'];
		$clase    = $data['clase'];
		$claseDom = $data['selectDominio'];

		if ( ! is_null($dominio) && empty($claseDom))
		{
			echo json_encode($this->addDominio($dominio));			
		}
		elseif ( ! is_null($clase) && ! empty($claseDom))
		{
			echo json_encode($this->addClase($clase, $claseDom));
		}
	}

	public function addDominio($nombre)
	{
		if ($this->dominioRepo->createNewRecord(['Nombre' => $nombre]) === true)
		{
			return "Terminado";
		}
	}

	public function addClase($c, $cD)
	{
		$datos   = [
			'Nombre' 	 => $c, 
			'id_dominio' => $cD
		];

		if ($this->claseRepo->createNewRecord($datos) === true)
		{
			return "Terminado";
		}
	}	


	/*--------------TERMINAN MÉTODOS PARA AÑADIR DATOS A LA DB CON ALERTS-----------------*/

	/*--------------COMIENZAN MÉTODOS PARA ELIMINAR DATOS DE LA DB CON ALERTS-----------------*/

	public function borrarEscenario()
	{
		return $this->borrar('escenarioRepo', 'borrarEscenarios');
	}

	public function borrarElemento()
	{
		return $this->borrar('elementoRepo', 'borrarElementos');
	}

	public function borrar($repo, $method)
	{
		$data = Input::only('checkbox')['checkbox'];

		$this->$repo->$method($data);

		return Redirect::back();
	}

	/*--------------EMPIEZAN MÉTODOS PARA PROCESAR GRABACIÓN DE CANVAS Y AUDIO-----------------*/

	public function saveVideo()
	{
		if (isset ($_POST['limit'], $_POST['packages'], $_POST['data']) && is_numeric ($_POST['limit']))
		{	
			$this->recorder->saveVideo();
		}
	}

	public function saveSnapShot()
	{		
		if ($_POST['limit'] && $_POST['limit'] == 1 && isset($_POST['data']))
		{
			$this->recorder->saveSnapShot();
		}
	}

	public function saveAudio()
	{
		if (isset ($_POST['sound']))
		{
			$audio 	  = $_POST['sound'];
			$current  = $_POST['current'];

			$this->createAudio($audio, $current);

			//ECHAR UN OJO A http://apuntes.alexmoleiro.com/2013/07/subir-archivos-grandes-de-100-mb-hasta.html
		}
	}

	public function createAudio($audio, $current)
	{
		$audio = $this->recorder->decodeBase64($audio);

		$path  = public_path() . "/js/multimedia/audio/audio.wav";

		$dir   = $this->recorder->cleanFileName($path);

		if ($this->recorder->fileExist($dir))
		{
			if (\File::exists($path) && $current == 1) $this->recorder->deleteFile($path);
			sleep(0.15);
			$this->recorder->fillFile($audio, $path);
		}
	}

	public function proof()
	{		
		//dd(URL::to('/agregar'));
	}

	public function createUndo()
	{
		$multimedia = $this->getDirMultimedia();
 		file_put_contents($multimedia . '/undoImages/prueba.txt', 'Hola world');
	}

	/*--------------TERMINAN MÉTODOS PARA PROCESAR GRABACIÓN DE CANVAS Y AUDIO-----------------*/

}
