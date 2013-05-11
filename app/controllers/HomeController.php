<?php

class HomeController extends BaseController {

	public function __construct() {

	}

	public function index()
	{
		return View::make('home.index')
			->with('title', 'Home')
			;
	}

	public function show() {
		echo 'rew';
	}

}
