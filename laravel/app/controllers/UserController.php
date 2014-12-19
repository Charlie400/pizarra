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
							 'phone', 'roles', 'nif', 'adress', 'locality', 'province', 'cp', 'borndate', 'obs');

		if (empty($datos['password']) && ! empty($datos['username']) && ! empty($datos['email']))
		{
			$pass = $this->userRepo->generatePassword();

			$datos['password'] 				= $pass;
			$datos['password_confirmation'] = $pass;
		}

		$created = $this->userRepo->createNewRecord($datos);
		
		if ($created === true)		
		{
			if ( isset($pass) )
			{
				return Redirect::back()->with('password', $pass);
			}

			return Redirect::back();
		}

		return Redirect::back()->withInput()->withErrors($created);
	}

	public function editUser()
	{
		$user  = Auth::user();
		$data  = Input::only('firstname', 'lastname', 'username', 'oldpassword', 'password', 'email',
							 'password_confirmation', 'phone', 'roles', 'nif', 'adress', 'locality',
							 'province', 'cp', 'borndate', 'obs');		

		if (empty($data['password']))
		{
			unset($data['password']);
			unset($data['password_confirmation']);
		}

		if ( ! empty($data['oldpassword']))
		{
			$created = $this->userRepo->createNewRecord($data, $user);		
		}

		if ( ! isset($created) or $created === true )
		{
			return Redirect::back();
		}

		return Redirect::back()->withInput()->withErrors($created);
	}
}