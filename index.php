<?php
include ("includes/header.php"); 
session_destroy(); //Clear all Session's varable
 ?>

	<div class="user_details column">
		<a href="#"> <img src="<?php echo $user['profile_pic']; ?>"> </a>
	</div>    
</body>
</html>

