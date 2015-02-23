<?php namespace Pizarra\Repositories;

abstract class BaseRepo
{
	public function __construct()
	{
		$this->model = $this->getModel();
	}

	abstract public function getModel();

	abstract public function getTable();

	abstract public function getManager($entity, $datos);

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function findAll()
	{
		return $this->model->all();
	}

	public function findWith($id, $with)
	{
		return $this->model->with($with)->find($id);
	}

	public function findCustomMenuImages($claseId)
	{
		$userId  = \Auth::user()->id;
		$table   = $this->getTable();
		$query   = "SELECT * FROM `$table` WHERE `clase_id` = '$claseId' AND `user_id` = '$userId'";
		
		return $this->DBSelect($query);
	}	

	public function DBSelect($query)
	{
		return \DB::select($query);
	}

	public function last()
	{
		$all = $this->findAll();
		return $all->last();
	}

	public function deleteRecord($id)
	{
		$model = $this->find($id);
		$model->delete();
	}

	//Crea un nuevo registro en base a un array de datos de los campos a rellenar
	public function createNewRecord(array $datos, $entity = "")
	{		
		if (empty($entity))
		{
			$entity = $this->model;
		}

		$manager = $this->getManager($entity, $datos);

		if ($manager->save())
		{
			return true;
		}

		return $manager->errors();
	}

	public function newCreateNewRecord(array $datos, $manager = false, $entity = false)
	{		
		if ( ! $entity)
		{
			$entity = $this->model;
		}

		if ( ! $manager) $manager = $this->defaultManager($entity, $datos);

		if ($manager->save())
		{
			return true;
		}

		return $manager->errors();
	}

	public function numberFromString($string)
	{
		return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
	}

	public function processCheckboxs(array $data, array $names)
	{
		foreach ($names as $name)
		{
			if ( ! is_null($data[$name]))
				$data[$name] = 1;
			else
				$data[$name] = 0;
		}

		return $data;
	}

	public function timeStringToSeconds($timeString, $delimiter = ':')
	{
		$timeString  = explode(':', $timeString);

		$count = count($timeString);

		if ($three = ($count == 3) or $count == 2)
		{
			$hours   = (int) $timeString[0];
			$minuts  = (int) $timeString[1];
			$seconds = 0;
			if ($three)	$seconds = (int) $timeString[2];	

			$seconds = $hours * 3600 + $minuts * 60 + $seconds;

			return $seconds;
		}
		
		return null;
	}

	public function dateFormat($date, $format = 'Y-m-d H:i:s')
	{
		$check = explode('/', $date);
		if (count($check) > 1) $date = implode('-', $check);

		$date = new \DateTime($date);

		return $date->format($format);
	}

	public function currentDate()
	{
		return date('Y-m-d H-i-s', strtotime('+1 hour'));
	}

	public function addTime($add, $date)
	{
		return strtotime($add, strtotime($date));
	}
}