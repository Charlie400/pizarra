<?php namespace Pizarra\Components\Recorder;

class RecorderUtils {

	public function decodeBase64($file)
	{
		// split the data URL at the comma
		$array = explode(',', $file);
		// decode the base64 into binary file
		return base64_decode(trim($array[count($array)-1]));
	}

	public function replace($search, $replace, $string)
	{
		return str_replace($search, $replace, $string);
	}

	public function divide($search, $string)
	{
		return explode($search, $string);
	}

	public function join($search, $string)
	{
		return implode($search, $string);
	}

	public function place($search, $array)
	{
		return array_search($search, $array); //Busca en un array $search y devuelve su clave.
	}

	public function outLast(&$array)
	{
		return array_pop($array);
	}

	public function cleanFileName($dir)
	{
		$tmp  = $dir;
		$dir  = $this->divide('/', $this->replace('\\', '/', $dir));
		$last = $this->outLast($dir);
		$last = $this->divide('.', $last);		

		if (count($last) > 1) return $this->join('/', $dir);
		
		return $tmp;
	}

	public function fileExist($dir)
	{
		if ( ! \File::exists($dir) ) return \File::makeDirectory($dir);

		return true;
	}

	public function createFile($dir, $file)
	{			
		file_put_contents($dir, $file);
	}

	public function appendFileData($copy, $paste) //Archivo del que se copia '$copy' y archivo al que se añade '$paste'
	{
		$file = fopen($paste, 'ab');
		$part = fopen($copy, 'rb');

		while ($buff = fread($part, 1000000))
		{			
			fwrite($file, $buff);
		}

		//unlink($copy);
		fclose($part);
		fclose($file);
	}

	public function fillFile($data, $path)
	{		
		$file = fopen($path, 'ab');

		fwrite($file, $data);

		fclose($file);
	}

	public function deleteFile($path)
	{
		@unlink($path);
	}

	public function createImageSequence($begin, $end, $limit, $path, $data)
	{
		for ($i = 1; $i <= 200 && $begin < $limit; $i++)
		{		    
		    $d = $this->decodeBase64($data[$i]);

		    $this->createImageFile($path, $begin, $d);

		    $counter = ++$begin;
		}		

		return $counter;
	}

	public function saveVideo()
	{

		$multimedia = public_path() . '/js/multimedia';		
	
		$perPackage = 200;
		
		// $fileName    = "$multimedia/text.txt";
		// file_put_contents($fileName, $_POST['data']);

		$limit      = $_POST['limit'];
		$packages   = $_POST['packages'];
		$path    	= "$multimedia/frames/";

		if ($this->fileExist($path))
		{
			sleep(0.5);

			$data = str_replace('data:image/png;base64,', ',', $_POST['data']);
			$data = explode(',', $data);

			$begin   = $packages*$perPackage;
			$end     = $begin+$perPackage;

			$counter = $this->createImageSequence($begin, $end, $limit, $path, $data);				

			if ($counter == $limit)
    		{    			
				$this->createVideo($multimedia . '/video/vid.avi');
			}
		}					
	}

	public function saveSnapShot($imageRepo, $id_dominio)
	{
		//Preparamos la ruta donde se almacenará la imagen
		$multimedia = public_path() . '/js/multimedia';
			//El slug nos servirá para almacenar solo la última parte de la url de la imagen
		$slug = '/snapshots/';

		$path = $multimedia . $slug;

		//Guardamos una entidad vacía para poder usar la id como nombre de la imagen.
		$image   = $imageRepo->getModel();

		$image->save();

		//Actualizamos con el manager la entidad
		$id = $image->id;

		//Completamos el slug
		$slug = $slug . $id . '.png';

		$manager = $imageRepo->getManager($image, ['url' => $slug, 'id_dominio' => $id_dominio]);

		$isSave = $manager->save();

		//Comprobamos que exite el directiorio, si no, lo creamos
		if ($this->fileExist($path) && $isSave)
		{	
			//Decodificamos los datos		
			$d   = $this->decodeBase64($_POST['data']);
			
			//Creamos la imagen
			$this->createImageFile($path, 0, $d, $path . $id . '.png');

			//Devolvemos true para indicar que el proceso fue exitoso.
			echo json_encode($id);
			
		}
		else
		{
			//En caso de fallo borramos la entidad
			$image->delete();
		}
	}

	///TEMP

	public function createImageFile($path, $i, $d, $filename = false)
	{
		if ( ! $filename )
		{
			$filename = sprintf('%s%08d.png', $path, $i);
		}

		$this->createFile($filename, $d);	
	}

	public function createVideo($pathVid)
	{
		if ($this->fileExist($this->cleanFileName($pathVid)))
		{
			$m           = public_path() . '/js/multimedia';
			$pathImg 	 = $m . "/frames/%08d.png";
			$pathAudio 	 = $m . "/audio/audio.wav";

			$instruction = $this->getInstruction($pathImg, $pathAudio, $pathVid, '600x400');

			shell_exec($instruction);

			echo json_encode(true); //Para activar el sistema de descarga
		}
	}

	public function getInstruction($pathImg, $pathAudio, $pathVid, $size)
	{
		$fPerSecond  = 30;

		return "ffmpeg -f image2 -i $pathImg -i $pathAudio -r $fPerSecond -s $size $pathVid";
	}

	public function downloadFile($file, $delete = false)
	{		
		$fileName = $this->outLast(($this->divide('/', $file)));
		$dir  = public_path();
		$file = $dir . $file;

		$allow = array('png', 'avi');

		if ($this->validFile($file, $allow) && \File::exists($file))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Type: application/force-download');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);

			if ($delete)
			{
				sleep(2);

				$this->deleteFile($file);
			}
		}
		else
		{
			echo 'Access Denied';
		}
	}

	public function allowFiles()
	{
		return array('00000000.png', 'vid.avi');
	}

	public function isAllowDownload($fileName)
	{
		return in_array($fileName, $this->allowFiles());		
	}

	public function validFile($fileName, $allow)
	{
		//Obtenemos la extensión del archivo
		$fileName = explode('.', $fileName);

		$count = count($fileName) > 1;		

		if ($count)
		{	
			//Conseguimos la extensión del archivo	
			$ext   = array_pop($fileName);
			$ext   = strtolower($ext);

			//Comprobamos si es un archivo permitido
			return in_array($ext, $allow);
			
		}

		return false;
	}

	///TEMP
}