<?php

class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();
					
		# Make sure user is logged in if they want to use anything in this controller
		if (!$this->user) {
			die("Members only. <a href='/users/login'>Login</a>");
		}
	}
	
	
	public function index() {
		
		# Set up view
		$this->template->content = View::instance('v_posts_index');
		$this->template->title   = "All Posts";
		$this->template->content->h1 = "All Posts";
		
		# Build a query of the users this user is following - we're only interested in their posts
		$q = "SELECT * 
			FROM users_users
			WHERE user_id = ".$this->user->user_id;
		
		# Execute our query, storing the results in a variable $connections
		$connections = DB::instance(DB_NAME)->select_rows($q);
		
		# In order to query for the posts we need, we're going to need a string of user id's, separated by commas
		# To create this, loop through our connections array
		$connections_string = "";
		foreach($connections as $connection) {
			$connections_string .= $connection['user_id_followed'].",";
		}
		
		if ($connections_string != "") {
			# At least one connection found
		
			# Remove the final comma 
			$connections_string = substr($connections_string, 0, -1);
			
			# Connections string example: 10,7,8 (where the numbers are the user_ids of who this user is following)

			# Now, lets build our query to grab the posts
			# Get everything from posts, but only get the user_id, first_name and last_name of users.
			# This way, the "created" field from users won't override the "created" of posts.
			$q = "SELECT posts.*, users.user_id, users.first_name, users.last_name 
				FROM posts 
				JOIN users USING (user_id)
				WHERE posts.user_id IN (".$connections_string.") /* This is where we use that string of user_ids we created */
				ORDER BY posts.created DESC";	/* Show posts in reverse chronological (DESC) order */
				
			# Run our query, store the results in the variable $posts
			$posts = DB::instance(DB_NAME)->select_rows($q);
			
			# $posts will remain an empty string if User has no connections yet
		}
		else {
			$posts = "";
		}
		
		# Pass data to the view
		$this->template->content->posts = $posts;
		
		# Render view
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
							"http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"		
							"js/jquery.maskedinput-1.3.min.js"							
							);
							
		$this->template->client_files = Utils::load_client_files($client_files);					
				
		
		# Render template
		echo $this->template;
	}
	
	public function p_add() {
	
		# Associate this lead with this user via partner_id. 
		# Join the "users" and "partners" tables to get partner_id
		
		$_POST['user_id'] = $this->user->user_id;
		
		# Build query
		$q = "SELECT 1
			FROM partners
			JOIN users USING (user_id)";

		# SELECT 1 just looks for one record and returns TRUE; otherwise NULL when no match.
		$q = "SELECT 1 
			FROM users_users
			WHERE user_id        = ".$this->user->user_id."
			AND user_id_followed = ".$this->user->user_id;		
		
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

		# Case where user is viewing their own posts via myposts() and just started Following themselves
		# NEED TO FIGURE THIS OUT
		/*if () {
			Router::redirect("/posts/myposts");
		}
		*/
		
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

		
}


	
		 