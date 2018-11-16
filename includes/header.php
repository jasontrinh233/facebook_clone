<?php 
require('config/config.php');

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
} else {        //Fail to login, send back to register page
    header("Location: register.php");
}
?>

<html>
<head>
    <title>Welcome to Funfeed</title>

    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

    <div class="top_bar">
        <div class="logo">
            <a href="index.php">Funfeed</a>
        </div>
    </div>
