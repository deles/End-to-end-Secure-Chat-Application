<?php 
require_once ('unsecure_fns.php');

session_start();

$old_user = $_SESSION['valid_user'];

unset($_SESSION['valid_user']);

$result_dest = session_destroy();

//output html

do_html_header("Logging Out");

if(!empty($old_user)) {
	
	if($result_dest) {
		
		//If they were logged in and are now logged out
		
		echo 'Logged out. <br>';
		do_html_url('login.php', 'Login');
	} else {
		//They were logged in and can't be logged out
		
		echo 'Could not log you out';
		
	}
} else {
	
	//If they weren't logged in but came to this page somehow
	
	echo 'You are not logged in. Therefore, you have not been logged out!<br>';
	
	do_html_url('login.php', 'Login');
}
	do_html_footer();
?>