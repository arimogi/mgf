<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;
	protected $_query;
	protected $_table;

	protected $_dbname;

	/*************************************************************************************************************
		DATABASE FUNCTION
		-----------------	
	*************************************************************************************************************/

    /** Connects to database **/
	
    function connect($address, $account, $pwd, $name) {
        $this->_dbHandle = @mysql_connect($address, $account, $pwd);
        if ($this->_dbHandle != 0) {
            if (mysql_select_db($name, $this->_dbHandle)) {
            	$this->_dbname = $name;
                return 1;
            }
            else {
            	echo "couldn't connected to database";
                return 0;
            }
        }
        else {
            return 0;
        }
    }
 
    /** Disconnects from database **/

    function disconnect() {
        if (@mysql_close($this->_dbHandle) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }
    

	/*************************************************************************************************************
		SQL FUNCTION
		------------
	*************************************************************************************************************/

	/** Get error string **/

	function getError() {
		return mysql_error($this->_dbHandle);
	}


	/*************************************************************************************************************
		QUERY FUNCTION
		--------------
	*************************************************************************************************************/

	/** Search By Field Name **/

	function searchBy($fieldName, $value) {
		$result = array();
		$resArray = array();

		$query = "SELECT * FROM `". $this->_dbname ."`.`" . $this->_table . "` WHERE `" . $fieldName . "`='" . $value . "';";
		//echo "Query: " . $query . BR;
		$res = mysql_query($query) or die('Error fetching query.' . BR);

		$cResArray = 0;
		while ($row = mysql_fetch_row($res)) {
			$cResult = 0;

			foreach ($row as $value) {
				$fieldArray = mysql_field_name($res, $cResult);
				$result[$fieldArray] = $value;
				$cResult++;
			}

			$resArray[0] = $result;
			$cResArray++;
		}

		//echo "Isi result: "; print_r($resArray);

		return $resArray;
	}

}