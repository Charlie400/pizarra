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
			$carpet 	= 'Escenarios';
			$escenario	= true;
		}
		elseif ( isset($_FILES['elemento']) )
		{
			$name   	= 'elemento';
			$carpet 	= 'Elementos';
			$escenario	= false;
		}

		if ( isset($name) )
		{
			//Definimos una variable que contendrá los datos a devolver a js
			$result = '';			
			//Definimos los formatos permitidos.
			$allow  = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];	
			//Obtenemos nombre del archivo y nombre temporal(donde se guarda temporalmente el archivo)
			$fileName['Nombre']  = $_FILES[$name]['name'];		
			$fileName['tmpName'] = $_FILES[$name]['tmp_name'];			

			//Obtenemos la extensión del archivo
			$data['Nombre']  = explode('.', $fileName['Nombre']);
				
			if ($this->validFile($fileName['Nombre'], $allow))
			{							
				//Obtenemos el nombre del archivo sin la extensión
				$data['Nombre'] = implode('.', $data['Nombre']);

				//Guardamos los datos que enviaremos a la base de datos
				$data['fullname'] = $fileName['Nombre'];
				$data['clase_id'] = $_POST['clase']; //Añadir clase seleccionada

				if ($escenario) 
				{
					$data['user_id']  = Auth::user()->id;				
					$created = $this->escenarioRepo->createNewRecord($data);
				}
				else
				{ 
					$created = $this->elementoRepo->createNewRecord($data);		
				}

				if ($created === true)
				{

			 		$esc = public_path() . '/images/' . $carpet . '/' . $data['fullname'];		

					if (move_uploaded_file($fileName['tmpName'], $esc))
					{
						$result = 'Completado con exito.';
					}
					else
					{
						if ($escenario) $lastUser = $this->escenarioRepo->last();
						else $lastUser = $this->elementoRepo->last();

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