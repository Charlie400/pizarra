<?php namespace Pizarra\Entities;

class Material extends \Eloquent {
	protected $fillable = ['time', 'testtype', 'examen', 'titulo', 'descripcion', 'documento', 'desde', 'hasta', 
						   'visible', 'id_dominio'];
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
		$date = $this->dateFormat($value);

		$newDate =  strtotime("+23 hour 59 minute 59 second", strtotime($date));

		$this->attributes['hasta'] = date($this->format, $newDate);
	}

	public function setExamenAttribute($value)
	{
		if (is_null($value)) $this->attributes['examen'] = 0;
	}
}