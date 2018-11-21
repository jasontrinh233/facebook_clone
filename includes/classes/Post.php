<?php 
class Post {
	private $con;
	private $user_obj;

	/**
	 * Constructor
	 * @param $con 		Connection variable
	 * @param $user 	Username
	 */
	public function __construct($con, $user) {
		$this->con = $con;
		$this->user_obj = new User($con, $user);

	}

	
	/**
	 * Submit post
	 * @param  {string} $body 		Content of the post
	 * @param  {string} $user_to 	User whom posted to
	 */
	public function submitPost($body, $user_to) {
		$body = strip_tags($body); // Strip any html tags
		$body = mysqli_real_escape_string($this->con, $body); // Create a legal SQL string that you can use in an SQL statement
		$check_empty = preg_replace('/\s+/', '', $body); // Delete all spaces (avoid posing a blank post)

		if($check_empty != "") {

			// Current date and time
			$date_added = date("Y-m-d H:i:s");

			// Get username
			$added_by = $this->user_obj->getUsername();

			// If user is not on own profile, user_to is 'none'
			if($user_to == $added_by) {
				$user_to = "none";
			}

			// Update post content into database
			$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");

			// Return post ID
			$returned_id = mysqli_insert_id($this->con);

			// Insert notification when user posts 

			// Update post counts for user
			$num_posts = $this->user_obj->getNumPosts();
			$num_posts++;
			$update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
		}

	}

}


 ?>