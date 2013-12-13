<?php
	class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 

	public function index() {
		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Farm Friends";

		# Render template
		echo $this->template;
	}

	public function signup($error = NULL) {
		# Setup view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title   = "Sign Up";
		
		#Pass data to the view
		$this->template->content->error = $error;

		# Render template
		echo $this->template;
	}
	
	public function p_signup() {
		# Check if unique email
		$q = "SELECT token
					FROM users
					WHERE email = '".$_POST['email']."'";
					
		$token = DB::instance(DB_NAME)->select_field($q);
		
		if($token) {
				Router::redirect("/users/signup/email-exists");
		}
		
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();       
		
		# Encrypt and salt the password  
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
		
		# Check if image added
		if(isset($_FILES['profile_image']['name']) && ($_FILES['profile_image']['name'] != "")){
			
			# Setup Image Restrictions
			$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "GIF", "JPEG", "PNG");
			$temp = explode(".", $_FILES["profile_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['profile_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/profile/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if ((($_FILES["profile_image"]["type"] == "image/gif")
				|| ($_FILES["profile_image"]["type"] == "image/jpeg")
				|| ($_FILES["profile_image"]["type"] == "image/jpg")
				|| ($_FILES["profile_image"]["type"] == "image/pjpeg")
				|| ($_FILES["profile_image"]["type"] == "image/x-png")
				|| ($_FILES["profile_image"]["type"] == "image/png"))
				&& in_array($ext, $allowedExts)) {
					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/profile/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['profile_image']['tmp_name']);
					header($_FILES["profile_image"]["type"]);
					if ($ext == "gif") {
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpg") || ($ext == "jpeg")){
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif ($ext == "png") {
						$myImage = imagecreatefrompng($crop_image);
					}
					list($width, $height) = getimagesize($crop_image);
					if ($width > $height) {
						$y = 0;
						$x = ($width - $height) / 2;
						$smallestSide = $height;
					} else {
						$x = 0;
						$y = ($height - $width) / 2;
						$smallestSide = $width;
					}
					$thumbSize = 200;
					$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
					imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
					
					# Move file to folder
					header($_FILES["profile_image"]["type"]);
					if (($ext == "gif") || ($ext == "GIF")) {
						imagegif($thumb, $target);
					} elseif (($ext == "jpeg") || ($ext == "jpg") || ($ext == "JPEG") || ($ext == "JPG")){
						imagejpeg($thumb, $target);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						imagepng($thumb, $target);
					}
				
					# Send to Database
					$_POST['profile_image'] = $ran2.$ext;
	
			} else {
				echo "Invalid file";
			}
		}
		
		# Insert this user into the database and redirect to login page
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
		Router::redirect("/users/login/signed-up");
	}

	public function login($error = NULL) {
		# Setup view
		$this->template->content = View::instance('v_users_login');
		$this->template->title   = "Login";
			
		# Pass data to the view
		$this->template->content->error = $error;

		# Render template
		echo $this->template;
	}
	
	public function p_login() {
		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
	
		# Hash submitted password so we can compare it against one in the db
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	
		# Search the db for this email and password, retrieve the token if it's available
		$q = "SELECT token 
			FROM users 
			WHERE email = '".$_POST['email']."' 
			AND password = '".$_POST['password']."'";

		$token = DB::instance(DB_NAME)->select_field($q);

		# Login failed
		if(!$token) {
			Router::redirect("/users/login/login-failed");
		}
		# Login passed
		else {
			setcookie("token", $token, strtotime('+2 weeks'), '/');
			Router::redirect("/users/profile");
		}
	}
	
	public function logout() {
		# Generate and save a new token for next login
    	$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
    	$data = Array("token" => $new_token);

    	# Do the update
    	DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

    	# Delete their token cookie
    	setcookie("token", "", strtotime('-1 year'), '/');

    	# Send them back to the main index.
    	Router::redirect("/");

	}
	
	public function profile () {
		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Farm Friends: Farmer Profile";
		
		# Query posts
		$q = 'SELECT 
				users.first_name,
				users.last_name,
				users.profile_image
			FROM users
			WHERE users.user_id = '.$this->user->user_id;
				
		# Run posts query, store the results in the variable $posts
		$profiles = DB::instance(DB_NAME)->select_rows($q);

		# Pass data (users and connections) to the view
    	$this->template->content->profiles       = $profiles;

		# Render template
		echo $this->template;
	}

} # end of the class