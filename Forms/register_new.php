<?php 

require_once ('unsecure_fns.php');

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

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
	
	register($username, $email, $password);
	
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