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

	/**
	 * Load post into newsfeed
	 * @param {array} $data   Query data
	 * @param {int}   $limit  Limit posts loaded
	 * @return {void}
	 */
	public function loadPostsFriends($data, $limit) {

		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();

		// If first time loaded page, start table from 0
		if($page == 1)
			$start = 0;
		else
			$start = ($page - 1) * $limit; // otherwise, start table from this formula

		$str = ""; // Return string
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC"); // DESC means decendant order

		if(mysqli_num_rows($data_query) > 0) {

			$num_iterations = 0; // number of results checked (not neccessary posted)
			$count = 1;


			while($row = mysqli_fetch_array($data_query)) {
				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_time = $row['date_added'];

				// Prepare user_to string so it can be included even if not posted to a user
				if($row['user_to'] == "none") {
					$user_to = "";
				} else {
					$user_to_obj = new User($con, $row['user_to']);
					$user_to_name = $user_to_obj->getFirstAndLastName();
					$user_to = "to <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
				}

				// Check if user who posted has their account closed
				$added_by_obj = new User($this->con, $added_by);	
				if($added_by_obj->isClosed())
					continue;			

				if($num_iterations++ < $start)
					continue;

				// Once 10 posts have been loaded, break
				if($count > $limit)
					break; // break out of while
				else
					$count++;


				$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
				$user_row = mysqli_fetch_array($user_details_query);
				$first_name = $user_row['first_name'];
				$last_name = $user_row['last_name'];
				$profile_pic = $user_row['profile_pic'];

				// Timeframe for the post
				$date_time_current = date('Y-m-d H:i:s');
				$start_date = new DateTime($date_time);	// Time of post
				$end_date = new DateTime($date_time_current); // Current time
				$interval = $start_date->diff($end_date); // Difference between dates
				if($interval->y >= 1) {
					if($interval == 1)
						$time_message = $interval->y . " year ago"; // post occured 1 year ago
					else 
						$time_message = $interval->y . " years ago"; // post occured 1+ year ago
				}
				else if($interval->m >= 1) {
					// Checking days differences
					if($interval->d == 0)
						$days = " ago"; // post occured  1 month 0 day ago
					else if($interval->d == 1)
						$days = $interval->d . " day ago"; // post occured 1 month 1 day ago
					else
						$days = $interval->d . " days ago"; // post occured 1 month 1+ days ago

					// Checking months differences
					if($interval->m == 1)
						$time_message = $interval->m . " month" . $days; // post occured 1 month ago
					else 
						$time_message = $interval->m . " months" . $days; // post occured 1+ months ago
				}
				else if($interval->d >= 1) {
					if($interval->d == 1)
						$time_message = "Yesterday"; // post occured 1 day ago
					else
						$time_message = $interval->d . " days ago"; // post occured 1+ days ago
				}
				else if($interval->h >= 1) {
					if($interval->h == 1)
						$time_message = "1 hour ago"; // post occured 1 hour ago
					else
						$time_message = $interval->h . " hours ago"; // post occured 1+ hours ago
				}
				else if($interval->i >= 1) {
					if($interval->i == 1)
						$time_message = " minute ago"; // post occured 1 min ago
					else
						$time_message = $interval->i . " minutes ago"; // post occured 1+ mins ago
				}
				else {
					if($interval->s < 30)
						$time_message = "Just now"; // post occured <30 sec ago
					else
						$time_message = $interval->s . " seconds ago"; // post occured 1+ secs ago
				}

				$str .= "<div class='status_post'>
							<div class='post_profile_pic'>
								<img src='$profile_pic' width='50'>
							</div>

							<div class='posted_by' style='color: #acacac;'>
								<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
							</div>

							<div id='post_body'>
								$body
								<br>
							</div>

						</div>
						<hr>";

			} // End while

			if($count > $limit)
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
						 <input type='hidden' class='noMorePosts' value='false'>";
			else
				$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: center;'> No more posts to show! </p>";


		} // End if

		echo $str; // Print out the content of the post
	}


}


 ?>