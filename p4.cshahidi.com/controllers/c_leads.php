<?php

class leads_controller extends base_controller {

	public function __construct() {
		parent::__construct();
					
		# Make sure user is logged in if they want to use anything in this controller
		if (!$this->user) {
			die("Members only. <a href='/users/login/'>Login</a>");
		}
	}
	

	/* Method sets up display for Leads table for tracking by Principals.  Could also be called index() */
	public function track() {

		# Set up view
		$this->template->content = View::instance('v_leads_track');
		$this->template->title   = "Lead Tracker | Portside Capital Holdings LLC"; 		
		
		# View needs Tablesorter Plugin JS and CSS files, add their paths to this array 
		$client_files = Array(
					"/js/tablesorter/themes/blue/style.css",
					"/js/tablesorter/jquery.tablesorter.js",
					"/css/leads_track.css"
					);

		$this->template->client_files = Utils::load_client_files($client_files); 	

		
		# Builds a query to grab all leads from DB
		$q = "SELECT * 
			FROM leads";

		# Run the query, storing the results in $leads array
		$leads = DB::instance(DB_NAME)->select_rows($q);
		
		# Pass data to the View (No Ajax when building original table; just later updating)
		$this->template->content->leads = $leads; 					

		# Set subview to be a view fragment
		# You're not using the master template.
		# This is b/c you don't need the doctype, head, full page, etc...
		# You just need the "stub" of HTML which will get injected into the page
		#$this->template->content->subview  = View::instance("v_leads_track");	
		
		# Pass data to the View
		#$this->template->content->subview->leads = $leads; 
		
		# Render template 
		# In subview...Whatever HTML we render is what JS will receive as a result of it's Ajax call	
		echo $this->template;
			
	} 	
	
	
	/* Lead Generator method */
	public function add( $add_another_lead = NULL) {
	
		# Setup view
		$this->template->content = View::instance('v_leads_add');
		$this->template->title   = "Lead Generator | Portside Capital Holdings LLC"; 		
		
		# Pass data to the view
		$this->template->content->add_another_lead = $add_another_lead;
		
		# Load CSS/JS
		# Add jQuery Form Validation Plugin
		# Add Masked Input Plugin (allows the application of a mask for fixed width inputs such as zip & tel)
	
		$client_files = Array(
					"/css/form_validation.css", # may go before master.css (May Replace)
					"/css/lead_generator.css",
					# jQuery Form Validation Plugin 
					"http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js",
					# Masked Input Plugin (allows application of a mask for fixed width inputs such as zip & tel) 
					"/js/jquery.maskedinput-1.3.min.js"								
					);
							
		$this->template->client_files = Utils::load_client_files($client_files);					
				
		
		# Render template
		echo $this->template;
	}
	

	public function p_add() {
	
		# Associate this lead with this user via partner_id. 

		# Build query to get "partner_id" from partners table based on user_id
		$q = "SELECT partner_id 
			FROM partners
			WHERE user_id = ".$this->user->user_id;			
			
		$_POST['partner_id'] = DB::instance(DB_NAME)->select_field($q);
		// echo "Your partner_id is: ".$_POST['partner_id']; (Dont' echo before redirect
		
		# Unix timestamp of when this post was created/modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		# Set status to default value
		$_POST['status']  = "pending";		

		# Insert
		DB::instance(DB_NAME)->insert('leads', $_POST);
		
		# Quick and dirty feedback
		# echo "Your lead has been added. <a href='/lead/add'>Add another?</a>";
		
		# Pass data Send them back if they wish to add any other leads
		Router::redirect("/leads/add/add_another_lead?"); # pass parameter "add_another_lead?" string
	}
		
	
	/* Method called by AJAX to update status (pending, accepted, rejected) in leads table */
	public function update_status() {
	
		# Create data array we'll use with the update method (in this case one field) 
		$data = Array("status" => $_POST['status']);
	
		DB::instance(DB_NAME)->update('leads', $data, 'WHERE lead_id = '.$_POST['lead_id']);
	}	


	/* Method called by AJAX to delete record from leads table */
	public function delete() {
		DB::instance(DB_NAME)->delete('leads', 'WHERE lead_id = '.$_POST['lead_id']);
	}
		
}


	
		 