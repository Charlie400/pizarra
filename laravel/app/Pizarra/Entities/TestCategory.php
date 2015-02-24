<?php namespace Pizarra\Entities;

class TestCategory extends \Eloquent {
	protected $fillable = [];
	protected $table    = 'testcategories';

	public function getTable()
	{
		return $this->table;
	}

	public function test()
	{
		return $this->hasMany('Pizarra\Entities\Test', 'id_category', 'id');
	}

}