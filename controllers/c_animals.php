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
			$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "GIF", "JPEG", "PNG");
			$temp = explode(".", $_FILES["baby_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['baby_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['baby_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/animals/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if ((($_FILES["baby_image"]["type"] == "image/gif")
				|| ($_FILES["baby_image"]["type"] == "image/jpeg")
				|| ($_FILES["baby_image"]["type"] == "image/jpg")
				|| ($_FILES["baby_image"]["type"] == "image/pjpeg")
				|| ($_FILES["baby_image"]["type"] == "image/x-png")
				|| ($_FILES["baby_image"]["type"] == "image/png"))
				&& in_array($ext, $allowedExts)) {
					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['baby_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/animals/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['baby_image']['tmp_name']);
					header($_FILES["baby_image"]["type"]);
					if (($ext == "gif") || ($ext == "GIF")) {
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpeg") || ($ext == "jpg") || ($ext == "JPEG") || ($ext == "JPG")){
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif (($ext == "png") || ($ext == "PNG")) {
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
					header($_FILES["baby_image"]["type"]);
					if (($ext == "gif") || ($ext == "GIF")) {
						imagegif($thumb, $target);
					} elseif (($ext == "jpeg") || ($ext == "jpg") || ($ext == "JPEG") || ($ext == "JPG")){
						imagejpeg($thumb, $target);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						imagepng($thumb, $target);
					}
				
					# Send to Database
					$_POST['baby_image'] = $ran2.$ext;
	
			} else {
				echo "Invalid file";
			}
		}

		# Check if adult image added
		if(isset($_FILES['adult_image']['name']) && ($_FILES['adult_image']['name'] != "")){
			
			# Setup Image Restrictions
			$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "GIF", "JPEG", "PNG");
			$temp = explode(".", $_FILES["adult_image"]["name"]);
			$extension = end($temp);
			
			# Rename File
			$ext = pathinfo(($_FILES['adult_image']['name']), PATHINFO_EXTENSION); 
			$ran = rand ();
			$ran2 = pathinfo(($_FILES['adult_image']['name']), PATHINFO_FILENAME) . $ran.".";
			$target = "images/animals/";
			$target = $target . $ran2.$ext;
			
			# Check Image Restrictions
			if ((($_FILES["adult_image"]["type"] == "image/gif")
				|| ($_FILES["adult_image"]["type"] == "image/jpeg")
				|| ($_FILES["adult_image"]["type"] == "image/jpg")
				|| ($_FILES["adult_image"]["type"] == "image/pjpeg")
				|| ($_FILES["adult_image"]["type"] == "image/x-png")
				|| ($_FILES["adult_image"]["type"] == "image/png"))
				&& in_array($ext, $allowedExts)) {
					if (file_exists($target)) {
						
						# Regenerate Random Number for New Filename
						$ran = rand ();
						$ran2 = pathinfo(($_FILES['adult_image']['name']), PATHINFO_FILENAME) . $ran.".";
						$target = "images/animals/";
						$target = $target . $ran2.$ext;
					}
					
					# Resize and crop image
					$crop_image = ($_FILES['adult_image']['tmp_name']);
					header($_FILES["adult_image"]["type"]);
					if (($ext == "gif") || ($ext == "GIF")) {
						$myImage = imagecreatefromgif($crop_image);
					} elseif (($ext == "jpeg") || ($ext == "jpg") || ($ext == "JPEG") || ($ext == "JPG")){
						$myImage = imagecreatefromjpeg($crop_image);
					} elseif (($ext == "png") || ($ext == "PNG")) {
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
					header($_FILES["adult_image"]["type"]);
					if (($ext == "gif") || ($ext == "GIF")) {
						imagegif($thumb, $target);
					} elseif (($ext == "jpeg") || ($ext == "jpg") || ($ext == "JPEG") || ($ext == "JPG")){
						imagejpeg($thumb, $target);
					} elseif (($ext == "png") || ($ext == "PNG")) {
						imagepng($thumb, $target);
					}
				
					# Send to Database
					$_POST['adult_image'] = $ran2.$ext;
	
			} else {
				echo "Invalid file";
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

		# Insert this user into the database and redirect to login page
		$user_id = DB::instance(DB_NAME)->insert('user_animal', $_POST);
		Router::redirect("/users/profile");
	}

} # end of the class