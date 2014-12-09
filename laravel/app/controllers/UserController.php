<?php 

use Pizarra\Entities\User;

class UserController extends BaseController
{
	public function index()
	{
		return View::make('users/login');
	}

	public function login()
	{
		$data['username'] = Input::only('User')['User'];
		$data['password'] = Input::only('Pass')['Pass'];		

		if (Auth::attempt($data))
		{
			return Redirect::route('home');
		}

		return Redirect::back()->withInput();
	}
}