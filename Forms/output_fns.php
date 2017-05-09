<?php 

function do_html_header($title) {
	
	//print HTML header

?>

<!DOCTYPE html>

<html>
<head>
	<title><?php $title?></title>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body> 

<div class="container">
	<div id="banner"></div>
</div>

</body>
</html>

<?php 
}

function do_html_footer() { ?>

	<!DOCTYPE html>
	
	<html>
	<body> 
	
	<div class="container">
		Creator: Henning, Terry 
	</div>
	
	</body>
	</html>
<?php 
}

function display_login_form () {
?>

<!DOCTYPE html>

<html>

<body> 

<div class="container">
	
	<hl> Please Log In:</hl>
	
	<form method="post" action="member.php">
	
	<div class="row">
	
		<div class="col-md-3"><label for="name">Username:</label></div>
		<div class="col-md-5"> <input  type="text" name="name" id="name" maxlength="15" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password">Password:</label></div>
		<div class="col-md-5"> <input  type="text" name="password" id="password" maxlength="15" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5"> <button type="submit" name="submit">Log In</button> </div>  
		<div class="col-md-4"></div>
	</div>
	</form>
</div>

</body>
</html>
<?php 

}

function display_registration_form() {
?>

<!DOCTYPE html>

<html>

<body> 

<div class="container">
	
	<hl> Registration Form:</hl>
	
	<form method="post" action="register_new.php">
	
	 <div class="row">
    	<div class="col-md-3"><label for="username">Username (max 16 chars):</label></div>
    	<div class="col-md-5"> <input  type="text" name="username" id="username" maxlength="15" /> </div>
    	<div class="col-md-4"></div>
	</div>
	
	 <div class="row">
    	<div class="col-md-3"><label for="password">Password (12-160 chars):</label></div>
		<div class="col-md-5"> <input  type="text" name="password" id="password" maxlength="255" /> </div> 
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password2">Re-enter Password:</label></div>
		<div class="col-md-5"> <input  type="text" name="password2" id="password2" maxlength="255" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="first-name">First Name:</label></div>
		<div class="col-md-5"> <input  type="text" name="first-name" id="first-name" maxlength="15" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="middle-name">Middle Name:</label></div>
		<div class="col-md-5"> <input  type="text" name="middle-name" id="middle-name" maxlength="15" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="last-name">Last Name:</label></div>
		<div class="col-md-5"> <input  type="text" name="last-name" id="last-name" maxlength="15" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="address">Address:</label></div>
		<div class="col-md-5"> <input  type="text" name="address" id="address" maxlength="30" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
	
		<div class="col-md-3"><label for="city">City:</label></div>
		<div class="col-md-5"> <input  type="text" name="city" id="city" maxlength="30" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="state">State:</label></div>
		<div class="col-md-5"> <input  type="text" name="state" id="state" maxlength="30" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="country">Country:</label></div>
		<div class="col-md-5"> <input  type="text" name="country" id="country" maxlength="30" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="zip-code">Zip-code:</label></div>
		<div class="col-md-5"> <input  type="text" name="zip-code" id="zip-code" maxlength="15" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="phone">Phone:</label></div>
		<div class="col-md-5"> <input  type="text" name="phone" id="phone" maxlength="15" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="email">Email:</label></div>
		<div class="col-md-5"> <input  type="text" name="email" id="email" maxlength="30" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5"> <button type="submit" name="submit">Register</button> </div>  
		<div class="col-md-4"></div>
	</div>
	</form>
</div>

</body>
</html>

<?php 
}

function do_html_url($link, $text) {
	
?>
<!DOCTYPE html>
	
<html>
	
<body>
	
<div class="container">
	<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-5"> <a href="<?php echo $link?>/"><?php echo $text?></a></div>
	<div class="col-md-4"></div>
</div>

</body>
</html>
<?php
}

function display_password_form() {
	
?>

<!DOCTYPE html>

<html>

<body> 

<div class="container">
	
	<hl> Change Password:</hl>
	
	<form method="post" action="change_password_new.php">
	
	<div class="row">
	
		<div class="col-md-3"><label for="old-password">Old Password:</label></div>
		<div class="col-md-5"> <input  type="text" name="old-password" id="old-password" maxlength="255" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password">Password:</label></div>
		<div class="col-md-5"> <input  type="text" name="password" id="password" maxlength="255" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password2">Re-enter Password:</label></div>
		<div class="col-md-5"> <input  type="text" name="password2" id="password2" maxlength="255" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5"> <button type="submit" name="submit">Change Password</button> </div>  
		<div class="col-md-4"></div>
	</div>
	</form>
</div>

</body>
</html>
<?php

} 

function display_forgot_form() {
	
?>

<!DOCTYPE html>

<html>

<body> 

<div class="container">
	
	<hl> Forgot Your Password?</hl>
	
	<form method="post" action="forgot_passwd.php">
	
	<div class="row">
	
		<div class="col-md-3"><label for="username">Enter your username:</label></div>
		<div class="col-md-5"> <input  type="text" name="username" id="username" maxlength="15" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5"> <button type="submit" name="submit">Change Password</button> </div>  
		<div class="col-md-4"></div>
	</div>
	</form>
</div>

</body>
</html>
<?php

} 

?>

