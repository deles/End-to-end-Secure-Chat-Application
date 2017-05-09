<?php 
require_once ('unsecure_fns.php');

session_start();

do_html_header("Change Password:");

check_valid_user();

display_password_form();

do_html_footer();

?>