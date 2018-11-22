		<?php
		include("includes/header.php"); 
		include("includes/classes/User.php");
		include("includes/classes/Post.php");

		//If post button is clicked, post the post
		if(isset($_POST['post'])) {
			$post = new Post($connect, $userLoggedIn);
			$post->submitPost($_POST['post_text'], 'none');
		}

		 ?>

		<div class="user_details column">
			<a href="<?php echo $userLoggedIn; ?>"> <img src="<?php echo $user['profile_pic']; ?>"> </a> 

			<div class="user_details_left_right">
				<a href="<?php echo $userLoggedIn; ?>" style="color: #0a78c1;">
					<?php 
					echo $user['first_name'] . " " . $user['last_name'];
				 	?>
				</a>
				<br>
				<?php 
				echo "Posts: " . $user['num_posts'] . "<br>";
				echo "Likes: " . $user['num_likes'];
				 ?>
			</div>
		</div>    

		<div class="main_column column">

			<form class="post_form" action="index.php" method="POST">
				<textarea name="post_text" id="post_text" placeholder="What's on your mind?"></textarea>
				<input type="submit" name="post" id="post_button" value="Share">
				<hr>
			</form>

			 <div class="posts_area"></div>

			 <img id="loading" src="assets/images/icons/loading.gif">

		</div>

		<script>
			var userLoggedIn = '<?php echo $userLoggedIn; ?>';

			$(document).ready(function() {

				$('#loading').show(); // loading.gif will show when loading page

				// Original ajax request for loading first post
				$.ajax({ 
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=1&userLoggedIn=" + userLoggedIn,
					cache:false,

					success: function(data) {
						$('#loading').hide();  // hide loading.gif when done loading
						$('.posts_area').html(data);
					}
				});

				// This func render windows when scrolling
				$(window).scroll(function() {
					var height = $('.posts_area').height(); // div containing posts
					var scroll_top = $(this).scrollTop();
					var page = $('.posts_area').find('.nextPage').val();
					var noMorePosts = $('.posts_area').find('.noMorePosts').val();

					// When scroll bump to the top border of the page
					if( (document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && (noMorePosts == 'false') ) {
						$('#loading').show(); // loading.gif will show when loading page

						var ajaxReq = $.ajax({ 
											url: "includes/handlers/ajax_load_posts.php",
											type: "POST",
											data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
											cache:false,

											success: function(response) {
												$('.posts_area').find('.nextPage').remove(); 	// remove current .nextPage
												$('.posts_area').find('.noMorePosts').remove();	// remove current .noMorePosts
												$('#loading').hide();  // hide loading.gif when done loading
												$('.posts_area').append(response);
											}
										});
					} // End if

					return false;

				}) // End $(window).scroll(function())

			});


		</script>

	</div>

</body>
</html>

