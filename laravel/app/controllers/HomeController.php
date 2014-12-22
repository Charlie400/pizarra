<?php

use Pizarra\Repositories\EscenarioRepo;
use Pizarra\Repositories\ElementoRepo;
use Pizarra\Repositories\DominioRepo;
use Pizarra\Repositories\ClaseRepo;

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
								ElementoRepo $elementoRepo)
	{
		$this->escenarioRepo = $escenarioRepo;	
		$this->elementoRepo  = $elementoRepo;	
		$this->dominioRepo   = $dominioRepo;
		$this->claseRepo     = $claseRepo;
	}

	/*--------------EMPIEZAN MÉTODOS PARA MOSTRAR LA PANTALLA DE PROFESOR-----------------*/


	public function index()
	{
		$dominios   = $this->dominioRepo->findAll();
		$escenarios = $this->escenarioRepo->findAll();

		return View::make('pizarra', compact('dominios', 'escenarios'));
	}

	public function getEscenarios()
	{
		echo json_encode($this->escenarioRepo->findAll());
	}

	public function getElementos()
	{
		echo json_encode($this->elementoRepo->findAll());
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
		$clases  = $dominio->clase;

		echo json_encode($clases);
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
			$this->addDominio($dominio);			
		}
		elseif ( ! is_null($clase) && ! empty($claseDom))
		{
			$this->addClase($clase, $claseDom);
		}
		else
		{
			return Redirect::back(); //Añadir a este redirect el error de que no se puede dejar el campo en blanco			
		}

		return Redirect::back();
	}

	public function addDominio($nombre)
	{
		$this->dominioRepo->createNewRecord(['Nombre' => $nombre]);
	}

	public function addClase($c, $cD)
	{
		$datos   = [
			'Nombre' 	 => $c, 
			'id_dominio' => $cD
		];

		$this->claseRepo->createNewRecord($datos);
	}	


	/*--------------TERMINAN MÉTODOS PARA AÑADIR DATOS A LA DB CON ALERTS-----------------*/

	/*--------------COMIENZAN MÉTODOS PARA ELIMINAR DATOS DE LA DB CON ALERTS-----------------*/

	public function borrarEscenario()
	{
		$data = Input::only('checkbox')['checkbox'];

		$this->escenarioRepo->borrarEscenarios($data);

		return Redirect::back();
	}

	/*--------------EMPIEZAN MÉTODOS PARA PROCESAR GRABACIÓN DE CANVAS Y AUDIO-----------------*/

	public function saveImageSequence()
	{

		$multimedia = $this->getDirMultimedia();		

		$limit      = $_POST['limit'];
		$packages   = $_POST['packages'];
		$perPackage = 200;

		// $fileName    = "$multimedia/frames/text.txt";
		// file_put_contents($fileName, $limit);

		if (isset ($limit, $packages) && is_numeric ($limit) && $limit > 1)
		{
			$path    = "$multimedia/frames/";
			$begin   = $packages*$perPackage;
			$end     = $begin+$perPackage;
			$counter;					

			for ($i = $begin; $i < $end && $i <= $limit; $i++)
			{
			    
			    $d = $this->decodeBase64($_POST["data$i"]);

			    $this->createImageFile($path, $i, $d);

			    unset($_POST["data$i"]);

			    $counter = $i;
			
			}

			if ($counter == $limit)
    		{    			
				$this->createVideo($multimedia);
			}
		}
		elseif ($limit == 1 && isset($_POST['data']))
		{
			$path = "$multimedia/snapshots/";

			$d    = $this->decodeBase64($_POST['data']);
				    
			$this->createImageFile($path, 0, $d);
		}
	}

	public function createImageFile($path, $i, $d)
	{
		$filename = sprintf('%s%08d.png', $path, $i);
		file_put_contents($filename, $d);	
	}

	public function createVideo($m)
	{	
		$pathImg 	 = "frames/%08d.png";
		$pathVid 	 = "video/vid.avi";
		$pathAudio 	 = "audio/audio.wav";

		$instruction = $this->getInstruction($m, $pathImg, $pathAudio, $pathVid, '600x400');

		shell_exec($instruction);
	}

	public function getInstruction($m, $pathImg, $pathAudio, $pathVid, $size)
	{
		$ffmpeg  	 = "ffmpeg";
		$pathImg 	 = "$m/$pathImg";
		$pathVid 	 = "$m/$pathVid";
		$pathAudio 	 = "$m/$pathAudio";
		$fPerSecond  = 30;

		return "$ffmpeg -f image2 -i $pathImg -i $pathAudio -r $fPerSecond -s $size $pathVid";
	}

	public function saveAudio()
	{
		$audio = $_POST['sound'];		

		$audio = $this->decodeBase64($audio);

		$multimedia = $this->getDirMultimedia();

		file_put_contents("$multimedia/audio/audio.wav", $audio);
	}

	public function getDirMultimedia()
	{
		$public = public_path();

		return "$public/js/multimedia";
	}


	public function decodeBase64($file)
	{
		// split the data URL at the comma
		$file = explode(',', $file);
		// decode the base64 into binary file
		$file = base64_decode(trim($file[1]));

		return $file;
	}

	public function createUndo()
	{
		$multimedia = $this->getDirMultimedia();
 		file_put_contents($multimedia . '/undoImages/prueba.txt', 'Hola world');
	}

	/*--------------TERMINAN MÉTODOS PARA PROCESAR GRABACIÓN DE CANVAS Y AUDIO-----------------*/

}
