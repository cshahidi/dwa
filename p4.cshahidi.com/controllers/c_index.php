<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
			$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
			$this->template->title = "Home Page | Portside Capital Holdings LLC"; 
	
		# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						# Add Colorbox Plugin (current version 1.3.19 is being loaded)
						"/js/colorbox/colorbox.css",
						"/js/colorbox/jquery.colorbox.js",
						# Add Master stylesheet
						#"/css/master.css",
						# Add stylesheet specific to Home page -->
						"/css/home_page.css"			
	                    );
	    
	    	$this->template->client_files = Utils::load_client_files($client_files);   
	      		
		# Set subview to be a view fragment to display login form on the landing page (instead of link)
			$this->template->content->subview = View::instance('v_users_login');
		
				
		# Render the view
			echo $this->template;

	} //end index()
	
} // end class
