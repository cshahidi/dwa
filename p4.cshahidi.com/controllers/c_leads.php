<?php

class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();
					
		# Make sure user is logged in if they want to use anything in this controller
		if (!$this->user) {
			die("Members only. <a href='/users/login'>Login</a>");
		}
	}
	
	/* P4 */
	/* Method sets up display for Leads table for tracking by Principals.  Could also be called index() */
	public function table() {

		# Set up view
		$this->template->content = View::instance('v_leads_table');
		$this->template->title   = "Lead Tracker | Portside Capital Holdings LLC"; 
		$this->template->content->h2 = "Lead Tracker (for Internal Use Only)";			

		
		# View needs Tablesorter Plugin JS and CSS files, add their paths to this array 
		$client_files = Array(
					"/js/tablesorter/themes/blue/style.css",
					"/js/tablesorter/jquery.tablesorter.js"
					);

		$this->template->client_files = Utils::load_client_files($client_files); 	

		
		# Builds a query to grab all leads from DB
		$q = "SELECT * 
			FROM leads";

		# Run the query, storing the results in $leads array
		$leads = DB::instance(DB_NAME)->select_rows($q);

		# Set subview to be a view fragment
		# You're not using the master template.
		# This is b/c you don't need the doctype, head, full page, etc...
		# You just need the "stub" of HTML which will get injected into the page
		$this->template->content->subview  = View::instance("v_leads_table");	
		
		# Pass data to the View
		$this->template->content->subview->leads = $leads; 
		
		# Render template 
		# In subview...Whatever HTML we render is what JS will receive as a result of it's Ajax call	
		echo $this->template;
			
	} 	
	
	
	
	/* Method to show only this users posts, so they can edit the posts */ 
	public function myposts() {
		
		# Set up view
		$this->template->content = View::instance('v_posts_index');
		$this->template->title   = "My Posts";
		$this->template->content->h1 = "My Posts";
		
		# Build a query of the posts this user has posted. Must be following themselves.
		# SELECT 1 just looks for one record and returns TRUE; otherwise NULL when no match.
		$q = "SELECT 1 
			FROM users_users
			WHERE user_id        = ".$this->user->user_id."
			AND user_id_followed = ".$this->user->user_id;
			
		# Execute our query, storing the results in a variable $connections
		$my_connection = DB::instance(DB_NAME)->select_rows($q);			
		
		if ($my_connection != NULL) {
			# User is following themselves
	
			# Now, lets build our query to grab the posts
			# Get everything from posts, but only get the user_id, first_name and last_name of users.
			# This way, the "created" field from users table won't override the "created" of posts table.
			$q = "SELECT posts.*, users.user_id, users.first_name, users.last_name 
				FROM posts 
				JOIN users USING (user_id)
				WHERE posts.user_id = ".$this->user->user_id."
				ORDER BY posts.created DESC";	/* Show posts in reverse chronological (DESC) order */
				
			# Run our query, store the results in the variable $posts
			$posts = DB::instance(DB_NAME)->select_rows($q);
			
			# $posts will remain an empty string if User has no connections yet, to themselves or others.
		}
		else {
			# User is not following themselves
			$posts = "";
			
			# Pass data to the View. Indicate user must follow themselves first.
			$this->template->content->must_follow_yourself = TRUE;	
		}
		
		# Pass data to the view
		$this->template->content->posts = $posts;	
		
		# Render view
		echo $this->template;
		
	}		
	
	/* P4 */	
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
		<script type="text/javascript" src=></script>		

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
	
	/* P4 */
	public function p_add() {
	
		# Associate this lead with this user via partner_id. 

		# Build query to get "partner_id" from partners table based on user_id
		$q = "SELECT partner_id 
			FROM partners
			WHERE user_id = ".$this->user->user_id;			
			
		$_POST['partner_id'] = DB::instance(DB_NAME)->select_field($q);
		echo "Your partner_id is: ".$_POST['partner_id'];
		
		# Unix timestamp of when this post was created/modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		
		# Set status to default value
		$_POST['status']  = "pending";		

		# Insert
		DB::instance(DB_NAME)->insert('leads', $_POST);
		
		# Quick and dirty feedback
		# echo "Your post has been added. <a href='/posts/add'>Add another?</a>";
		
		# Pass data Send them back if they wish to add any other posts
		Router::redirect("/posts/add/add_another_post?"); # pass parameter "add_another_post?" string
	}
	
	public function users() {
		# Set up view
		$this->template->content = View::instance('v_posts_users');
		$this->template->title   = "Users";	
		
		# Build our query to get all the users
		$q = "SELECT *
			 FROM users";	

		# Execute this query to get users. Store the result array in thh variable $users
		$users = DB::instance(DB_NAME)->select_rows($q);
		
		# Build our query to figure out what connections does this user already have? 
		#  I.e. who are they following?
		$q = "SELECT *
			FROM users_users
			WHERE user_id = ".$this->user->user_id;
			
		# Execute this query with the select_array method.
		# select_array will return our results in an array and use the "user_id_followed" field as the index
		# This will come in handy when we get to the view
		# Sotre our results (an array) in th variable $connections
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
		
		# Pass data (users and connections) to the view
		$this->template->content->users       = $users;
		$this->template->content->connections = $connections;	

		# Render the view
		echo $this->template;
	}
	
	public function follow($user_id_followed) {
			
		# Prepare our data array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $user_id_followed
			);
		
		# Do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);
		
		# Send them back
		Router::redirect("/posts/users");

	}

	public function unfollow($user_id_followed) {

		# Sanitize the user entered data, sa delete() does not sanitize
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
	
		# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' 
							AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);
		
		# Send them back
		Router::redirect("/posts/users");

	}	
	
	
	/* P4 */
	/* Method called by AJAX to update status (pending, accepted, rejected) in leads table */
	public function update_status() {

		# Create data array we'll use with the update method (in this case one field) 
		$data = Array("status" => $_POST['status']);
	
		DB::instance(DB_NAME)->update('leads', $data, 'WHERE lead_id = '.$_POST['lead_id']);
	}	

	/* P4 */
	/* Method called by AJAX to delete record from leads table */
	public function delete() {
		DB::instance(DB_NAME)->delete('leads', 'WHERE lead_id = '.$_POST['lead_id']);
	}
		
}


	
		 