<?php

/*

URL format: http://localhost/AppDir/command(s)/function/parameter1/parameter2/parameterN
Controller filename always in plural with (s) at the end.
Function name must be only one, case is ignored.

*/

session_start();
include("includes/functions.php");

class HellosController extends Controller {
	
	function index() {
		//-- set session for logged user;
		$_SESSION['logged'] = "FALSE";

		//-- for initialization page
		$this->set('title', 'Sistem Informasi');
		$this->setTemplateDir();
		$this->getRenderTime();
		$this->getBaseAppURL();

		//-- set view "hello" for index;
		$this->setView('hello');
	}

}