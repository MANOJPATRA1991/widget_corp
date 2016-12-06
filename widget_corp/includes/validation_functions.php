<?php

//initializing the $errors array
$errors = [];

//This function is used to convert the field names into valid field names by //replacing the _ with a space
function fieldname_as_text($fieldname){
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}

// * presence

function has_presence($value) {
	return isset($value) && $value !== "";
}

//this function checks if the required fields are valid
function validate_presences($required_fields){
    global $errors;
    foreach($required_fields as $field){
        $value = trim($_POST[$field]);
        if(!has_presence($value)){
            $errors[$field] = fieldname_as_text($field) . " can't be blank";
        }
    }
}
// * string length
// max length
function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

//this function checks if the fields are not longer than the length specified
function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	
	foreach($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
	  if (!has_max_length($value, $max)) {
	    $errors[$field] = fieldname_as_text($field) . " is too long";
	  }
	}
}

// * inclusion in a set
function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}

?>