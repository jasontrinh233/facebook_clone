<?php
ob_start(); //Turn on output buffering
session_start(); //Create a new session to hold variables

$timezone = date_default_timezone_set("America/Los_Angeles");

$connect = mysqli_connect("localhost", "root", "", "social"); //Connection variable

//Print out error if occurs
if(mysqli_connect_errno()) echo "Fail to connect: " . mysqli_connect_errno();
?>
