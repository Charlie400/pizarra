<?php namespace Pizarra\Repositories;

use Pizarra\Entities\User;
use Pizarra\Managers\RegisterManager;

class AlumnosRepo extends BaseRepo
{
	public function getModel()
	{
		return new User();
	}

	public function getManager($entity, $datos)
	{
		return new RegisterManager($entity, $datos);
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
			$pass .= $this->getCaracter($lWords, $ucWords, $numbers);
		}

		return $pass;
	}

	public function getCaracter($lWords, $ucWords, $numbers)
	{
		$rand = mt_rand(0, 2);

		if ($rand === 0)
		{
			$carac = $lWords[mt_rand(0,25)];
		}
		elseif ($rand === 1)
		{
			$carac = $ucWords[mt_rand(0,25)];
		}
		elseif ($rand === 2)
		{
			$carac = $numbers[mt_rand(0,9)];
		}

		return $carac;
	}
}