<?php

class futurepage_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
			$this->template->content = View::instance('v_futurepage_index');
			
		# Now set the <title> tag
			$this->template->title = "Future Page | Portside Capital Holdings LLC"; 		
				
		# Render the view
			echo $this->template;

	} //end index()
	
} // end class
