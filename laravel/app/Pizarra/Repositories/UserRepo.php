<?php namespace Pizarra\Repositories;

use Pizarra\Entities\User;
use Pizarra\Managers\RegisterManager;

class UserRepo extends BaseRepo
{
	public function getModel()
	{
		return new User();
	}

	public function getManager($entity, $datos)
	{
		return new RegisterManager($entity, $datos);
	}

	public function getTable()
	{
		return 'users';
	}

	public function generatePassword()
	{
		$pass    = "";
		$length  = mt_rand(10, 20);
		$lWords  = range('a', 'z');
		$ucWords = range('A', 'Z');
		$numbers = range(0, 9);

		for ($i = 0; $i < $length; $i++)
		{				
			$pass .= $this->getCaracter([$lWords, $ucWords, $numbers]);
		}

		return $pass;
	}

	public function getCaracter($array)
	{	
		$count = count($array)-1;

		$rand  = mt_rand(0, $count);

		$a     = $array[$rand];

		$count = count($a)-1;

		$carac = $a[mt_rand(0, $count)];

		return $carac;
	}
}