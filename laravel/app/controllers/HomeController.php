<?php

use Pizarra\Entities\Dominio;

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

	/*--------------EMPIEZAN MÉTODOS PARA MOSTRAR LA PANTALLA DE PROFESOR-----------------*/

	public function index()
	{
		$dominios = Dominio::all();

		return View::make('pizarra', compact('dominios'));
	}

	//MÉTODO QUE GESTIONA UNA PETICIÓN AJAX DANDO COMO RESULTADO LAS CLASES

	public function getClasses()
	{
		$id = $_GET['data'];
		$dominio = Dominio::find($id);
		$clases  = $dominio->clase;

		echo json_encode($clases);
	}

	/*--------------TERMINAN MÉTODOS PARA MOSTRAR LA PANTALLA DE PROFESOR-----------------*/

	/*--------------EMPIEZAN MÉTODOS PARA PROCESAR GRABACIÓN DE CANVAS Y AUDIO-----------------*/

	public function saveImageSequence()
	{

		$multimedia  = $this->getDirMultimedia();
		$path        = "$multimedia/frames/";

		$limit      = $_POST['limit'];
		$packages   = $_POST['packages'];
		$perPackage = 200;

		// $fileName    = "$multimedia/frames/text.txt";
		// file_put_contents($fileName, $data);

		if (isset ($limit, $packages) && is_numeric ($limit)) 
		{
			$begin  = $packages*$perPackage;
			$end    = $begin+$perPackage;					

			for ($i = $begin; $i < $end && $i <= $limit; $i++)
			{
			    
			    $d = $this->decodeBase64($_POST["data$i"]);
			 
			    // create the numbered image file
			    $filename = sprintf('%s%08d.png', $path, $i);
			    file_put_contents($filename, $d);

			    unset($_POST["data$i"]);
			
			    if ($i == $limit)
			    {				    		    	
			    	$pathImg 	 = "frames/%08d.png";
			    	$pathVid 	 = "video/vid.avi";
			    	$pathAudio 	 = "audio/audio.wav";

			    	$instruction = $this->getInstruction($multimedia, $pathImg, $pathAudio, $pathVid, '600x400');

			    	//sleep(1);

			    	shell_exec($instruction);
			    }
			}
		}
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
		$dir = __DIR__;

		return "$dir/../../public/js/multimedia";
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
