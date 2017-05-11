<?php 

require_once ('unsecure_fns.php');

$email     = strtolower(trim($_POST['email']));
$username  = strtolower(trim($_POST['username']));
$firstName = trim($_POST['first-name']);
$lastName  = trim($_POST['last-name']);
$middleName   = trim($_POST['middle-name']);
$password  = trim($_POST['password']);
$password2 = trim($_POST['password2']);

$address = trim($_POST['address']);
$city    = trim($_POST['city']);
$state   = trim($_POST['state']);
$country = trim($_POST['country']);
$zip     = trim($_POST['zip-code']);
$phone   = trim($_POST['phone']);

session_start();//May need this later

try {
	
	if(!filled_out($_POST)) {
		
		throw new Exception('You have not filled the form out correctly - 
				Please go back and try again.'); 
	}
	
	if($password != $password2) {
		throw new Exception('Passwords do not match.');
	}
	
	if(strlen($password) < 8) {
		throw new Exception('Password too short!');
	}

	
	if(!preg_match("#[0-9]+#", $password) ) {
		throw new Exception('Password must include at least one number!');
	}
	
	if(!preg_match("#[a-z]+#", $password) ) {
		throw new Exception("Password must include at least one letter!");
	}
	
	if(!preg_match("#[A-Z]+#", $password) ) {
			throw new Exception("Password must include at least one capital letter");
	}
	
	if(!preg_match("#\W+#", $password) ) {
		
			throw new Exception("Password must include at least one symbol!");
	}
	
	if(!valid_email($email)) {
		
		throw new Exception("Email invalid!");
	}
	//Attempt to register
	
	register($username, $password, $email, $phone, $firstName,
				$middleName, $lastName, $address, $city, $state, $country, $zip);//Will throw exception
	
	//register session variable
	
	$_SESSION['valid_user'] = $username;
	
	do_html_header('Registration Successful!');
	
	echo 'Your registration was succesful. Go to the members page to start chatting!';
	
	do_html_url('https://unsecure.website/member.php', 'Go to members page');
	
	//End page
	
	do_html_footer();
	
} catch (Exception $e) {
	
	do_html_header('Problem:');
	echo $e->getMessage();
	
	do_html_url('https://unsecure.website/register_form.php', 'Register');
	
	do_html_footer();
	exit;
}
?>