<?php

use Pizarra\Repositories\EscenarioRepo;

class FileController extends BaseController
{

	protected $escenarioRepo;

	public function __construct(EscenarioRepo $escenarioRepo)
	{
		$this->escenarioRepo = $escenarioRepo;
	}

	public function uploadFile()
	{
			//Definimos una variable que contendrá los datos a devolver a js
			$result = '';			
			//Definimos los formatos permitidos.
			$allow = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];	
			//Obtenemos nombre del archivo y nombre temporal(donde se guarda temporalmente el archivo)
			$fileName['Nombre']  = $_FILES['escenario']['name'];		
			$fileName['tmpName'] = $_FILES['escenario']['tmp_name'];			

			//Obtenemos la extensión del archivo
			$data['Nombre']  = explode('.', $fileName['Nombre']);
				
			if ($this->validFile($fileName['Nombre'], $allow))
			{							
				//Obtenemos el nombre del archivo sin la extensión
				$data['Nombre'] = implode('.', $data['Nombre']);

				//Guardamos los datos que enviaremos a la base de datos
				$data['fullname'] = $fileName['Nombre'];
				$data['clase_id'] = 1; //Añadir clase seleccionada
				$data['user_id']  = Auth::user()->id;

				if ($this->escenarioRepo->createNewRecord($data) === true)
				{

			 		$esc = public_path() . '/images/Escenarios/' . $data['fullname'];		

					if (move_uploaded_file($fileName['tmpName'], $esc))
					{
						$result = 'Completado con exito.';
					}
					else
					{
						$lastUser = $this->escenarioRepo->last();
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

	public function validFile($fileName, $allow)
	{
		$fileName = explode('.', $fileName);
		//Obtenemos la extensión del archivo

		$count = count($fileName) > 1;		

		if ($count)
		{			
			//Conseguimos la extensión del archivo	
			$ext   = array_pop($fileName);

			//Comprobamos si es un archivo permitido
			$inArray = in_array($ext, $allow);

			if ($inArray)
			{
		 		return true;
			}
		}

		return false;
	}
}