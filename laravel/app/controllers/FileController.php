<?php

use Pizarra\Repositories\EscenarioRepo;
use Pizarra\Repositories\ElementoRepo;

class FileController extends BaseController
{

	protected $escenarioRepo;
	protected $elementoRepo;

	public function __construct(EscenarioRepo $escenarioRepo, ElementoRepo $elementoRepo)
	{
		$this->escenarioRepo = $escenarioRepo;
		$this->elementoRepo  = $elementoRepo;
	}

	public function uploadFile()
	{
		if ( isset($_FILES['escenario']) ) 
		{
			$name   	= 'escenario';
			$dir 		= '/Escenarios';
			$repo 		= 'escenarioRepo';
			$escenario	= true;
		}
		elseif ( isset($_FILES['elemento']) )
		{
			$name   	= 'elemento';
			$dir	 	= '/Elementos';
			$repo 		= 'elementoRepo';
			$escenario	= false;
		}

		$clase = $_POST['clase'];

		if ( isset($name) && is_numeric($clase) )
		{
			//Definimos una variable que contendrá los datos a devolver a js
			$result = '';			
			//Definimos los formatos permitidos.
			$allow  = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];	
			//Obtenemos nombre del archivo y nombre temporal(donde se guarda temporalmente el archivo)
			$fileName['Nombre']  = $_FILES[$name]['name'];		
			$fileName['tmpName'] = $_FILES[$name]['tmp_name'];						
				
			if ($this->validFile($fileName['Nombre'], $allow))
			{	

				$data    = $this->buildFileData($fileName['Nombre'], $clase);				

				$created = $this->fileRecord($data, $repo);

				if ($created === true)
				{

			 		$esc = images_path() . $dir . '/' . $data['fullname'];

					if (move_uploaded_file($fileName['tmpName'], $esc))
					{
						$result = 'Completado con exito.';
					}
					else
					{						
						$lastUser = $this->$repo->last();

						$lastUser->delete();

						$result = 'No se pudo subir el archivo.';
					}					
				}
				else
				{
					$result = 'No se pudo crear el registro.';
				}			
			}
			else
			{
				$result = 'Archivo invalido o formato no permitido.';
			}	

			echo json_encode($result);
		}
	}

	public function downloadFile()
	{		
		if (Session::has('file'))
		{
			$dir  = __DIR__ . '/../../public';
			$file = $dir . Session::get('file');
			Session::forget('file');
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
		}
	}

	public function buildFileData($name, $clase)
	{
		//Obtenemos el nombre del archivo sin la extensión				
		$data['Nombre'] = $this->getName($name);

		//Guardamos los datos que enviaremos a la base de datos
		$data['fullname'] = $name;
		$data['clase_id'] = $clase; //Añadir clase seleccionada
		$data['user_id']  = Auth::user()->id;

		return $data;
	}

	public function fileRecord($data, $repo)
	{		
		return $this->$repo->createNewRecord($data);
	}

	public function getName($fullName)
	{
		$fullName = explode('.', $fullName);
		array_pop($fullName);

		return implode('.', $fullName);
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

			//Comprobamos si es un archivo permitido
			$inArray = in_array($ext, $allow);

		 	return $inArray;
			
		}

		return false;
	}
}