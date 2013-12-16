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

	Upload::upload($_FILES, "/uploads/", array("jpg", "jpeg", "gif", "png"), "foobar");
		
		# Access first element in file_obj array (b/c we're dealing with single file uploads only)
		$key = key($_FILES['profile_image']);
		
		$original_file_name = $file_obj[$key]['name'];
		$temp_file          = $file_obj[$key]['tmp_name'];
		$upload_dir         = 'images/profile/';
		$allowed_files		= array("jpg", "jpeg", "gif", "png");
		
		# If new file name not given, use original file name
		$new_file_name = $original_file_name;
		
		$file_parts  = pathinfo($original_file_name);
		$target_file = getcwd().$upload_dir . $new_file_name . "." . $file_parts['extension'];
								
		# Validate the filetype
		if (in_array($file_parts['extension'], $allowed_files)) {
	
			# Save the file
				move_uploaded_file($temp_file,$target_file);
				return $new_file_name . "." . $file_parts['extension'];
			# Write to db
			$_POST['profile_image'] = $new_file_name;
	
		} else {
			return 'Invalid file type.';
		}
	

		
//		# Check if image added
//		if(isset($_FILES['profile_image']['name']) && ($_FILES['profile_image']['name'] != "")){
//			
//			# Setup Image Restrictions
//			$allowedExts = array("gif", "jpeg", "jpg", "png");
//			$temp = explode(".", $_FILES["profile_image"]["name"]);
//			$extension = end($temp);
//			
//			# Rename File
//			$ext = pathinfo(($_FILES['profile_image']['name']), PATHINFO_EXTENSION); 
//			$type = $_FILES["profile_image"]["type"];
//			$ran = rand ();
//			$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
//			$target = "images/profile/";
//			$target = $target . $ran2.$ext;
//			
//			# Check Image Restrictions
//			if (((exif_imagetype($_FILES["profile_image"]["name"]) == "IMAGETYPE_GIF")
//				|| (exif_imagetype($_FILES["profile_image"]["name"]) == "IMAGETYPE_JPEG")
//				|| (exif_imagetype($_FILES["profile_image"]["name"]) == "IMAGETYPE_PNG"))
//				&& in_array($ext, $allowedExts)) {
//
//					if (file_exists($target)) {
//						
//						# Regenerate Random Number for New Filename
//						$ran = rand ();
//						$ran2 = pathinfo(($_FILES['profile_image']['name']), PATHINFO_FILENAME) . $ran.".";
//						$target = "images/profile/";
//						$target = $target . $ran2.$ext;
//					}
//					
//					# Resize and crop image
//					$crop_image = ($_FILES['profile_image']['tmp_name']);
//					header($_FILES["profile_image"]["type"]);
//					if ($ext == "gif") {
//						$myImage = imagecreatefromgif($crop_image);
//					} elseif (($ext == "jpg") || ($ext == "jpeg")){
//						$myImage = imagecreatefromjpeg($crop_image);
//					} elseif ($ext == "png") {
//						$myImage = imagecreatefrompng($crop_image);
//					}
//					list($width, $height) = getimagesize($crop_image);
//					if ($width > $height) {
//						$y = 0;
//						$x = ($width - $height) / 2;
//						$smallestSide = $height;
//					} else {
//						$x = 0;
//						$y = ($height - $width) / 2;
//						$smallestSide = $width;
//					}
//					$thumbSize = 100;
//					$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
//					imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
//					
//					# Move file to folder
//					header($_FILES["profile_image"]["type"]);
//					if ($ext == "gif") {
//						imagegif($thumb, $target);
//					} elseif (($ext == "jpeg") || ($ext == "jpg")){
//						imagejpeg($thumb, $target);
//					} elseif ($ext == "png") {
//						imagepng($thumb, $target);
//					}
//				
//					# Send to Database
//					$_POST['profile_image'] = $ran2.$ext;
//	
//			} else {
//				$error = "Invalid file";
//			}
//		}
		
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
		
		# Get user information
		$q = 'SELECT 
				users.first_name,
				users.last_name,
				users.profile_image
			FROM users
			WHERE users.user_id = '.$this->user->user_id;
				
		# Run posts query, store the results in the variable $posts
		$profiles = DB::instance(DB_NAME)->select_rows($q);
		
		# Get user animals
		$q = "
		
SELECT 
 user_animal.adult_image,
 user_animal.baby_image,
 user_animal.animal_name,
 animals.species,
 animals.default_image,
 user_animal.breed,
 user_animal.age AS calculated_age

FROM user_animal INNER JOIN animals ON user_animal.animal_ID = animals.animal_ID
ORDER BY animal_name ASC			
			";

		# Run posts query, store the results in the variable $posts
		$inventory = DB::instance(DB_NAME)->select_rows($q);

		#Pass data to the view
    	$this->template->content->profiles  	= $profiles;
		$this->template->content->inventory 	= $inventory;
	
		# Render template
		echo $this->template;
	}

} # end of the class