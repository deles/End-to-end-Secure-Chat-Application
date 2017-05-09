<?php 

require_once ('unsecure_fns.php');

do_html_header("Reset Password:");

check_valid_user();

display_forgot_form();

do_html_footer();

?>
