<?php 
    require 'config/config.php';

    // Login successful
    if(isset($_SESSION['username'])) {    
        $userLoggedIn = $_SESSION['username'];
        $user_details_query = mysqli_query($connect, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);
    } 
    else {   // Login fail
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

    <div class="top_bar">

        <div class="logo">
            <a href="index.php">Funfeed</a>
        </div>

        <nav>
            <a href="<?php echo $userLoggedIn; ?>">
                <?php echo $user['first_name']; ?>
            </a>

            <a href="index.php">
                <i class="fas fa-home"></i>
            </a>

            <a href="#">
                <i class="fas fa-user-friends"></i>
            </a>

            <a href="#">
                <i class="fab fa-facebook-messenger"></i>
            </a>

            <a href="#">
                <i class="fas fa-bell"></i>
            </a>

            <a href="#">
                <i class="fas fa-cog"></i>
            </a>  

            <a href="includes/handlers/logout.php">
                <i class="fas fa-sign-out-alt"></i>
            </a> 

        </nav>

    </div>

    <div class="wrapper">
