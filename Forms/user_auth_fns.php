<?php 

require_once ('unsecure_fns.php');

/**
 * Register the user
 * @Value unknown $username
 * @Value unknown $password
 * @Value unknown $email
 * @Value unknown $phone
 * @Value unknown $firstName
 * @Value unknown $middleName
 * @Value unknown $lastName
 * @Value unknown $address
 * @Value unknown $city
 * @Value unknown $state
 * @Value unknown $country
 * @Value unknown $zip
 * @throws Exception
 */
function register($username, $password, $email, $phone, $firstName,
					$middleName, $lastName, $address, $city, $state, $country, $zip) {
	
	$obj = new DBConnection();
	
	//Check for a unique username
	
	$result = is_user($username);
	
	if($result) {
		
		throw new Exception('That username is taken - Please choose another name.');
	}
	
	if(email_exist($email)) {
		
		throw new Exception('That email is in use - Please choose another email.');
	}
	
	//insert into database
	
	$stmt = $obj->getConn()->prepare("INSERT INTO customer (user_id, password, email, phone, first_name, middle_name, 
														last_name, address, city, state, country, zip_code, active, flag) 
							      VALUES (:user_id, :password, :email, :phone, :first_name, :middle_name, 
										  :last_name, :address, :city, :state, :country, :zip, :active, :flag)");
	

	$options = [
			'cost' => 9,
	];
	
	$hashPW = password_hash($password, PASSWORD_BCRYPT, $options);
	
	
	$stmt->bindValue(":user_id", $username, PDO::PARAM_STR);
	$stmt->bindValue(":password", $hashPW, PDO::PARAM_STR);
	$stmt->bindValue(":email", $email, PDO::PARAM_STR);
	$stmt->bindValue(":phone", $phone, PDO::PARAM_STR);
	$stmt->bindValue(":first_name", $firstName, PDO::PARAM_STR);
	$stmt->bindValue(":middle_name", $middleName, PDO::PARAM_STR);
	$stmt->bindValue(":last_name", $lastName, PDO::PARAM_STR);
	$stmt->bindValue(":address", $address, PDO::PARAM_STR);
	$stmt->bindValue(":city", $city,PDO::PARAM_STR);
	$stmt->bindValue(":state", $state, PDO::PARAM_STR);
	$stmt->bindValue(":country", $country, PDO::PARAM_STR);
	$stmt->bindValue(":zip", $zip, PDO::PARAM_STR);
	
	$active = 'Y';
	$flag   = 'C';
	
	$stmt->bindValue(":active", $active, PDO::PARAM_STR);
	$stmt->bindValue(":flag", $flag, PDO::PARAM_STR);
	
	$stmt->execute();
	
	$rows = $stmt->rowCount();

	if($rows <= 0) {
		
		throw new Exception('Could not register you in the database - Please try again later');
	}
	
	add_history($username, $hashPW);
	audit($username, "AA", "NA", "Active");
	
	return true;
}

/**
 * Check user against DB
 * @Value unknown $username
 * @Value unknown $password
 * @throws Exception
 */
function login($username, $password) {
	

	$verified = has_account($username, $password);
	
	if($verified != 1) {
		
		$attempts = get_failed_attempts($username);
		add_failed_attempts($username, $attempts + 1);
		
		if($attempts > 3) {
			
			lock_account($username);
			
			//if account is locked, notify user!
			echo 'This account has been locked! Contact the administrator!<br>';
		} else {
			echo 'Username or Password incorrect!<br>';
		}
		
		throw new Exception('Account cannot be accessed - Locked or incorrect PW');
	} 
	
	update_login($username);
	
	return true;
}

/**
 * Check if user has a valid session
 */
function check_valid_user() {
	
	//see if logged in; otherwise, notify them
	
	if(isset($_SESSION['valid_user'])) {
		
		echo "Logged in as ".$_SESSION['valid_user'].".<br>";
	} else {
		
		//They aren't logged in
		do_html_heading('Problem:');
		
		echo "You are not logged in.<br>";
		
		do_html_url('https://unsecure.website/login.php', 'Login');
		
		do_html_footer();
		exit;
	}
}

/**
 * This function updates the password
 * @Value unknown $username
 * @Value unknown $oldPass
 * @Value unknown $newPass
 * @throws Exception
 */
function change_password($username, $oldPass, $newPass) {
	
	$rows = 0;
	
	//If the password is right, change thier pass to the new one and return true
	// otherwise, throw an exception
	
	login($username, $oldPass);
	
	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('UPDATE customer
    						         SET password = :password
    							     WHERE user_id = :username');
	
	$options = [
			'cost' => 9,
	];
	
	$hashPW = password_hash($newPass, PASSWORD_BCRYPT, $options);
	
	$sth->bindValue(':username', $username);
	$sth->bindValue(':password', $hashPW);
	
	$sth->execute();
	
	$rows = $sth->rowCount();
	
	if($rows > 0) {
		
		add_history($username, $hashPW);
		audit($username, "AD", "oldpass", "newpass");
		
		return true;//change succesful
	} else {
		throw new Exception('Password could not be changed.');
	}
	
	return false;
}

/**
 * This function resets the password
 * @Value unknown $username
 * @throws Exception
 * @return unknown
 */
function reset_password($username) {
	
	//Set pass to random value 
	//return the new value or false on failure
	//get random dictionary word b/w 6 and 13 chars in length
	
	$newPass= getWord(6, 13);
	
	if($newPass == false) {
		
		throw new Exception('Could not create new password');
	}
	
	//add number 0-999
	
	$rand = rand(0,999);
	$newPass .= $rand;
	
	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('UPDATE customer
    						         SET password = :password
    							     WHERE user_id = :username');
	
	$options = [
			'cost' => 9,
	];
	
	$hashPW = password_hash($newPass, PASSWORD_BCRYPT, $options);
	
	$sth->bindValue(':username', $username);
	$sth->bindValue(':password', $hashPW);
	
	$sth->execute();
	
	$rows = $sth->rowCount();
	
	if($rows > 0) {
	
		return $newPass;//change succesful
	} else {
		throw new Exception('Password count not be changed.');
	}	
}

/**
 * This function grabs a word
 * @Value unknown $min
 * @Value unknown $max
 */
function getWord($min, $max) {
	
	$word = "";
	
	$dict = '/usr/share/dict/words';
	
	$fp = @fopen($dict, 'r');
	
	if(!$fp) {
		return false;
	}
	
	$size = filesize($dict);
	
	//rand location in dict
	$rand_loc = rand(0, $size);
	
	fseek($fp, $rand_loc);
	
	$len = strlen($word);
	
	while(($len < $min) || ($len > $max) || strstr($word, "'")) {
		
		if(feof($fp)) {
			
			fseek($fp, 0);//if at end, go to start
		}
		
		$word = fgets($fp, 80);//skip first 
		$word = fgets($fp, 80);
	}
	
	$word = trim($word);
	
	return $word;
}

function notify_password($username, $password) {
	
	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('SELECT email
    						         FROM customer
    							     WHERE user_id = :username');
	
	$sth->bindValue(':username', $username, PDO::PARAM_STR);
	
	$sth->execute();
	
	$result = $sth->fetchAll();
	
	if(sizeof($result) <= 0) {
	
		throw new Exception('Cannot find email!');
	}
	
	$email = $result[0]['email'];
	
	$to      = $email;
	$subject = 'Password reset for unsecure.website';
	$message = 'Your password has been changed to ($password) \r\nBe sure to reset on login.';
	$headers = 'From: webmaster@unsecure.website (DO NOT REPLY)' . "\r\n" .
			'Reply-To:' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	if(mail($to, $subject, $message, $headers)){
		
		return true;
		
	} else {
		
		throw new Exception('Could not send email');
	}
	
}
/**
 * 
 * @param unknown $username
 * @param unknown $hashPW
 * @throws Exception
 */
function add_history($username, $hashPW) {

	$obj = new DBConnection();
	
	//insert into database

	$stmt = $obj->getConn()->prepare("INSERT INTO history (user_id, password)
					      		      VALUES (:user_id, :password)");

	$stmt->bindValue(":user_id", $username, PDO::PARAM_STR);
	$stmt->bindValue(":password", $hashPW, PDO::PARAM_STR);

	$stmt->execute();

	$rows = $stmt->rowCount();

	if($rows <= 0) {

		error_log("Cannot add history");
		throw new Exception('Error - Please try again later');
	}

	return true;
}


function get_failed_attempts($username) {

	$obj = new DBConnection();

	$sth = $obj->getConn()->prepare('SELECT failed_attempts
    						         FROM customer
    							     WHERE user_id = :username');

	$sth->bindValue(':username', $username, PDO::PARAM_STR);

	$sth->execute();

	$result = $sth->fetchAll();

	if(sizeof($result) > 0) {

		return $result[0]['failed_attempts']; 
	}

	return  null;
}

function add_failed_attempts($username, $value) {

	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('UPDATE customer
    						         SET failed_attempts = :value
    							     WHERE user_id = :username');

	$sth->bindValue(':value', $value);
	$sth->bindValue(':username', $username);

	$sth->execute();
	
	$rows = $sth->rowCount();
	
	if($rows > 0) {
	
		return true;
	} else {
		throw new Exception('Cannot log in! Please try again later');
	}	
}

/**
 * 
 * @param unknown $username
 * @throws Exception
 * @return boolean
 */
function lock_account($username) {
	
	$flag = 'O';//flag
	
	$obj = new DBConnection();
	
	$sth = $obj->getConn()->prepare('UPDATE customer
    						         SET flag = :flag
    							     WHERE user_id = :username');
	
	$sth->bindValue(':flag', $flag);
	$sth->bindValue(':username', $username);
	
	
	$sth->execute();
	
	$rows = $sth->rowCount();
	
	if($rows > 0) {
	
		return true;
	} else if(is_locked($username)) {
		error_log("Account already locked");
		
	} else {
		
		error_log("Cannot lock account");
		throw new Exception('Cannot log in. Please try again later!');
	}
}

function is_locked($username) {

	$obj = new DBConnection();

	$sth = $obj->getConn()->prepare('SELECT flag
    						         FROM customer
    							     WHERE user_id = :username');

	$sth->bindValue(':username', $username, PDO::PARAM_STR);

	$sth->execute();

	$result = $sth->fetchAll();

	if(sizeof($result) > 0) {

		return $result[0]['flag'] == 'O';
	}

	return  null;
}

/**
 *
 * @param unknown $username
 * @throws Exception
 * @return boolean
 */
function update_login($username) {

	$flag = 'O';//flag

	$obj = new DBConnection();

	$sth = $obj->getConn()->prepare('UPDATE customer
    						         SET last_login = NOW()
    							     WHERE user_id = :username');

	$sth->bindValue(':username', $username);


	$sth->execute();

	$rows = $sth->rowCount();

	if($rows > 0) {

		return true;
	} else {

		error_log("Cannot update login date");
		throw new Exception('Cannot log in. Please try again later!');
	}
}

?>