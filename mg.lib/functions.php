<?php

include "process.php";

//-- Prepares
function setReporting() {
	//echo ROOT . DS . 'mg.tmp' . DS . 'logs' . DS . 'error.log';
	if (DEVELOPMENT_MODE == true) {
		error_reporting(E_ALL);
		ini_set('display_errors', 'On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors', 'Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT . DS . 'mg.tmp' . DS . 'logs' . DS . 'error.log');
	}
}

function sfw_error_handling($errno, $errstr, $errfile, $errline) {
	echo "$errno" . BR;
}

function stripSlashesDeep($value) {
	$value = is_array($value) ? 
	           array_map("stripSlashesDeep", $value) : 
			   stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
	if ( get_magic_quotes_gpc() ) {
		$_GET = stripSlashesDeep($_GET);
		$_POST = stripSlashesDeep($_POST);
		$_COOKIE = stripSlashesDeep($_COOKIE);		
	}
}

function unregisterGlobals() {
	if ( ini_get('register_globals') ) {
		$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
		foreach ($array as $value) {
			foreach ($GLOBALS[$value] as $key => $var) {
				if ($var === $GLOBALS[$key]) {
					unset($GLOBALS[$key]);
				}
			}
		}			
	}
}

function checkAppInstalled() {
	$isThereAppInstalled = FALSE;

	if (is_dir(DEFAULT_APP)) {
		if (is_dir(VIEWS) && is_dir(MODELS) && is_dir(CONTROLLERS)){
			$isThereAppInstalled = TRUE;
		}
	}
	return $isThereAppInstalled;
}

function callHook() {
	
	if (checkAppInstalled() == FALSE) {
		include (INCLUDES . DS . 'noApp.php');
		die(BR . 'Check App.');
	}

	//-- check again here someday
	if (!(defined('ACTION_DEFAULT'))) {
			define ('ACTION_DEFAULT', 'index');			
	}

	global $url;
	global $requestData;
	$urlArray = array();
	
	//====================================================================
	//
	//-- URL format: command(s)/function/parameter
	//				 - command(s) always in plural with 's' at the end
	//				 - function
	//				 - parameter
	//
	//====================================================================
	$url = trim($url);
	$urlArray = explode("/", $url);
		
	if ($url == '') {
		$controller = ROUTE_DEFAULT;		
		$action = ACTION_DEFAULT;
		
		$parameter = $urlArray;
		
		//-- $controllerName = controller filename, lower case. example: hellos.controller.php
		//-- Controller name is always plural. Ended by 's';
		$controllerName = strtolower($controller);
		$controller = ucwords($controller);
		
		//-- model is always singular, no 's' in the end.
		$model = rtrim($controller, 's');
		$controller .= 'Controller';
		//echo "Controller: " . $controller . BR;
		
		//echo MODELS . DS . strtolower($model) . '.model.php' . BR;
		if (!(file_exists(MODELS . DS . strtolower($model) . '.model.php'))) {
			$model = 'ModelDefault';
			//echo "model default";
		} else {
			//echo "file model: " . MODELS . DS . strtolower($model) . '.model.php' . BR;
		}
		
		//echo "model/controllerName/action/controller: " . $model . SL . $controllerName . SL . $action . SL . $controller . BR;
		$dispatch = new $controller($model, $controllerName, $action, $requestData);
		
		if ((int)method_exists($controller, $action)) {
			call_user_func_array(array($dispatch, $action), $parameter);		
		} else {
			//-- Error Generating Code		
		}
	} else {		
		//-- check the $controllerName, for stylesheet, javascript, and images handle. or (strtolower($controller) == 'images')
		if (strtolower($urlArray[0]) == "images") {
			//echo "images" . BR . IMAGES . DS . $urlArray[1];
			
			header('Content-type: image/gif');	
			$handle = fopen(IMAGES . DS . $urlArray[1], "r");
			$iconContent = fread($handle, filesize(IMAGES . DS . $urlArray[1]));
			print($iconContent);
			fclose($handle);			
		} else if (strtolower($urlArray[0]) == "stylesheet") {
			//echo "stylesheet" . BR;
			include STYLESHEET . DS . $urlArray[1];
		} else if (strtolower($urlArray[0]) == "js") {
			//echo "javascript" . BR;
			include JAVASCRIPT . DS . $urlArray[1];
		} else if (strtolower($urlArray[0]) == "form") {
			echo "form appeared";
			//--
		} else {
			//echo "else";
			$parameter = array();
			$controller = "";
			$action = "";

			//echo "Url Array count: " . count($urlArray) . BR;
			//-- check URL Array
			if (count($urlArray) == 0) {
				//-- die('African Savannah');
				//-- no command, no function, no parameter
				//echo "no command function parameter" . BR;
			} else if (count($urlArray) == 1) {
				//-- command only
				$controller = $urlArray[0];
				//echo "command no function parameter" . BR;
			} else if (count($urlArray) == 2) {
				//-- command and function
				$controller = $urlArray[0];
				array_shift($urlArray);
				$action = $urlArray[0];
				//echo "command function no parameter" . BR;
			} else {
				//-- command, function, and parameters
				$controller = $urlArray[0];
				array_shift($urlArray);
				$action = $urlArray[0];
				array_shift($urlArray);
				
				for ($i=0; $i<count($urlArray); $i++) {
					$parameter[$i] = $urlArray[$i];
				}
				//echo "command function parameter" . BR;
			}
						
			//-- $controllerName = controller filename, title case.
			//-- Controller name is always plural. Ended by 's';
			$controllerName = strtolower($controller);
			$controller = ucwords($controller);
			
			//-- model is always singular, no 's' in the end.
			$model = rtrim($controller, 's');
			$controller .= '.controller.php';
			
			//-- 
			//echo $model . BR . $controllerName . BR . $action . BR;
			if (!(file_exists(MODELS . DS . strtolower($model) . '.model.php'))) {
				$model = 'ModelDefault';
				//echo "file model: " . $model;
			} else {
				//echo "file model: " . MODELS . DS . strtolower($model) . '.model.php' . BR;
			}
			
			if (! ( file_exists( CONTROLLERS . DS . $controller ) ) ) {
				//echo "No Controller" . BR;
				//echo CONTROLLERS . DS . ucfirst($controllerName) . 'Controller.php' . BR;
				//echo "<script>window.location.href = \"" . APP_BASE_URL . "\"</script>";
			} else {
				$dispatch = new $controller($model, $controllerName, $action, $requestData);
			}

			/*set_error_handler("sfw_error_handling");
			try {
				$dispatch = new $controller($model, $controllerName, $action);
			} catch (Exception $e) {
				//
			}*/

			if ((int)method_exists($controller, $action)) {
				//echo BR . "Isi Parameter: " . $parameter . BR . var_dump($dispatch) . BR;
				call_user_func_array(array($dispatch, $action), $parameter);
			} else {
				//-- Error Generating Code
				echo "No Action" . BR;
				//echo "<script>window.location.href = \"" . APP_BASE_URL . "\"</script>";
			}
		}
	}
}

//---------- Autoload function
function __autoload($className) {
	
	/*echo (BR . "Loading: " . $className . BR);

	echo LIBRARY . DS . strtolower($className) . '.class.php' . BR;
	echo CONTROLLERS . DS . strtolower($className) . '.php' . BR;
	echo MODELS . DS . strtolower($className) . '.class.php' . BR;*/
	

	if (file_exists(LIBRARY . DS . strtolower($className) . '.class.php')) {
		//echo "loaded 1: " . LIBRARY . DS . strtolower($className) . '.class.php' . BR;
		//-----------------------------------------------------------------
		/*
				Class is always singular and have name ".class.php" in filename.
				example: hello.class.php
		 */
		//-----------------------------------------------------------------
		require_once (LIBRARY . DS . strtolower($className) . '.class.php');
		
	} else if (file_exists(CONTROLLERS . DS . strtolower($className) . '.php')) {
		//echo ('loaded 2:' . BR . CONTROLLERS . DS . strtolower($className) . '.php');
		//-----------------------------------------------------------------
		/*
				Controller filename always plural and followed by "Controller.php" in filename.
				example: ItemsController.php
				
				Class name in controller file is same like controller filename.
				example: Class ItemsController extends Controller{}
		 */
		//-----------------------------------------------------------------
		require_once (CONTROLLERS . DS . strtolower($className) . '.php');
		
	} else if (file_exists(MODELS . DS . strtolower($className) . '.model.php')) {
		//echo "loaded 3: ". (MODELS . DS . strtolower($className) . '.class.php');
		//-----------------------------------------------------------------
		/*
				Model is always singular and have name ".model.php" in filename.
				example: hello.model.php
		 */
		//-----------------------------------------------------------------
		require_once (MODELS . DS . strtolower($className) . '.model.php');
	/*
	} else if (file_exists(HELPER . DS . strtolower($className) . '.helper.php')) {
		//echo "loaded 3: ". (HELPER . DS . strtolower($className) . '.helper.php');
		//-----------------------------------------------------------------
		/*
				Helper is always singular and have name ".helper.php" in filename.
				example: form.helper.php
		 * /
		//-----------------------------------------------------------------
		require_once (HELPER . DS . strtolower($className) . '.helper.php');
	*/
	} else {
		//-- Error Generating Code
		/*echo ("loaded: " . LIBRARY . DS . strtolower($className) . '.class.php' . BR);
		echo (CONTROLLERS . DS . strtolower($className) . '.php' . BR);
		echo ("loaded 2: ". (MODELS . DS . strtolower($className) . '.class.php') . BR);*/
		//--
		//echo "Class or model for: <strong>" . $className . "</strong> could not be found.<br />Please check your application filename.";
		if (DEVELOPMENT_MODE) {
			if (!(file_exists(MODELS . DS . strtolower($className) . '.model.php'))) {
				echo BR . "No Models for this Controller. Model set to 'default.model.php'";
				//echo BR . MODELS . DS . strtolower($className) . '.model.php';
				//$model = MODELS . DS . 'default.model.php';
			} else {

			}
		} else {
			echo "No Model" . BR;
			echo "<script>window.location.href = \"" . APP_BASE_URL . "\"</script>";
		}
	}
}

function getTimeRendering() {
	$start = START_TIME;
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	//echo 'Page generated in '.$total_time.' seconds.';
	return $total_time;
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();