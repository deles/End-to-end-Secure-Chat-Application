<?php 

require_once ('unsecure_fns.php');

/**
 * Register the user
 * @param unknown $username
 * @param unknown $password
 * @param unknown $email
 * @param unknown $phone
 * @param unknown $firstName
 * @param unknown $middleName
 * @param unknown $lastName
 * @param unknown $address
 * @param unknown $city
 * @param unknown $state
 * @param unknown $country
 * @param unknown $zip
 * @throws Exception
 */
function register($username, $password, $email, $phone, $firstName,
					$middleName, $lastName, $address, $city, $state, $country, $zip) {
	
	$connection = new DBConnection();
	
	//Check for a unique username
	
	$result = is_user($username);
	
	if($result) {
		
		throw new Exception('That username is taken - Please choose another name.');
	}
	
	//insert into database
	
	$stmt = $connection->prepare("INSERT INTO customer (user_id, password, email, phone, first_name, middle_name, 
														last_name, address, city, state, country, zip, active, flag) 
							      VALUES (:user_id, :password, :email, :phone, :first_name, :middle_name, 
										  :last_name, :address, :city, :state, :country, :zip, :active, :flag)");
	
	$stmt->bindParam(':user_id', $username);
	$stmt->bindParam(':password', $hashPW);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':phone', $phone);
	$stmt->bindParam(':first_name', $firstName);
	$stmt->bindParam(':middle_name', $middleName);
	$stmt->bindParam(':last_name', $lastName);
	$stmt->bindParam(':address', $address);
	$stmt->bindParam(':city', $city);
	$stmt->bindParam(':state', $state);
	$stmt->bindParam(':country', $country);
	$stmt->bindParam(':zip_code', $zip);
	$stmt->bindParam(':active', 'Y');
	$stmt->bindParam(':flag', 'C');
	
	
	$options = [
			'cost' => 9,
	];
	
	$hashPW = password_hash($password, PASSWORD_BCRYPT, $options);

	
	$stmt->execute();
	
	if(!$result) {
		
		throw new Exception('Could not register you in the database - Please try again later');
	}
	
	return true;
}

/**
 * Check user against DB
 * @param unknown $username
 * @param unknown $password
 * @throws Exception
 */
function login($username, $password) {
	
	$connection = new DBConnection();
	
	$sth = $connection->prepare('SELECT user_id, password
    						     FROM customer
    							 WHERE user_id = :username');
	
	$sth->bindParam(':username', $username, PDO::PARAM_STR, 15);
	$sth->bindParam(':password', $password, PDO::PARAM_STR, 255);
	
	$sth->execute();
	
	$result = $sth->fetchAll();
	
	$verified = password_verify($password, $result[0]['password']); //returns alg, cost, and salt. Safe against timing attacks
	
	if(sizeof($result) <= 0 || !verified) {
		
		throw new Exception('Username or Password incorrect!');
	}
	
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
		do_html_header('Problem:');
		
		echo "You are not logged in.<br>";
		
		do_html_url('login.php', 'Login');
		
		do_html_footer();
		exit;
	}
}

/**
 * This function updates the password
 * @param unknown $username
 * @param unknown $oldPass
 * @param unknown $newPass
 * @throws Exception
 */
function change_password($username, $oldPass, $newPass) {
	
	$rows = 0;
	
	//If the password is right, change thier pass to the new one and return true
	// otherwise, throw an exception
	
	login($username, $oldPass);
	
	$connection = new DBConnection();
	
	$sth = $connection->prepare('UPDATE customer
    						     SET password = :password
    							 WHERE user_id = :username');
	
	$options = [
			'cost' => 9,
	];
	
	$hashPW = password_hash($newPass, PASSWORD_BCRYPT, $options);
	
	$sth->bindParam(':username', $username);
	$sth->bindParam(':password', $hashPW);
	
	$sth->execute();
	
	$rows = $sth->rowCount();
	
	if($rows > 0) {
		
		return true;//change succesful
	} else {
		throw new Exception('Password could not be changed.');
	}
}

/**
 * This function resets the password
 * @param unknown $username
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
	
	$connection = new DBConnection();
	
	$sth = $connection->prepare('UPDATE customer
    						     SET password = :password
    							 WHERE user_id = :username');
	
	$options = [
			'cost' => 9,
	];
	
	$hashPW = password_hash($newPass, PASSWORD_BCRYPT, $options);
	
	$sth->bindParam(':username', $username);
	$sth->bindParam(':password', $hashPW);
	
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
 * @param unknown $min
 * @param unknown $max
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
	
	$connection = new DBConnection();
	
	$sth = $connection->prepare('SELECT email
    						     FROM customer
    							 WHERE user_id = :username');
	
	$sth->bindParam(':username', $username, PDO::PARAM_STR, 15);
	
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
?>