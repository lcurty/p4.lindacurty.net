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
		$_POST['user_ID']  = $this->user->user_id;       
				
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
			if(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'years'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' years'));	
			elseif(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'months'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' months'));	
			elseif(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'weeks'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' weeks'));	
			elseif(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'days'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' days'));	
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
		
		# Create record for post
		$q = "SELECT species
			  FROM animals
			  WHERE animal_ID = ".$_POST['animal_id'];
		$this_animal = DB::instance(DB_NAME)->select_field($q);
			  
		$post_animal['created']  = Time::now();
		$post_animal['modified'] = Time::now();
		$post_animal['user_id']  = $this->user->user_id;
		$post_animal['content']  = "I just added a new ".$this_animal." to my farm!";

		# Insert this user into the database and redirect to login page
		$user_id = DB::instance(DB_NAME)->insert('user_animal', $_POST);
		
		# Get Last Inserted ID
		$q = "SELECT user_animal_ID
			  FROM user_animal
			  WHERE user_ID = ".$this->user->user_id."
			  ORDER BY user_animal_ID DESC
			  LIMIT 1";
		$this_animal = DB::instance(DB_NAME)->select_field($q);
		$post_animal['user_animal_ID'] = $this_animal;

		$post_id = DB::instance(DB_NAME)->insert('posts', $post_animal);
		Router::redirect("/users/profile");
	}
	
	public function preview($animal_ID) {

		# Setup view
		$this->template->content = View::instance('v_animals_preview');
		$this->template->title   = "Farm Friends: Preview Animal";

		# Get animal information
		$q = "SELECT  
				user_animal.user_animal_ID,
				user_animal.adult_image,
				user_animal.baby_image,
				user_animal.animal_name,
				animals.animal_ID,
				animals.species,
				animals.default_image,
				user_animal.breed,
				DATE_FORMAT(user_animal.born_date, '%m/%d/%Y') AS born_date,
				DATE_FORMAT(user_animal.estimated_born_date, '%m/%d/%Y') AS estimated_born_date,
				DATE_FORMAT(user_animal.acquired_date, '%m/%d/%Y') AS acquired_date,
				user_animal.notes,
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
		
		# Get list of animals
			$q = "SELECT 
				animal_ID,
				species 
			FROM animals 
			ORDER BY species ASC";

		# Run query, store the results in a variable
		$animal_list = DB::instance(DB_NAME)->select_rows($q);

		# Get animal information
		$q = "SELECT  
				user_animal.user_animal_ID,
				user_animal.adult_image,
				user_animal.baby_image,
				user_animal.animal_name,
				animals.animal_ID,
				animals.species,
				animals.default_image,
				user_animal.breed,
				DATE_FORMAT(user_animal.born_date, '%m/%d/%Y') AS born_date,
				DATE_FORMAT(user_animal.estimated_born_date, '%m/%d/%Y') AS estimated_born_date,
				DATE_FORMAT(user_animal.acquired_date, '%m/%d/%Y') AS acquired_date,
				user_animal.notes,
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
			WHERE user_animal.user_animal_id = ".$animal_ID;

		# Run posts query, store the results in the variable $posts
		$animals = DB::instance(DB_NAME)->select_rows($q);


		#Pass data to the view
		$this->template->content->animal_list	= $animal_list;
    	$this->template->content->animals  		= $animals;

		# Render template
		echo $this->template;

	}
	
	public function p_animal_edit($user_animal_ID) {
		
		# More data we want stored with the user
		$_POST['modified'] = Time::now();       
				
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
			if(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'years'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' years'));	
			elseif(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'months'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' months'));	
			elseif(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'weeks'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' weeks'));	
			elseif(isset($_REQUEST['age_category']) && ($_REQUEST['age_category'] == 'days'))
				$estimated_born_date = date('Y-m-d', strtotime('-'.$_REQUEST['age'].' days'));	
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
		
		# Create record for post
		if(isset($_REQUEST['animal_name']) && strlen(trim($_REQUEST['animal_name'])) !== 0 ) {
			$species = $_POST['animal_name'];
		} else {
			$q = "SELECT species
				  FROM animals
				  WHERE animal_ID = ".$_POST['animal_id'];
			$species = DB::instance(DB_NAME)->select_field($q);
			$species = "a ".$species;
		}
		$post_animal['created']  = Time::now();
		$post_animal['modified'] = Time::now();
		$post_animal['user_id']  = $this->user->user_id;
		$post_animal['content']  = "I just updated information about ".$species."!";

		# Insert this user into the database and redirect to login page
		$user_id = DB::instance(DB_NAME)->update('user_animal', $_POST, 'WHERE user_animal_ID = '.$user_animal_ID);
		
		# Get Last Inserted ID
		$q = "SELECT user_animal_ID
			  FROM user_animal
			  WHERE user_ID = ".$this->user->user_id."
			  ORDER BY modified DESC
			  LIMIT 1";
		$this_animal = DB::instance(DB_NAME)->select_field($q);
		$post_animal['user_animal_ID'] = $this_animal;

		$post_id = DB::instance(DB_NAME)->insert('posts', $post_animal);
		Router::redirect("/animals/preview/".$user_animal_ID);
	}
	
	public function p_animal_delete($user_animal_ID) {
		# Insert this user into the database and redirect to login page
		$delete_animal['is_deleted'] = 1;

		$user_animal_ID = DB::instance(DB_NAME)->update('user_animal', $delete_animal, 'WHERE user_animal_ID = '.$user_animal_ID);
		Router::redirect("/users/profile");

	}
} # end of the class