<?php

class index_controller extends base_controller {
	
	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
	} 
		
	/*-------------------------------------------------------------------------------------------------
	Accessed via http://localhost/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
		#	$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
		#	$this->template->title = "";
			
			# Make sure user is logged in
			if($this->user) {
				
				# If yes, send to post_index view.
				Router::redirect("/users/profile");
			}
			
			else {
			
				# Otherwise, send them to the login page
				Router::redirect("/users/login");
			
			}

		# Render the view
			echo $this->template;
			
		# Get the current timestamp
    	Time::now();

	} # End of method
	
} # End of class
