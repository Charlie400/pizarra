<?php namespace Pizarra\Components\FieldBuilder;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pizarra\Components\FieldBuilder\FieldBuilder
 */
class Field extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'field'; }

}