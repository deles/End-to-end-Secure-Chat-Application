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

function do_html_heading($title) {
	
	
?>

<!DOCTYPE html>

<html>

<body> 

<title><?php $title?></title>

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
	
	<form method="post" action="https://unsecure.website/member.php">
	
	<div class="row">
	
		<div class="col-md-3"><label for="username">Username:</label></div>
		<div class="col-md-5"> <input  type="text" name="username" id="username" value="" maxlength="255" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password">Password:</label></div>
		<div class="col-md-5"> <input  type="password" name="password" id="password" value="" maxlength="255" /> </div>  
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
	
	<form method="post" action="https://unsecure.website/register_new.php">
	
	 <div class="row">
    	<div class="col-md-3"><label for="username">Username (max 16 chars):</label></div>
    	<div class="col-md-5"> <input  type="text" name="username" id="username" value="" maxlength="15" /> </div>
    	<div class="col-md-4"></div>
	</div>
	
	 <div class="row">
    	<div class="col-md-3"><label for="password">Password (Must be at least 8 characters, at least one number, at least one letter, at least one capital letter, and at least one symbol (i.e, $,#,%):</label></div>
		<div class="col-md-5"> <input  type="password" name="password" id="password" value="" maxlength="255" /> </div> 
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password2">Re-enter Password:</label></div>
		<div class="col-md-5"> <input  type="password" name="password2" id="password2" value="" maxlength="255" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="first-name">First Name:</label></div>
		<div class="col-md-5"> <input  type="text" name="first-name" id="first-name" value="" maxlength="15" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="middle-name">Middle Name:</label></div>
		<div class="col-md-5"> <input  type="text" name="middle-name" id="middle-name" value="" maxlength="15" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="last-name">Last Name:</label></div>
		<div class="col-md-5"> <input  type="text" name="last-name" id="last-name" value="" maxlength="15" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="address">Address:</label></div>
		<div class="col-md-5"> <input  type="text" name="address" id="address" value="" maxlength="30" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
	
		<div class="col-md-3"><label for="city">City:</label></div>
		<div class="col-md-5"> <input  type="text" name="city" id="city" value="" maxlength="30" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="state">State:</label></div>
		<div class="col-md-5"> <input  type="text" name="state" id="state" value="" maxlength="30" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="country">Country:</label></div>
		<div class="col-md-5"> <input  type="text" name="country" id="country" value="" maxlength="30" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="zip-code">Zip-code:</label></div>
		<div class="col-md-5"> <input  type="text" name="zip-code" id="zip-code" value="" maxlength="15" /> </div> 
		<div class="col-md-4"></div> 
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="phone">Phone:</label></div>
		<div class="col-md-5"> <input  type="text" name="phone" id="phone" value="" maxlength="15" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="email">Email:</label></div>
		<div class="col-md-5"> <input  type="text" name="email" id="email" value="" maxlength="30" /> </div>  
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
	
	<form method="post" action="https://unsecure.website/change_password_new.php">
	
	<div class="row">
	
		<div class="col-md-3"><label for="old-password">Old Password:</label></div>
		<div class="col-md-5"> <input  type="password" name="old-password" id="old-password" value="" maxlength="255" /> </div>
		<div class="col-md-4"></div>  
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password">Password (Must be at least 8 characters, at least one number, at least one letter, at least one capital letter, and at least one symbol (i.e, $,#,%):</label></div>
		<div class="col-md-5"> <input  type="password" name="password" id="password"  value="" maxlength="255" /> </div>  
		<div class="col-md-4"></div>
	</div>
	
	<div class="row">
		<div class="col-md-3"><label for="password2">Re-enter Password:</label></div>
		<div class="col-md-5"> <input  type="password" name="password2" id="password2" value="" maxlength="255" /> </div>  
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
		<div class="col-md-5"> <input  type="text" name="username" id="username" value="" maxlength="15" /> </div>
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

function display_chat() {
	
?>

<!DOCTYPE html>

<html>
<head>
  
  <meta charset="utf-8">

  <link rel="stylesheet" href="bubble.css">
  
</head>

<body> 

<div id="uc"><h1 style="text-align:center"> Unsecure Chat</h1></div>

<div class="container">
	
	<div class="panel panel-default"> 
		<div class="panel-heading">
			<h2 class="panel-title">We're watching you...</h2>
		</div>
		
		<div class="panel-body" id="chatPanel"></div>
		<div class="panel-footer">
			<div class="input-group">
				<input type="type" class="form-control" id="chatMessage" placeholder="Type a message"/>
			    <span class=""input-group-btn">
			    	<button id="sendMessageBtn" class="btn btn-primary has-spinner" type="button"> 
			    		<span class="spinner"><i class="icon-spin icon-refresh"></i></span> Send
			    	</button>
			    </span>
			</div>
		</div>
	</div>
</div>

<script src="client.js"></script>
</body>
</html>




<?php 

}?>

