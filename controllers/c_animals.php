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

		# Run query, store the results in a variable
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
			$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
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
					$_POST['baby_image'] = $ran2.$ext;
	
			} else {
				$error = "Invalid file";
			}
		}

		# Check if adult image added
		if(isset($_FILES['adult_image']['name']) && ($_FILES['adult_image']['name'] != "")){
			
			# Setup Image Restrictions
			$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
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
	
	public function preview($animal_ID) {

		# Setup view
		$this->template->content = View::instance('v_animals_preview');
		$this->template->title   = "Farm Friends: Preview Animal";
		

		# Get user information
		$q = "SELECT  
				user_animal.user_animal_ID,
				user_animal.adult_image,
				user_animal.baby_image,
				user_animal.animal_name,
				animals.species,
				animals.default_image,
				user_animal.breed,
				user_animal.born_date,
				user_animal.estimated_born_date,
				user_animal.acquired_date,
				user_animal.notes,
				CASE WHEN user_animal.born_date NOT LIKE '0000-00-00'
					THEN DATEDIFF(NOW(),user_animal.born_date)
				END AS age_days
			FROM user_animal INNER JOIN animals ON user_animal.animal_ID = animals.animal_ID
			WHERE user_animal.user_animal_id = ".$animal_ID;

		# Run query, store the results in a variable
		$animals = DB::instance(DB_NAME)->select_rows($q);
		
		#Pass data to the view
    	$this->template->content->animals  	= $animals;

		# Render template
		echo $this->template;

	}

	public function animal_edit($animal_ID) {

		# Setup view
		$this->template->content = View::instance('v_animals_edit');
		$this->template->title   = "Farm Friends: Edit Animal";
		

		# Get animal record
		$q = "SELECT  
				user_animal.user_animal_ID,
				user_animal.adult_image,
				user_animal.baby_image,
				user_animal.animal_name,
				animals.species,
				animals.default_image,
				user_animal.breed,
				user_animal.born_date,
				user_animal.estimated_born_date,
				user_animal.acquired_date,
				user_animal.notes,
				CASE WHEN user_animal.born_date NOT LIKE '0000-00-00'
					THEN DATEDIFF(NOW(),user_animal.born_date)
				END AS age_days
			FROM user_animal INNER JOIN animals ON user_animal.animal_ID = animals.animal_ID
			WHERE user_animal.user_animal_id = ".$animal_ID;

		# Run posts query, store the results in the variable $posts
		$animals = DB::instance(DB_NAME)->select_rows($q);

		# Get list of animals
			$q = "SELECT 
				animal_ID,
				species 
			FROM animals 
			ORDER BY species ASC";

		# Run query, store the results in a variable
		$animal_list = DB::instance(DB_NAME)->select_rows($q);

		#Pass data to the view
		$this->template->content->animal_list	= $animal_list;
    	$this->template->content->animals  		= $animals;

		# Render template
		echo $this->template;

	}
} # end of the class