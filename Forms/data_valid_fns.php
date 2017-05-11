<?php 


/**
 * 
 * @param unknown $form_vars
 */
function filled_out($form_vars) {
	
	//test that each variable has a value
	
	foreach ($form_vars as $key => $value) {
		
		if((!isset($key) || ($value == ''))  && $key != 'submit') {
			
			return false;
		}
	}
	return true;
}

function valid_email($email) {
	
	return (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email));
		
}


/**
 * 
 * @param unknown $username
 */
function is_user($username) {
	
	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('SELECT COUNT(*) AS cnt
		    					 FROM customer
    							 WHERE user_id = :username');
	
	$sth->bindParam(':username', $username, PDO::PARAM_STR, 15);
	
	$sth->execute();
	
	$result = $sth->fetchAll();
	
	return $result[0]['cnt'] > 0;
	
}

/**
 *
 * @param unknown $username
 */
function is_old($username, $password) {

	$obj = new DBConnection();

	$sth = $obj->getConn()->prepare('SELECT password 
		    					     FROM history
    							     WHERE user_id = :username');

	$sth->bindParam(':username', $username, PDO::PARAM_STR, 15);

	$sth->execute();

	$result = $sth->fetchAll();

	for($index = 0; $index < sizeof($result); $index++) {
		
		$verified = password_verify($password, $result[$index]['password']);
		
		if($verified) {
			return true;
		}
	}
	return false;

}

/**
 * 
 * @param unknown $username
 * @param unknown $password
 */
function has_account($username, $password) {
	
	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('SELECT user_id, password
    						     FROM customer
    							 WHERE user_id = :username');
	
	$sth->bindValue(':username', $username, PDO::PARAM_STR);
	
	$sth->execute();
	
	$result = $sth->fetchAll();
	
	if(sizeof($result) > 0) {
	
		return password_verify($password, $result[0]['password']); //returns alg, cost, and salt. Safe against timing attacks
	}
	
	return  false;
}

/**
 *
 * @param unknown $username
 * 
 */
function email_exist($email) {

	$obj = new DBConnection();

	$sth = $obj->getConn()->prepare('SELECT COUNT(*) AS cnt
    						     	 FROM customer
    							     WHERE email = :email');

	$sth->bindValue(':email', $email, PDO::PARAM_STR);

	$sth->execute();

	$result = $sth->fetchAll();

	return sizeof($result) > 0 && $result[0]['cnt'] >= 1; 
}


/**
 *
 * @param unknown $username
 * @param unknown $hashPW
 * @throws Exception
 */
function audit($username, $pid, $prev, $curr) {

	$obj = new DBConnection();

	//insert into database

	$stmt = $obj->getConn()->prepare("INSERT INTO audit (user_id, pid, prev, curr, date)
					      		      VALUES (:user_id, :pid, :prev, :curr, NOW())");
	
	$stmt->bindValue(":user_id", $username);
	$stmt->bindValue(":pid", $pid);
	$stmt->bindValue(":prev", $prev);
	$stmt->bindValue(":curr", $curr);
	
	$stmt->execute();

	$rows = $stmt->rowCount();

	if($rows <= 0) {

		error_log("Can't audit");
		throw new Exception('Cannot complete complete action');
	}

	return true;
}

?>