<?php 

require_once ('unsecure_fns.php');

$oldPassword  = trim($_POST['old-password']);
$password  = trim($_POST['password']);
$password2 = trim($_POST['password2']);


session_start();//May need this later

try {
	
	if(!filled_out($POST)) {
		
		throw new Exception('You have not filled the form out correctly - 
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
	
	change_password($_SESSION['valid_user'], $oldPassword, $password);
	
	do_html_header('Password change Successful!');
	
	echo 'Your Password was changed succesfully. Please login.';
	
	do_html_url('login.php', 'Login');
	
	//End page
	
	do_html_footer();
	
} catch (Exception $e) {
	
	do_html_header('Problem');
	echo $e->getMessage();
	do_html_footer();
	exit;
}
?>