<?php namespace Pizarra\Managers;

abstract class BaseManager
{

	protected $entity;
	protected $data;

	public function __construct($entity, $data)
	{
		$this->entity 	 = $entity;
		$this->data   	 = array_only($data, array_keys($this->getRules()));		
	}

	abstract public function getRules();

	public function isValid()
	{
		$rules = $this->getRules();

		$validation = \Validator::make($this->data, $rules);

		$isValid      = $validation->passes();		
		$this->errors = $validation->messages();

		return $isValid;
	}

	public function save()
	{
		if ( ! $this->isValid())
		{
			return false;
		}

		$this->entity->fill($this->data);		

		$this->entity->save();

		return $this->entity;
	}

	public function errors()
	{
		return $this->errors;
	}
}
