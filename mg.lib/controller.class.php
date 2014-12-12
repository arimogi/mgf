<?php

class Controller {
	protected $_model;
	protected $_controller;
	protected $_action;
	protected $_template;
	//protected $_helper;
	protected $_requestdata;
	
	function __construct($model, $controller, $action, $requestData) {
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_model = $model;
		$this->_requestdata = $requestData;
		
		//---
		//echo "model: " . $model . BR;
		//echo "controller: " . $controller . BR;
		//echo "action: " . $action . BR;
		
		$this->$model = new $model;
		
		$this->_template = new Template($controller, $action);
	}
	
	function set($name, $value) {
		$this->_template->set($name, $value);
	}
	
	function setView($filename) {
		$this->_template->setView($filename);
	}

	function setTemplateDir() {
		$this->_template->set('TemplateDir', TEMPLATE_DIR);
	}

	function getBaseAppURL() {
		$this->_template->set('BaseAppURL', APP_BASE_URL);
	}

	function setHelper($fileHelper) {
		//echo "Controller.class loading Helper<br>";
		$this->_template->setHelper($fileHelper);
	}

	function getRenderTime() {
		$this->_template->set('RenderTime', getTimeRendering());
	}
	
	function __destruct() {
		$this->_template->render();
	}
}