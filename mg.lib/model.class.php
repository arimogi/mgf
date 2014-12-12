<?php

//*** Nama Model menjadi nama Table

class Model extends SQLQuery {
	protected $_model;
	
	function __construct() {
		$this->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$this->_model = get_class($this);
		$this->_table = strtolower($this->_model);
	}
	
	function __destruct(){
		//--
	}

}