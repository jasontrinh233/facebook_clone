<?php
//Declares variables
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //Email
$em2 = ""; //Email 2
$password = ""; //Password 
$password2 = ""; //Password 2 
$date = ""; //Register date
$error_array = array(); //Holds error messages

//If register_button is pressed, assigning variables
if(isset($_POST['register_button'])) {

	//First name
	$fname = strip_tags($_POST['reg_fname']); //Remove html tags (if possible)
	$fname = str_replace(' ', '', $fname); //Remove spaces
	$fname = ucfirst(strtolower($fname)); //Upercase first letter
	$_SESSION['reg_fname'] = $fname; //Stores fname into session variables

	//Last name
	$lname = strip_tags($_POST['reg_lname']); //Remove html tags
	$lname = str_replace(' ', '', $lname); //Remove spaces
	$lname = ucfirst(strtolower($lname)); //Upercase first letter
	$_SESSION['reg_lname'] = $lname; //Stores lname into session variables

	//Email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em); //Remove spaces
	$_SESSION['reg_email'] = $em; //Stores em into session variables

	//Emmail 2
	$em2 = strip_tags($_POST['reg_email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2); //Remove spaces
	$_SESSION['reg_email2'] = $em2; //Stores em2 into session variables

	//Password 
	$password = strip_tags($_POST['reg_password']); //Remove html tags
	$password2 = strip_tags($_POST['reg_password2']); //Remove html tags

	//Register date
	$date = date('Y-m-d'); //Current date

	if($em == $em2){
		//Check if email is valid format
		if(filter_var($em, FILTER_VALIDATE_EMAIL)){
			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists
			$e_check = mysqli_query($connect, "SELECT email FROM users WHERE email='$em'");

			//Count nunber of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0){
				array_push($error_array, "Email already exists<br>");
			}
		} else {
			array_push($error_array, "Invalid email format<br>");
		}
	} else {
		array_push($error_array, "Email do not match<br>");
	}

	//Check first name is valid
	if(strlen($fname) > 25 || strlen($fname) < 2)
		array_push($error_array,"Your first name must be between 2 to 25 characters<br>");

	//Check last name is valid
	if(strlen($lname) > 25 || strlen($lname) < 2)
		array_push($error_array, "Your last name must be between 2 to 25 characters<br>");

	//Check password, password2 valid
	if($password != $password2){
		array_push($error_array,"Your password do not match<br>");
	}else{
		if(preg_match('/[^A-za-z0-9]/', $password))
			array_push($error_array, "Your password can only contain English characters or numbers<br>");
	}
	if( strlen($password) > 30 || strlen($password) < 5)
		array_push($error_array, "Your password must be between 5 to 30 characters<br>");

	//If no error, save record into database
	if(empty($error_array)){
		$password = md5($password); //Encrypting password 

		//Generate username 
		$username = strtolower($fname . "_" . $lname);

		//Check if username already in database
		$check_username_query = mysqli_query($connect, "SELECT username FROM users WHERE username='$username'");

		$i = 0;
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++;
			$username = $username . "_" . $i; 
			$check_username_query = mysqli_query($connect, "SELECT username FROM users WHERE username='$username'");
		}

		//Default profile picture
		$rand = rand(1,2);
		if($rand == 1)
			$profile_pic = "/assets/images/profile_pics/defaults/head_deep_blue.png";
		else if($rand == 2)
			$profile_pic = "/assets/images/profile_pics/defaults/head_emerald.png";

		//Save record into database
		$query = mysqli_query($connect, "INSERT INTO users VALUES('','$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

		//Register succesfully message
		array_push($error_array, "<span style='color: #14C800;'>Register succesfully! Please log in now!</span><br>");


		//Clear session variables
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
	}
}

?>