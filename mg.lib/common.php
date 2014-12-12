<?php

//-- Set Errors Display OFF Firstly
ini_set('display_errors', 'on');

//-- Common Definitions Described
define ('DS', DIRECTORY_SEPARATOR);
define ('BR', '<br />');
define ('SL', '/'); 
define ('ROOT', dirname(dirname(__FILE__)));
define ('LIBRARY', ROOT . DS . 'mg.lib');
define ('CONFIG', ROOT . DS . 'mg.cfg');
define ('INCLUDES', ROOT . DS . 'mg.inc');
define ('HELPER', INCLUDES . DS . 'helper');

//-- Configuration File Loaded
require_once (CONFIG . DS . 'config.php');

//----------------------------------------------
//------. $_SERVER['REQUEST_URI']; TBD
//----------------------------------------------
//$defDir = 
$fullUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : null) . '://' . $_SERVER['HTTP_HOST'] . SL . ENG_PATH . SL . ENG_BASE_DIR . SL; 
define ('APP_BASE_URL', $fullUrl);

//-- Define Dafault Application
if (APP_NAME != '') {
	define ('DEFAULT_APP' , ROOT . DS . 'mg.app' . DS . APP_NAME);
	define ('TEMPLATE_DIR', APP_BASE_URL . SL . 'mg.app' . SL . APP_NAME . SL);
} else {
	define ('DEFAULT_APP' , ROOT . DS . 'mg.app' . DS . 'default');	
	define ('TEMPLATE_DIR', APP_BASE_URL . SL . 'mg.app' . SL . 'default' . SL);
}

define ('VIEWS', DEFAULT_APP . DS . 'views');
define ('MODELS', DEFAULT_APP . DS . 'models');
define ('CONTROLLERS', DEFAULT_APP . DS . 'controllers');
define ('STYLESHEET', VIEWS . DS . 'css');
define ('IMAGES', VIEWS . DS . 'images');
define ('JAVASCRIPT', VIEWS . DS . 'js');


//-- Connection and Common Functions Loaded
require_once (LIBRARY . DS . 'conn.php');
require_once (LIBRARY . DS . 'functions.php');
