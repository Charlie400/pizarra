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
			//Obtenemos nombre del archivo y nombre temporal(donde se guarda temporalmente el archivo)
			$fileName['Nombre']  = $_FILES['escenario']['name'];		
			$fileName['tmpName'] = $_FILES['escenario']['tmp_name'];

			//Obtenemos la extensión del archivo
			$data['Nombre']  = explode('.', $fileName['Nombre']);
			$ext = array_pop($data['Nombre']);

			//Seleccionamos las extensiones de archivo permitidas
			$allow = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

			//Obtenemos el nombre del archivo sin la extensión
			$data['Nombre']  = implode('.', $data['Nombre']);
			
			//Guardamos los datos que enviaremos a la base de datos
			$data['fullname'] = $fileName['Nombre'];
			$data['clase_id'] = 1; //Añadir clase seleccionada
			$data['user_id']  = Auth::user()->id;

			if (in_array($ext, $allow) && $this->escenarioRepo->createNewRecord($data) === true)
			{

		 		$esc = public_path() . '/images/Escenarios/' . $data['fullname'];		

				if (move_uploaded_file($fileName['tmpName'], $esc))
				{
					echo json_encode('');
				}
				else
				{
					dd('Fallido');
				}

			}
			else
			{
				echo json_encode('No se pudo crear registro o el formato no es permitido.');
			}
	}
}