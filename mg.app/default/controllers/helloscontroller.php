<?php

class HellosController extends Controller {
	
	function greetings() {
		$this->set('title', 'Hello World');
		$this->set('name', 'MGF - Yet Anoter PHP MVC Framework.');
		$this->setView('hello');
	}

	function index() {
		self::greetings();
	}
}