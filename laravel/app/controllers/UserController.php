<?php 

use Pizarra\Entities\User;
use Pizarra\Managers\LoginManager;
use Pizarra\Repositories\UserRepo;

class UserController extends BaseController
{

	protected $errors;
	protected $userRepo;

	public function __construct(UserRepo $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	public function index()
	{
		return View::make('users/login');
	}

	public function login()
	{
		$data = Input::only('username', 'password');

		$user 	 = new User();
		$manager = new LoginManager($user, $data);

		if ($manager->isValid())
		{
			if (Auth::attempt($data))
			{
				return Redirect::route('home');
			}

			$this->errors = $manager->errors();
			$this->errors->add('password', 'Contraseña incorrecta.');

			return Redirect::back()->withInput()->withErrors($this->errors);
		}

		return Redirect::back()->withInput()->withErrors($manager->errors());
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::to('/login');
	}

	public function createUser()
	{		
		$datos = Input::only('firstname', 'lastname', 'username', 'password', 'password_confirmation', 'email',  
					'phone', 'roles', 'nif', 'adress', 'locality', 'province', 'cp', 'borndate', 'obs', 'id_dominio');

		if (empty($datos['password']))
		{
			$error = new stdClass();
			$error->password = "Debes introducir una contraseña";			
			echo json_encode($error);
			exit();
		}

		$created = $this->userRepo->createNewRecord($datos);
		
		if ($created === true)		
		{			
			if ( isset($pass) )
			{
				echo json_encode("Pass: $pass");
				//return Redirect::back()->with('password', $pass);
			}
			else
			{		
				echo json_encode('Terminado');
			}
		}
		else
		{
			echo json_encode($created);
			//return Redirect::back()->withInput()->withErrors($created);			
		}

	}

	public function editUser()
	{
		$user  = Auth::user();
		$data  = Input::only('firstname', 'lastname', 'username', 'oldpassword', 'password', 'email',
							 'password_confirmation', 'phone', 'roles', 'nif', 'adress', 'locality',
							 'province', 'cp', 'borndate', 'obs');
		$data['id_dominio'] = \Auth::user()->id_dominio;

		if (empty($data['password']))
		{
			unset($data['password']);
			unset($data['password_confirmation']);
		}

		if ( ! empty($data['oldpassword']))
		{
			$created = $this->userRepo->createNewRecord($data, $user);		

			if ($created === true )
			{
				echo json_encode('Terminado');
			}
			else
			{
				echo json_encode($created);
				//return Redirect::back()->withInput()->withErrors($created);
			}
		}
		else
		{
			$error = new stdClass();
			$error->oldpassword = "Debes introducir una contraseña";			
			echo json_encode($error);
		}
	}

	//Funcionalidades por conectar

	public function baseSubscribe($subscribe)
	{
		//Se obtienen los valores enviados por el formulario.
		//$data = Input::only('id', 'id_dominio');
		$data   = array('id' => 10, 'id_dominio' => 12);

		//Se comprueba si los valores están vacíos, de estarlos, la ejecución termina aquí
		if (empty($data['id_dominio']) or empty($data['id'])) return \Redirect::back();

		//Se pide al repositorio que nos devuelva al usuario con id = $data['id']
		$user    = $this->userRepo->findWith($data['id'], 'dominioPivot');

		//Se obtienen los dominios en los que el alumno está dado de alta

		$dominioPivotRepo = $this->userRepo->dominioPivotRepo();
		$dominioPivot     = $dominioPivotRepo->getModel();

		$query            = $dominioPivot
							->where('id_user', $data['id'])
							->where('id_dominio', $data['id_dominio']);

		$userDominios     = $query->get();

		$count = count($userDominios);

		if ($subscribe && $count == 0)
		{
			//Si el método subscribe llamó a este método y la id_dominio a insertar no está en la base de datos
			//se añade el valor
			$dominioPivotRepo->createNewRecord(['id_dominio' => $data['id_dominio'], 'id_user' => $data['id']]);
		}
		elseif ( ! $subscribe && $count == 1)
		{
			//Si el método unsubscribe llamó a este método y la id_dominio a insertar está en la base de datos
			//se elimina el valor
			$query->delete();
		}

		return \Redirect::back();
	}

	public function subscribe() //dar de baja; route = '/baja/alumno';
	{
		return $this->baseSubscribe(true);		
	}

	public function unsubscribe() //dar de alta; route = '/alta/alumno';
	{
		return $this->baseSubscribe(false);		
	}

	//FIN Funcionalidades por conectar

	/*
		*Es necesario instalar mercury en local para enviar emails
		*ver: https://www.youtube.com/watch?v=qqFEg4QfOS8
	*/

	public function sendMail()
	{
		$message = "Esto es una prueba de que funciona correctamente el envio de email de php para poder añadirlo a 
		la pizarra";

		wordwrap($message, 70, '\r\n');

		mail("Entrenarydefinir@gmail.com", "Esto es un título", $message);
	}
}