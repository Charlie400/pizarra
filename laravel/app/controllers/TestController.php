<?php

use Pizarra\Entities\Test;
use Pizarra\Entities\Respuesta;
use Pizarra\Entities\Pregunta;

use Pizarra\Managers\RespuestaManager;
use Pizarra\Managers\PreguntaManager;

use Pizarra\Repositories\TestRepo;

class TestController extends BaseController {

	protected $testRepo;

	public function __construct(TestRepo $testRepo)
	{
		$this->testRepo = $testRepo;
	}

	public function index()
	{
		return View::make('tests/config_test');
	}
}