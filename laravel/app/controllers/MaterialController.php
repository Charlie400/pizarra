<?php

use Pizarra\Repositories\MaterialRepo;
use Pizarra\Repositories\MaterialesPivotRepo as PivotRepo;
use Pizarra\Managers\TaskMaterialManager as TaskManager;

//for get FileController
use Pizarra\Repositories\EscenarioRepo;
use Pizarra\Repositories\ElementoRepo;

class MaterialController extends BaseController {

	protected $materialRepo;
	protected $fileController;

	public function __construct(MaterialRepo $materialRepo, PivotRepo $pivotRepo, EscenarioRepo $escenarioRepo, 
								ElementoRepo $elementoRepo)
	{
		$this->materialRepo   = $materialRepo;
		$this->pivotRepo      = $pivotRepo;
		$this->fileController = new FileController($escenarioRepo, $elementoRepo);
	}

	//BEGIN CRUD

	/*
	*	INDICE
	*-----------------------------------
	*	Funcion: baseEditCreateMaterial; 	| Descripción: Procesa una petición para crear o editar un material.
	*	Funcion: createMaterial;         	| Descripción: Recibe una petición desde el cliente y llama a baseEditCreateMaterial.
	*	Funcion: deleteMaterial;         	| Descripción: Elimina un material en base a una id.
	*	Funcion: supportMaterial; 		 	| Descripción: Procesa los datos necesarios para crear un material de apoyo.
	*	Funcion: taskMaterial; 			 	| Descripción: Procesa los datos necesarios para crear una tarea a realizar.
	*	Funcion: editMaterial; 			 	| Descripción: Recibe una petición desde el cliente y llama a baseEditCreateMaterial.
	*	Funcion: subscribeUsersToMaterial;  | Descripción: Asigna un material a un usario.
	*	Funcion: getMaterial; 				| Descripción: Trae un material en base una id proporcionada.
	*	Funcion: getDomainMaterials; 		| Descripción: Trae los materiales que pertenecen al dominio dado.
	*-----------------------------------
	*/
	public function baseEditCreateMaterial($material = false, $manager = false)
	{
		/*
		*	Con type evaluamos que tipo de asignación se está creando, tarea o material de apoyo.
		*	Si el valor es:
		*		0 => Material de apoyo.
		*		1 => Tarea a realizar.
		*/

		$type = Input::only('typeAsignacion')['typeAsignacion'];

		if ( ! is_null($type) )
		{
			if ( $type ) 
			{
				//Aquí entramos para crear una tarea a realizar.

				$data  = Input::only('titulo', 'descripcion', 'testType', 'time', 'examen', 'desde', 'hasta', 
									 'visible', 'id_dominio');				

				// Dado que el manager por defecto es SupportMaterialManager debemos instanciar el de tareas
				$manager = new TaskManager($this->materialRepo->getModel(), $data);

				// Guardamos nombres de los campos que son checkboxs.				
				$checkboxs = ['examen', 'visible'];

				// Construimos y guardamos el nombre de la función en una variable para luego llamarla.
				$funcion = 'taskMaterial';
			}
			else
			{ 
				//Aquí entramos para crear un MATERIAL DE APOYO.

				$data  = Input::only('titulo', 'descripcion', 'desde', 'hasta', 'visible', 'id_dominio');

				// Guardamos nombres de los campos que son checkboxs.
				$checkboxs = ['visible'];

				// Construimos y guardamos el nombre de la función en una variable para luego llamarla.
				$funcion = 'supportMaterial';
			}
			
			/*
			*	Dado que los checkboxs no envían ningún valor cuando no están checkeados debemos asignarselo
			*		Valores:
			*			0 => No checkeado
			*			1 => Checkeado
			*/
			$data = $this->materialRepo->processCheckboxs($data, $checkboxs);			

			//Llamamos a la función que corresponda.
			return $this->{$funcion}($data, $manager, $material);
		}

		//Si $type es nulo devolvemos al usuario a la página anterior
		return Redirect::back();
	}

	public function createMaterial()
	{
		dd($this->baseEditCreateMaterial());
	}

	public function supportMaterial($data, $manager, $material)
	{
		// Comprobamos si existe un archivo llamado documento, en caso contrario termina la ejecución del script
		if ( ! isset($_FILES['documento'])) return false;

		// Guardamos el valor de archivo en una variable.
		$file  = $_FILES['documento'];

		// Comprobamos si están vacíos los campos que contienen la información del archivo
		if ( ! empty($file['name']) && ! empty($file['tmp_name']))
		{
			// Aquí entramos si hay un archivo

			// Declaramos slug que almacenaremos en la base de datos para acceder al archivo
			$slug  = '/Documentos/' . $file['name'];

			// Contruimos el directorio en el que se almacenará el archivo que se va a subir
			$dir   = public_path() . $slug;		

			// Declaramos un conjunto de extensiones permitidas
			$allow = ['pdf', 'doc', 'odt', 'avi', 'wmv', 'mpeg', 'mov', 'flv',
			/*Formatos para pruebas: */ 'jpg', 'png'];

			// Almacenamos el slug del documento en $data para guardarlo en la DB.
			$data['documento'] = $slug;

			if ( ! $this->fileController->uploadFooFile($file, $allow, $dir) )
			{
				//Aquí entramos si hubo algún error al subir el archivo.
				return false;
			}
		}

		//Creamos un registro en la base de datos con $data validando con el manager.
		return $this->materialRepo->newCreateNewRecord($data, $manager, $material);
	}

	public function taskMaterial($data, $manager, $material)
	{
		// Si no esta checkeado el campo examen eliminamos el campo time para evitar errores
		if ( ! $data['examen']) unset($data['time']);

		//Creamos un registro en la base de datos con $data validando con el manager.
		return $this->materialRepo->newCreateNewRecord($data, $manager, $material);
	}	

	public function editMaterial()
	{
		//Se obtiene la id del material a editar
		$idMaterial = Input::only('id_material')['id_material'];

		//Se compruba que no sea nula la id
		if ( ! is_null($idMaterial) )
		{
			//Se trae el material de la base de datos
			$material = $this->materialRepo->find($idMaterial);

			//Se comprueba que el material no sea nulo y se ejecuta la función encargada de crear y editar materiales
			if( ! is_null($material) ) dd($this->baseEditCreateMaterial($material));
		}

		//Respuesta en caso de error
		echo "Debes pasar una id de material válida";
	}

	public function getMaterial($id)
	{
		//Trae un material de la base de datos en base a su id
		$material = $this->materialRepo->find($id);

		//Comprueba si el material existe(no es nulo)
		if ( ! is_null($material))
		{
			echo json_encode($material);
		}
		else
		{
			throw new Error("No existe el material consultado.");
		}
	}

	public function deleteMaterial()
	{
		//Traemos la id recibida por post.
		$id = Input::only('id_material')['id_material'];

		//Buscamos y borramos el material mediante su id.
		if ( ! is_null($id) && is_numeric($id) )
		{
			dd($this->materialRepo->find($id)->delete());
		}

		return Redirect::back();
	}

	//END CRUD

	public function subscribeUsersToMaterial()
	{
		$data = Input::only('id_user', 'id_material');
		$createdAll = true;		

		if ( ! is_null($data['id_user']) && ! is_null($data['id_material']) 
		&& count($data['id_user']) > 0 && ! empty($data['id_material']))
		{
			foreach ($data['id_user'] as $idUser)
			{
				if ($this->pivotRepo->subscribeMaterial($idUser, $data['id_material']) != true) $createdAll = false;
			}
		}

		return Redirect::back();
	}	

	public function getDomainMaterials()
	{	
		$id_dominio = Input::only('id_dominio')['id_dominio'];

		$materials = $this->materialRepo
					 	->where('id_dominio', $id_dominio)
					 	->get();

		if ( ! is_null($materials))
		{
			echo json_encode($materials);
		}
		else
		{
			throw new Error("No existe el material consultado.");
		}
	}

}