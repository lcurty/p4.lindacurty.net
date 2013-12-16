<?php
	class animals_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 

	public function index() {
		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Farm Friends: Farmer Profile";

		# Render template
		echo $this->template;
	}

	public function add($error = NULL) {
		# Setup view
		$this->template->content = View::instance('v_animals_add');
		$this->template->title   = "Add a New Animal";

		$q = "SELECT 
				animal_ID,
				species 
			FROM animals 
			ORDER BY species ASC";

		# Run posts query, store the results in the variable $posts
		$animal_list = DB::instance(DB_NAME)->select_rows($q);

		#Pass data to the view
		$this->template->content->animal_list = $animal_list;
		$this->template->content->error = $error;

		# Render template
		echo $this->template;
	}
	
	public function p_add() {
		
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();       
		$_POST['user_ID'] = $this->user->user_id;       
				
		# Check if baby image added
		if(isset($_FILES['baby_image']['name']) && ($_FILES['baby_image']['name'] != "")){
			
			# Setup Image Restrictions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["baby_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['baby_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['baby_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/animals/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if (in_array($ext, $allowedExts)) {

					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['baby_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/animals/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['baby_image']['tmp_name']);
					if ($ext == "gif") {
						header('Content-Type: image/gif');
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpg") || ($ext == "jpeg")){
						header('Content-Type: image/jpg');
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif ($ext == "png") {
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
					if ($ext == "gif") {
						imagegif($thumb, $target);
					} elseif (($ext == "jpeg") || ($ext == "jpg")){
						imagejpeg($thumb, $target);
					} elseif ($ext == "png") {
						imagepng($thumb, $target);
					}
					
					#Clear memory of images
					imagedestroy( $myImage );
					imagedestroy( $thumb );
				
					# Send to Database
					$_POST['baby_image'] = $ran2.$ext;
	
			} else {
				$error = "Invalid file";
			}
		}

		# Check if adult image added
		if(isset($_FILES['adult_image']['name']) && ($_FILES['adult_image']['name'] != "")){
			
			# Setup Image Restrictions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["adult_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['adult_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['adult_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/animals/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if (in_array($ext, $allowedExts)) {

					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['adult_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/animals/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['adult_image']['tmp_name']);
					if ($ext == "gif") {
						header('Content-Type: image/gif');
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpg") || ($ext == "jpeg")){
						header('Content-Type: image/jpg');
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif ($ext == "png") {
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
					if ($ext == "gif") {
						imagegif($thumb, $target);
					} elseif (($ext == "jpeg") || ($ext == "jpg")){
						imagejpeg($thumb, $target);
					} elseif ($ext == "png") {
						imagepng($thumb, $target);
					}
					
					#Clear memory of images
					imagedestroy( $myImage );
					imagedestroy( $thumb );
				
					# Send to Database
					$_POST['adult_image'] = $ran2.$ext;
	
			} else {
				$error = "Invalid file";
			}
		}
		
		if(isset($_REQUEST['age']) && strlen(trim($_REQUEST['age'])) !== 0){
			if(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'days')){
				$set_days = created.getDays() + ($_REQUEST['age']);
				estimated_born_date.setDays(set_days);	
			}
				# Send to Database
				$_POST['estimated_born_date'] = $estimated_born_date;
		}

		if(isset($_REQUEST['born_date']) && strlen(trim($_REQUEST['born_date'])) !== 0){
			$new_date = date('Y-m-d',strtotime($_POST['born_date']));

			# Send to Database
			$_POST['born_date'] = $new_date;
		}

		if(isset($_REQUEST['acquired_date']) && strlen(trim($_REQUEST['acquired_date'])) !== 0){
			$new_date = date('Y-m-d',strtotime($_POST['acquired_date']));

			# Send to Database
			$_POST['acquired_date'] = $new_date;
		}

		# Insert this user into the database and redirect to login page
		$user_id = DB::instance(DB_NAME)->insert('user_animal', $_POST);
		Router::redirect("/users/profile");
	}

	public function animal_edit() {

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
} # end of the class