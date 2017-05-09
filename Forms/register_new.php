<?php 

require_once ('unsecure_fns.php');

$email     = trim($_POST['email']);
$username  = trim($_POST['username']);
$firstName = trim($_POST['first-name']);
$lastName  = trim($_POST['last-name']);
$midName   = trim($_POST['middle-name']);
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
	
	if(!filled_out($POST)) {
		
		throw new Exception('You have not filled the form out correctly - 
				Please go back and try again.');
	}
	
	//Validate email
	
	if(!valid_email($email)) {
		
		throw new Exception('This is not a valid email address -
				Please go back and try again.');
	}
	
	//Check passwords
	
	if($password != password2) {
		throw new Exception('You have not filled the form out correctly -
				Please go back and try again.');
	}
	
	//Check length
	
	if((strlen($password) < 12) || (strlen($password) > 160)) {
		
		throw new Exception('Password must be between 12 and 160 characters -
				Please go back and try again.');
		
	}
	
	//Attempt to register
	
	register($username, $password, $email, $phone, $firstName,
				$middleName, $lastName, $address, $city, $state, $country, $zip);//Will throw exception
	
	//register session variable
	
	//$_SESSION['valid_user'];
	
	do_html_header('Registration Successful!');
	
	echo 'Your registration was succesful. Go to the members page to start chatting!';
	
	do_html_url('member.php', 'Go to members page');
	
	//End page
	
	do_html_footer();
	
} catch (Exception $e) {
	
	do_html_header('Problem');
	echo $e->getMessage();
	do_html_footer();
	exit;
}
?>