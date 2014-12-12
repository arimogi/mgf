<?php

//-- form helper file

/*
	format form_set: form_control/form_name

	form_data = {

		input[1] => {type => "text", name => "username", style => "", id => "", class => "", etc => "value"}
		input[0] => {type => "text", name => "username", style => "", id => "", class => "", etc => "value"}
	
	}
*/

function form_set($formAction = 'form/', $formName = 'myform', $formData = '') {
	$data = "<form action=\"". $formAction ."\" name=\"". $formName ."\" method=\"POST\">";
	
	foreach ($formData as $inputForm) {
		//$data .= var_dump($inputForm);
		
		if ($inputForm['type'] == "textarea"){
			$data .= "<textarea ";
			foreach ( array_keys($inputForm) as $keyName ) {
				if (($keyName !== "type") && ($keyName !== "value")) {
					$data .= $keyName . "=\"" . $inputForm[$keyName] . "\" ";	
				}
			}
			$data .= ">";
			$data .= $inputForm['value'];
			$data .= "</textarea>";
		} else {
			$data .= "<input ";
			foreach ( array_keys($inputForm) as $keyName ) {
				$data .= $keyName . "=\"" . $inputForm[$keyName] . "\" ";
			}
			$data .= "/>";
		}
		
	}

	$data .= "</form>";

	return $data;
}

function form_open($formAction = 'form/', $formName = 'myform') {
	$data = "<form action=\"". $formAction ."\" name=\"". $formName ."\" method=\"POST\">";

	return $data;
}

function form_close() {
	$data = "</form>";

	return $data;
}

function form_input($formData = [ "type" => "text", "name" => "text_name", "style" => "", "id" => "", "class" => "", "etc" => "etc_value" ]) {
	
	$data = "";
	if ($formData['type'] == "textarea"){
		$data .= "<textarea ";
		foreach ( array_keys($formData) as $keyName ) {
			if (($keyName !== "type") && ($keyName !== "value")) {
				$data .= $keyName . "=\"" . $formData[$keyName] . "\" ";	
			}
		}
		$data .= ">";
		$data .= $formData['value'];
		$data .= "</textarea>";
	} else {
		$data .= "<input ";
		foreach ( array_keys($formData) as $keyName ) {
			$data .= $keyName . "=\"" . $formData[$keyName] . "\" ";
		}
		$data .= "/>";
	}
	
	return $data;	
}

