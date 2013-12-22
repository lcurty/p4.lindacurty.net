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
			$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
			$temp = explode(".", $_FILES["profile_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['profile_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/profile/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if (in_array($ext, $allowedExts)) {

					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/profile/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['profile_image']['tmp_name']);
					if (($ext == "gif") || ($ext == "GIF")) {
						header('Content-Type: image/gif');
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpg") || ($ext == "jpeg") || ($ext == "JPG") || ($ext == "JPEG")){
						header('Content-Type: image/jpg');
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						header('Content-Type: image/png');
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
					imagecopyresized($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

					# Move file to folder
					if (($ext == "gif") || ($ext == "GIF")) {
						imagegif($thumb, $target);
					} elseif (($ext == "jpg") || ($ext == "jpeg") || ($ext == "JPG") || ($ext == "JPEG")){
						imagejpeg($thumb, $target);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						imagepng($thumb, $target);
					}
					
					#Clear memory of images
					imagedestroy( $myImage );
					imagedestroy( $thumb );
				
					# Send to Database
					$_POST['profile_image'] = $ran2.$ext;
	
			} else {
				$error = "Invalid file";
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
		
	public function profile ($profile_id = NULL) {

		# Set user as default profile if no ID declared	and assign edit rights	
		if(!isset($profile_id)) {
			$profile_id 	= $this->user->user_id;
			$edit_rights	= 'Yes';
		} elseif(isset($profile_id) && $profile_id == $this->user->user_id) {
			$edit_rights	= 'Yes';
		} else {
			$edit_rights	= 'No';
		}
		
		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Farm Friends: Farmer Profile";
		
		# Get animal categories
		$q = "SELECT  
				animals.species,
				animals.default_image,
				COUNT(user_animal.user_animal_ID) AS animal_count
			FROM user_animal INNER JOIN animals ON user_animal.animal_ID = animals.animal_ID
			WHERE user_animal.user_id = ".$profile_id."
				AND user_animal.is_deleted = 0
			GROUP BY animals.species";

		# Run categories query, store the results in the variable $categories
		$categories = DB::instance(DB_NAME)->select_rows($q);
		
		# Get user information
		$q = 'SELECT 
				users.first_name,
				users.last_name,
				users.profile_image
			FROM users
			WHERE users.user_id = '.$profile_id;
				
		# Run users query, store the results in the variable $profiles
		$profiles = DB::instance(DB_NAME)->select_rows($q);
		
		# Get user animals
		$q = "SELECT 
				user_animal.user_animal_id,
				user_animal.adult_image,
				user_animal.baby_image,
				user_animal.animal_name,
				animals.species,
				animals.default_image,
				user_animal.breed,
				DATE_FORMAT(user_animal.born_date, '%m/%d/%Y') AS born_date,
				DATE_FORMAT(user_animal.estimated_born_date, '%m/%d/%Y') AS estimated_born_date,
				DATE_FORMAT(user_animal.acquired_date, '%m/%d/%Y') AS acquired_date,
				DATEDIFF(NOW(),user_animal.born_date) AS age_days,
				DATEDIFF(NOW(),user_animal.estimated_born_date) AS est_age_days,
				CASE WHEN user_animal.born_date NOT LIKE '0000-00-00' THEN
					CASE WHEN DATEDIFF(NOW(),user_animal.born_date) >= 365 THEN
							ROUND(DATEDIFF(NOW(),user_animal.born_date) / 365)
							 WHEN DATEDIFF(NOW(),user_animal.born_date) >= 60 THEN
								ROUND(DATEDIFF(NOW(),user_animal.born_date) / 30)
							 WHEN DATEDIFF(NOW(),user_animal.born_date) >= 14 THEN
								ROUND(DATEDIFF(NOW(),user_animal.born_date) / 7)
							 ELSE DATEDIFF(NOW(),user_animal.born_date)
						END
					  WHEN user_animal.estimated_born_date NOT LIKE '0000-00-00' THEN
							 CASE WHEN DATEDIFF(NOW(),user_animal.estimated_born_date) >= 365 THEN
							ROUND(DATEDIFF(NOW(),user_animal.estimated_born_date) / 365)
							 WHEN DATEDIFF(NOW(),user_animal.estimated_born_date) >= 60 THEN
								ROUND(DATEDIFF(NOW(),user_animal.estimated_born_date) / 30)
							 WHEN DATEDIFF(NOW(),user_animal.estimated_born_date) >= 14 THEN
								ROUND(DATEDIFF(NOW(),user_animal.estimated_born_date) / 7)
							 ELSE DATEDIFF(NOW(),user_animal.estimated_born_date)
						END
				END AS age,
				CASE WHEN user_animal.born_date NOT LIKE '0000-00-00' THEN
					CASE WHEN DATEDIFF(NOW(),user_animal.born_date) >= 365 THEN
							'Year(s)'
							 WHEN DATEDIFF(NOW(),user_animal.born_date) >= 60 THEN
								'Month(s)'
							 WHEN DATEDIFF(NOW(),user_animal.born_date) >= 14 THEN
								'Week(s)'
							 ELSE 'Day(s)'
						END
					  WHEN user_animal.estimated_born_date NOT LIKE '0000-00-00' THEN
					CASE WHEN DATEDIFF(NOW(),user_animal.estimated_born_date) >= 365 THEN
							'Year(s)'
							 WHEN DATEDIFF(NOW(),user_animal.estimated_born_date) >= 60 THEN
								'Month(s)'
							 WHEN DATEDIFF(NOW(),user_animal.estimated_born_date) >= 14 THEN
								'Week(s)'
							 ELSE 'Day(s)'
						END
				END AS age_category
			FROM user_animal INNER JOIN animals ON user_animal.animal_ID = animals.animal_ID
			WHERE user_animal.user_ID = ".$profile_id."
				AND user_animal.is_deleted = 0
			ORDER BY animal_name ASC";

		# Run posts query, store the results in the variable $posts
		$inventory = DB::instance(DB_NAME)->select_rows($q);

		# Inventory Count
		$inventory_count = DB::instance(DB_NAME)->select_field('SELECT COUNT(user_animal_id) FROM user_animal WHERE user_id = '.$profile_id);

		# Get list of users following
		$q = 'SELECT
				users.user_id,
				users.first_name,
				users.last_name,
				users.profile_image,
				users_users.user_id_followed
			FROM users INNER JOIN users_users ON users.user_ID = users_users.user_id_followed
			WHERE users_users.user_id = '.$profile_id.'
			ORDER BY users.first_name ASC, users.last_name ASC';
			
		# Run query
		$connections = DB::instance(DB_NAME)->select_array($q,'user_id_followed');


		# Connections Count
		$connections_count = DB::instance(DB_NAME)->select_field('SELECT COUNT(user_animal_id) FROM user_animal WHERE user_id = '.$profile_id);

		# Pass data to the view
    	$this->template->content->profiles  			= $profiles;
		$this->template->content->inventory 			= $inventory;
		$this->template->content->categories 			= $categories;
		$this->template->content->connections 			= $connections;
		$this->template->content->edit_rights 			= $edit_rights;
		$this->template->content->inventory_count 		= $inventory_count;
		$this->template->content->connections_count 	= $connections_count;
	
		# Render template
		echo $this->template;
	}
	
	public function edit() {

		# Setup view
		$this->template->content = View::instance('v_users_edit');
		$this->template->title   = "Farm Friends: Edit Profile";
		

		# Get user information
		$q = 'SELECT 
				users.first_name,
				users.last_name,
				users.profile_image
			FROM users
			WHERE users.user_id = '.$this->user->user_id;

		# Run posts query, store the results in the variable $posts
		$profiles = DB::instance(DB_NAME)->select_rows($q);
		
		#Pass data to the view
    	$this->template->content->profiles  	= $profiles;

		# Render template
		echo $this->template;

	}
	
	public function p_edit() {
		
		# More data we want stored with the user
		$_POST['modified'] = Time::now();       
		
		# Check if image added
		if(isset($_FILES['profile_image']['name']) && ($_FILES['profile_image']['name'] != "")){
			
			# Setup Image Restrictions
			$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
			$temp = explode(".", $_FILES["profile_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['profile_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/profile/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if (in_array($ext, $allowedExts)) {

					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/profile/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['profile_image']['tmp_name']);
					if (($ext == "gif") || ($ext == "GIF")) {
						header('Content-Type: image/gif');
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpg") || ($ext == "jpeg") || ($ext == "JPG") || ($ext == "JPEG")){
						header('Content-Type: image/jpg');
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						header('Content-Type: image/png');
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
					imagecopyresized($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

					# Move file to folder
					if (($ext == "gif") || ($ext == "GIF")) {
						imagegif($thumb, $target);
					} elseif (($ext == "jpg") || ($ext == "jpeg") || ($ext == "JPG") || ($ext == "JPEG")){
						imagejpeg($thumb, $target);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						imagepng($thumb, $target);
					}
					
					#Clear memory of images
					imagedestroy( $myImage );
					imagedestroy( $thumb );
				
					# Send to Database
					$_POST['profile_image'] = $ran2.$ext;
	
			} else {
				$error = "Invalid file";
			}
		} else { 

			# Repost old profile_image data to record
			$_POST['profile_image'] = $this->user->profile_image;

		}
		
		# Insert this user into the database and redirect to login page
		DB::instance(DB_NAME)->update('users', $_POST, 'WHERE user_ID = '.$this->user->user_id);
		Router::redirect("/users/profile");
	}

} # end of the class