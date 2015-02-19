<?php namespace Pizarra\Entities;

class Material extends \Eloquent {
	protected $fillable = ['time', 'testtype', 'examen', 'titulo', 'descripcion', 'documento', 'desde', 'hasta', 
						   'visible'];
	protected $table    = 'materiales';
	protected $format   = 'Y-m-d H:i:s';

	public function getTable()
	{
		return $this->table;
	}

	public function dateFormat($date)
	{
		$check = explode('/', $date);
		if (count($check) > 1) $date = implode('-', $check);

		$date = new \DateTime($date);

		return $date->format($this->format);
	}

	public function setDesdeAttribute($value)
	{
		$this->attributes['desde'] = $this->dateFormat($value);
	}

	public function setHastaAttribute($value)
	{
		$this->attributes['hasta'] = $this->dateFormat($value);
	}
}