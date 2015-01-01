<?php namespace Pizarra\Components\Recorder;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pizarra\Components\FieldBuilder\FieldBuilder
 */
class Recorder extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'recorder'; }

}