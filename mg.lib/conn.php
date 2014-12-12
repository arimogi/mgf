<?php

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if ($conn) {
	$ress = mysql_select_db(DB_NAME, $conn);
	if (!($ress)){
		die ('Niagara falls.');
	}
} else {
	die('Sahara dessert.' . date("hhmmYY"));
}
mysql_close($conn);