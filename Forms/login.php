<?php 
	require_once ('unsecure_fns.php');
	
	do_html_header('The "Unsecure" Chat App!');
	
	//display_site_info();
	display_login_form();
	
	do_html_url('https://unsecure.website/register_form.php', 'Register');
	do_html_footer();
	
	

	//trigger_error("oh shit!", E_USER_ERROR);
	//error_log("shit!");
	
?>
