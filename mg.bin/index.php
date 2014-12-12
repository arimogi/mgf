<?php

//---------------------------------------- for tracing --------
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
define("START_TIME", $time);
//-------------------------------------------------------------

function catchUrl(){	
	return ( stripslashes( ($_GET['bowl']) ) );
}

$url = catchURL();
$requestData = $_REQUEST;

extract($requestData, EXTR_SKIP);

//echo "Caught POST: ";
//var_dump($requestData);
//var_dump($url);
//echo "<BR />" . $bowl . "<BR />" . $nama . "<BR />" . $alamat . "<BR />" . $submit . "<BR />";
//echo "Caught URL: " . $url . "<BR />";

require_once ('../mg.lib/common.php');