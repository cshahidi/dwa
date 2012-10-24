<?php

class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		// echo "You are accessing the User's controller<br>";
	} 
	
	/*
	public function index() {
		echo "Welcome to the user's department";
	}
	*/

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
		
		# <<<Make sure User doesn't already exist. Email>>>
		
		# Encrypt the password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		$_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
		
		
		# Insert this user into the database
		$user_id = DB::instance(DB_NAME)->insert("users", $_POST);
		
		# For now, just confirm they've signed up - we can make this fancier later
		echo "You're signed up";
	}
	
	
	
	public function login(){
		# Setup view
		$this->template->content = View::instance("v_users_login");
		$this->template->title   = "Login";
		
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
		if (!$token) {
			# Send them back to the login page
			Router::redirect("/users/login/");
		}
		# But if we did, login succeeded!
		else {
			# <<<Ensure user is not already logged in. If so, take them to Profile page and exit.>>>
			if ($this->user) {
				echo "You are already logged in.";
				Router::redirect("/users/profile/");
				
				# Display the profile view and exit.
				return;    
			}
		
			# Store this token in a cookie
			setcookie("token", $token, strtotime('+1 year'), '/');
			
			# Send them to the main page - or wherever you want them to go
			Router::redirect("/");
			
			# <<<Develop main page (logged in page) >>>
		}
	}	
	
	public function logout() {
		
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
		
		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);
		
		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");
		
		# Delete their token cookie - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');
		
		echo "You have been logged out.";
	}
	
	public function profile() {
		
	# If user is blank, they're not logged in. Show message and don't do anything else
	if (!$this->user) {
		echo "Members only. <a href='/users/login'>Login</a>";
		
		# Return will force this method to exit here so the rest of the code won't be
		# exectuted and the profile view won't be displayed.
		return FALSE;     # or just return
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
