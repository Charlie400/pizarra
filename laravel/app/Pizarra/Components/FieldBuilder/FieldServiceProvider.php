<?php namespace Pizarra\Components\FieldBuilder;

use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app['field'] = $this->app->share(function($app)
        {
        	$fieldBuilder = new FieldBuilder();
        	return $fieldBuilder;
        });
	}

}