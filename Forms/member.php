<?php 

require_once ('unsecure_fns.php');

session_start();

//create short variable names

if(!isset($_POST['username'])) {
	//if not isset, give dummy value
	
	$_POST['username'] = " ";
}

$username = $_POST['username'];

if(!isset($_POST['password'])) {
	//if not isset, give dummy value

	$_POST['password'] = " ";
}

$password = $_POST['password'];

if($username && $password) {
	
	//They're trying to log in
	try {
		
		login($username, $password);
		
		//if they are in database, register username 
		
		$_SESSION['valid_user'] = $username;
		
	} catch (Exception $e) {
		
		//Couldn't login
		do_html_header('Problem');
		
		echo 'You could not be logged in. <br> 
			  You must be logged in the view this page.';
		
		do_html_url('login.php', 'Login');
		do_html_footer();
		exit;
	}
	
do_html_header('Unsecured Home');

check_valid_user();

//chat app here
do_html_footer();
}

?>