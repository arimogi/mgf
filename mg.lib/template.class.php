<?php

class Template {
	
	protected $variables = array();
	protected $view_filename;
	protected $_controller;
	protected $_action;
	protected $notFound;
	
	function __construct($controller, $action) {
		$this->_controller = $controller;
		$this->_action = $action;
	}
	
	function set($name, $value) {
		$this->variables[$name] = $value;
	}	
	
	function setView($filename = 'index') {
		$this->view_filename = $filename;
	}

	function setHelper($fileHelper = '') {
		//echo "Template.class loading Helper<br>";
		//echo HELPER . DS . strtolower($fileHelper) . '.helper.php';

		if (file_exists( HELPER . DS . strtolower($fileHelper) . '.helper.php' )) {
			include ( HELPER . DS . strtolower($fileHelper) . '.helper.php' );
			//echo "Helper Loaded.<br>";
		}
	}
	
	function render() {
		extract($this->variables);
		
		if (file_exists(VIEWS . DS . strtolower($this->view_filename . '.php') )) {
			include (VIEWS . DS . strtolower($this->view_filename . '.php'));
		} else if ($this->view_filename == '') {
			if (DEVELOPMENT_MODE) 
				echo '<br />no view defined.';
		} else {
			//include ()
			//echo "404 - views ". $this->view_filename ." not found.";
			$notFoundFile = $this->view_filename;
			include (INCLUDES . DS . '404.php');
		}
	}
}