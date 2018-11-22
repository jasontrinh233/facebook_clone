<?php 
class User {
	private $user;
	private $con;

	/**
	 * Constructor
	 * @param $con 		Connection variable
	 * @param $user 	Username
	 */
	public function __construct($con, $user) {
		$this->con = $con; 
		$user_details_query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$user'");
		$this->user = mysqli_fetch_array($user_details_query);
	}

	/**
	 * @return {string} 	Username
	 */
	public function getUsername() {
		return $this->user['username'];
	}

	/**
	 * @return {int}  Number of posts
	 */
	public function getNumPosts() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['num_posts'];
	}

	/**
	 * @return {string}		User first and last name
	 */
	public function getFirstAndLastName() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
	}

	/**
	 * @return {boolean}	Return true if user has closed account
	 */
	public function isClosed() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT users_closed FROM users WHERE username='$username'");
		$row = mysqli_fetch_array($query);
		if($row['users_closed'] == 'yes') {
			return true;
		}
		return false;
	}

}




 ?>