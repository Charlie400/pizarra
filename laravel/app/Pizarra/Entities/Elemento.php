<?php namespace Pizarra\Entities;

class Elemento extends \Eloquent {
	protected $fillable = ['Nombre', 'clase_id', 'user_id', 'fullname'];
}