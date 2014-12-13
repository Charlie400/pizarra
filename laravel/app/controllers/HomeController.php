<?php

use Pizarra\Repositories\DominioRepo;
use Pizarra\Repositories\ClaseRepo;
use Pizarra\Repositories\AlumnosRepo;

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

	protected $dominioRepo;
	protected $claseRepo;
	protected $alumnosRepo;

	public function __construct(DominioRepo $dominioRepo, ClaseRepo $claseRepo, AlumnosRepo $alumnosRepo)
	{
		$this->dominioRepo     = $dominioRepo;
		$this->claseRepo       = $claseRepo;
		$this->alumnosRepo     = $alumnosRepo;		
	}

	/*--------------EMPIEZAN MÉTODOS PARA MOSTRAR LA PANTALLA DE PROFESOR-----------------*/


	public function index()
	{
		$dominios = $this->dominioRepo->findAll();		

		return View::make('pizarra', compact('dominios'));
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
		$data     = Input::only('dominio', 'clase', 'dominioVal', 'alumno');
		$dominio  = $data['dominio'];
		$clase    = $data['clase'];
		$claseDom = $data['dominioVal'];
		$alumno   = $data['alumno'];

		if ( ! is_null($dominio))
		{
			$this->addDominio($dominio);			
		}
		elseif ( ! is_null($clase) && ! is_null($claseDom))
		{
			$this->addClase($clase, $claseDom);
		}
		elseif ( ! is_null($alumno))
		{
			$this->createAlumno($alumno);
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
			'Nombre' => $c, 
			'id_dominio' => $cD
		];

		$this->claseRepo->createNewRecord($datos);
	}

	public function createAlumno($nombre)
	{
		$password = '123456'; 
		$datos    = [
			'username' => $nombre, 
			'password' => $password, 
			'password_confirmation' => $password
		];

		$this->alumnosRepo->createNewRecord($datos);
	}

	/*--------------TERMINAN MÉTODOS PARA AÑADIR DATOS A LA DB CON ALERTS-----------------*/

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

		//sleep(1);

		shell_exec($instruction);
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

	public function getInstruction($m, $pathImg, $pathAudio, $pathVid, $size)
	{
		$ffmpeg  	 = "$m/../../../../../../ffmpeg/bin/ffmpeg.exe";
		$pathImg 	 = "$m/$pathImg";
		$pathVid 	 = "$m/$pathVid";
		$pathAudio 	 = "$m/$pathAudio";
		$fPerSecond  = 30;

		return "$ffmpeg -f image2 -i $pathImg -i $pathAudio -r $fPerSecond -s $size $pathVid";
	}

	public function decodeBase64($file)
	{
		// split the data URL at the comma
		$file = explode(',', $file);
		// decode the base64 into binary file
		$file = base64_decode(trim($file[1]));

		return $file;
	}

	/*--------------TERMINAN MÉTODOS PARA PROCESAR GRABACIÓN DE CANVAS Y AUDIO-----------------*/

}
