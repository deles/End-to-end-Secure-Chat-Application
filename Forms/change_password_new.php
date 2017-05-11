<?php 

require_once ('unsecure_fns.php');

$oldPassword  = trim($_POST['old-password']);
$password  = trim($_POST['password']);
$password2 = trim($_POST['password2']);


session_start();//May need this later

try {
	
	if(!filled_out($_POST)) {
		
		throw new Exception('You have not filled the form out correctly - 
				Please go back and try again.');
	}

	//Check passwords
	
	if($password != $password2) {
		throw new Exception('You have not filled the form out correctly -
				Please go back and try again.');
	}
	
	if( strlen($password) < 8) {
		throw new Exception('Password too short!');
	}

	
	if( !preg_match("#[0-9]+#", $password) ) {
		throw new Exception('Password must include at least one number!');
	}
	
	if( !preg_match("#[a-z]+#", $password) ) {
		throw new Exception("Password must include at least one letter!");
	}
	
	if( !preg_match("#[A-Z]+#", $password) ) {
			throw new Exception("Password must include at least one capital letter");
	}
	
	if( !preg_match("#\W+#", $password) ) {
		
			throw new Exception("Password must include at least one symbol!");
	}
	
	if(is_old($_SESSION['valid_user'], $password)) {
		
		throw new Exception("Password must not have been previously used!");
	}
	
	if(!has_account($_SESSION['valid_user'], $oldPassword)) {//If old password is not valid
		
		throw new Exception("Old password is invalid!");
	}
	
	change_password($_SESSION['valid_user'], $oldPassword, $password);
	
	do_html_header('Password change Successful!');
	
	echo 'Your Password was changed succesfully. Please login.';
	
	do_html_url('https://unsecure.website/login.php', 'Login');
	
	//End page
	
	do_html_footer();
	
} catch (Exception $e) {
	
	do_html_header('Problem');
	echo $e->getMessage();
	do_html_footer();
	exit;
}
?>