<?php

class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		// echo "You are accessing the User's controller<br>";
	} 
	

	public function signup() {
		# Setup view
		$this->template->content = View::instance("v_users_signup");
		$this->template->title   = "Signup";
		
		# Render template
		echo $this->template;
	}
	
	public function p_signup(){
		# Dump out the results of POST to see what the form submitted
		print_r($_POST);
		
		# Encrypt the password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		# Make sure User doesn't already exist, based on Password & Email
		# Search the DB for this email and password
		# Retrieve the token if it's available
		$q = "SELECT token
			  FROM users
			  WHERE  email = '".$_POST['email']."'
			  AND password = '".$_POST['password']."'";
			  
		
		$token = DB::instance(DB_NAME)->select_field($q);
		
		# If we get a token, user has already registered
		if ($token) {
			# Send them back to the login page
			Router::redirect("/users/login/");
		}
		
		
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		$_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
		
		
		# Insert this user into the database
		$user_id = DB::instance(DB_NAME)->insert("users", $_POST);
		
		# For now, just confirm they've signed up - we can make this fancier later
		echo "You're signed up";
	}
	
	
	
	public function login($error = NULL){
		# Setup view
		$this->template->content = View::instance("v_users_login");
		$this->template->title   = "Login";
		
		# Pass data to the view
		$this->template->content->error = $error;
		
		# Render template
		echo $this->template;
	}
	
	public function p_login() {
	
		# Sanitize the user entered data to prevent any funny business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		# Hash submitted password so we can compare it against one in the DB
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		# Search the DB for this email and password
		# Retrieve the token if it's available
		$q = "SELECT token
			  FROM users
			  WHERE  email = '".$_POST['email']."'
			  AND password = '".$_POST['password']."'";
			  
		//echo $q . "<br>";
		
		$token = DB::instance(DB_NAME)->select_field($q);
		
		# If we didn't get a token, login failed
		if ($token == "") {
			# Send them back to the login page if (!$token)
			Router::redirect("/users/login/error"); # Note the addition of the parameter "error"			
		}
		
		# But if we did, login succeeded!
		else {
			# Ensure user is not already logged in. If so, take them to Profile page and exit.
			if ($this->user) {
				# Already logged in; Display the profile view and exit.
				Router::redirect("/users/profile/");
				
				return;    
			}
		
			# Store this token in a cookie
			setcookie("token", $token, strtotime('+1 year'), '/');
		
			# If we were passed a $destination (e.g. /users/profile page), send them there
			if(isset($_GET['destination'])) {
				Router::redirect($_GET['destination']);
			}
			else {
				# Otherwise, send them to the main page 
				Router::redirect("/");
			}			
		}
	}	
	
	public function logout() {
	
		# Ensure user is not already logged out. If so, take them to Profile page and exit.
		if (!$this->user) {
			# Already logged out; Display the Home page and exit
			Router::redirect("/");			
			return;    
		}	
		
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
		
		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);
		
		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
		
		# Delete their token cookie - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');
		
		# Logged out; Display the Home page and exit
		Router::redirect("/");	
	}
	
	public function profile() {
		
	# If user is blank, they're not logged in. 
	if (!$this->user) {
		//echo "Members only. <a href='/users/login'>Login</a>";
		
		# Create a view fragment with just the login form 
		$view_fragment = View::instance("v_users_login");
		
		# Tell the login form where we should end up (back here) when we're done loggin in
		$view_fragment->message     = "You don't have access to view this page. Please login.";
		$view_fragment->destination = "/users/profile";
		$view_fragment->title        = "Login";
		
		# Display the login form
		echo $view_fragment;
		
		
		# Return will prevent anything else from happening in this controller
		return;
	}
		
	# Setup view
	$this->template->content = View::instance('v_users_profile');
	$this->template->title   = "Profile of ".$this->user->first_name;
	
	# Load CSS/JS
	/* $client_files = Array(
						"/css/users.css",
						"/js/users.js",
						);
						
	$this->template->client_files = Utils::load_client_files($client_files);					
	*/
	
	#Render template
	echo $this->template;
	}
	
} # end of the class
