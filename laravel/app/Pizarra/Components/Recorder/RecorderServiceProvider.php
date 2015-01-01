<?php namespace Pizarra\Components\Recorder;

use Illuminate\Support\ServiceProvider;

class RecorderServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app['recorder'] = $this->app->share(function($app)
        {
        	$recorder = new RecorderUtils();
        	return $recorder;
        });
	}

}