<?php 
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>

<html>
<head>
	<title>Welcome to FunFeed!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	
	<?php
	if(isset($_POST['register_button'])) {
		echo '
			<script> 
			$(document).ready(fucntion() {
				$("#first").hide();
				$("#second").show();
			});
			</script>
		';
	}
	?>

	<div class="wrapper">

		<div class="login_field">

			<div class="login_header">
				<h1>FunFeed!</h1>
				Login or Sign Up below!
			</div>

			<div id="first">
				<form action="register.php" method="POST">
					<input type="email" name="log_email" placeholder="Email Address">
					<br>
					<input type="password" name="log_password" placeholder="Password">
					<br>
					<input type="submit" name="login_button" value="Login">
					<br>
					<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo "Email or password was incorrect<br>" ?>
					<a href="#" id="signup" class="signup">Don't have an account? Register here!</a>
				</form>
			</div>

			<div id="second">
				<form action="register.php" method="POST">
					<input type="text" name="reg_fname" placeholder="First Name" value="<?php
					if(isset($_SESSION['reg_fname']))
						echo $_SESSION['reg_fname'];
					?>" required>
					<br>
					<?php if(in_array("Your first name must be between 2 to 25 characters<br>", $error_array)) echo "Your first name must be between 2 to 25 characters<br>"; ?>

					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php
					if(isset($_SESSION['reg_lname']))
						echo $_SESSION['reg_lname'];
					?>" required>
					<br>
					<?php if(in_array("Your last name must be between 2 to 25 characters<br>", $error_array)) echo "Your last name must be between 2 to 25 characters<br>"; ?>

					<input type="email" name="reg_email" placeholder="Email" value="<?php
					if(isset($_SESSION['reg_email']))
						echo $_SESSION['reg_email'];
					?>" required>
					<br>
					<?php if(in_array("Email already exists<br>", $error_array)) echo "Email already exists<br>";
						else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					?>

					<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php
					if(isset($_SESSION['reg_email2']))
						echo $_SESSION['reg_email2'];
					?>" required>
					<br>
					<?php if(in_array("Email do not match<br>", $error_array)) echo "Email do not match<br>"; ?>

					<input type="password" name="reg_password" placeholder="Password" required>
					<br>

					<input type="password" name="reg_password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your password do not match<br>", $error_array)) echo "Your password do not match<br>";
						else if(in_array("Your password can only contain English characters or numbers<br>", $error_array)) echo "Your password can only contain English characters or numbers<br>";
						else if(in_array("Your password must be between 5 to 30 characters<br>", $error_array)) echo "Your password must be between 5 to 30 characters<br>";
					?>

					<input type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>Register succesfully! Please log in now!</span><br>", $error_array)) echo "<span style='color: #14C800;'>Register succesfully! Please log in now!</span><br>"; ?>
					
					<a href="#" id="signin" class="signin">Already have an account? Login here!</a>
				</form>
			</div>

		</div>

	</div>

</body> 
</html>
























