 <?php 

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //Check if valid email input then store as variable
	$_SESSION['log_email'] = $email; //Store email in to session variables

	$password = md5($_POST['log_password']); //Encrypt password

	//Perform database query
	$check_query = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' AND password='$password'");
	//Return number of rows of dupicate records in database
	$num_rows = mysqli_num_rows($check_query);
	
	//Login successfully
	if($num_rows == 1) {	
		$record = mysqli_fetch_array($check_query);
		$username = record['username'];
		$_SESSION['username'] = $username; //Condition of login successfully

		//Reopen closed account
		$user_closed_query = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' AND users_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1)
			$reoqen_account = mysqli_query($connect, "UPDATE users SET users_closed='no' WHERE email='$email'");

		header("Location: index.php"); //Once login, go to index.php
		exit();
	} else {
		array_push($error_array, "Email or password was incorrect<br>");
	}

	//Clear session variables
	$_SESSION['reg_fname'] = "";
	$_SESSION['reg_lname'] = "";
	$_SESSION['reg_email'] = "";
	$_SESSION['reg_email2'] = "";

}

 ?>