<?php 

function filled_out($form_vars) {
	
	//test that each variable has a value
	
	foreach ($form_vars as $key => $value) {
		
		if((!isset($key) || ($value == ''))) {
			
			return false;
		}
	}
	return true;
}

function valid_email($email) {
	
	return (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email));
		
}

function is_user($username) {
	
	//Check for a unique username
	$sql = "SELECT COUNT(*) AS cnt
		    FROM customer
		    WHERE user_id = '$username'";;
	
	$stmt = $connection->query($sql);
	$result = $stmt->fetchAll();
	
	return $result[0]['cnt'] > 0;
	
}

function trim($value) {
	
	if ($value) {
		
		$value = $value.trim();
	} 
	
	return $value;
	
}
?>