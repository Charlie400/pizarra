<?php namespace Pizarra\Entities;

class Escenario extends \Eloquent {
	protected $fillable = ['Nombre', 'fullname', 'user_id', 'clase_id'];
}