<?php 

require_once ('unsecure_fns.php');

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

?>