<?php

class TestController extends BaseController {
	public function index()
	{
		return View::make('tests/config_test');
	}
}