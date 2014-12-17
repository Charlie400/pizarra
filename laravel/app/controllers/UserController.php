<?php 

use Pizarra\Entities\User;
use Pizarra\Managers\LoginManager;

class UserController extends BaseController
{

	protected $loginManager;
	protected $errors;

	public function __construct()
	{

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
}