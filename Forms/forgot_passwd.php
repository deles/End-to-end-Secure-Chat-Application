<?php 

require_once ('unsecure_fns.php');

do_html_header("Resetting Password");

$username = $_POST['username'];

try {
	
	$password = reset_password($username);
	
	notify_password($username, $password);
	
	echo 'Your new password has been emailed to you. <br>';
	
} catch (Exception $e) {
	
	echo 'Your password could not be reset. Please try again later.';
}

do_html_url('login.php', 'Login');
do_html_footer();



?>