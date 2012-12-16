<?php

class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		// echo "You are accessing the User's controller<br>";
	} 
	

	public function signup($role) {
		# Setup view
		$this->template->content = View::instance("v_users_signup");
		$this->template->title   = "Signup";	
		
		# Load CSS/JS (for new jQuery validation plugin)
		$client_files = Array(
						"/css/new_form_validation/validationEngine.jquery.css",
						"/css/new_form_validation/template.css",
						"/js/new_form_validation/languages/jquery.validationEngine-en.js",
						"/js/new_form_validation/jquery.validationEngine.js"
						);	

		$this->template->client_files = Utils::load_client_files($client_files);							
		
		
		# Pass data to the view (role is either "partner" or "principal". Add "admin" later)
		$this->template->content->role = $role;	
		
		# Render template
		echo $this->template;
	}
	
	public function p_signup(){	
	
		# Dump out the results of POST to see what the form submitted
		//print_r($_POST);
		# Use framework's Debug library method dump, which uses pretty-printing class called Krumo
		echo Debug::dump($_POST,"Contents of POST");

		# Sanitize the user entered data to prevent any funny business(re: SQL Injection Attacks)
		# This is done prior to calling select_field() method.
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

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
			# Send them back to the Home page
			Router::redirect("/");
		}
		
		
		# More data we want stored with the user
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();
		$_POST['token']    = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
				
		# Insert this user into the database ("users" table)
		$user_id = DB::instance(DB_NAME)->insert("users", $_POST);
		
		
		# Insert this user also into either the "partners" or "principals" table)
		echo "Your role is: ".$_POST['role'];

		# Prepare our data array to be inserted
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("user_id"  => $user_id);
			
		# Do the update		
		if ($_POST['role'] == 'partner') {
			DB::instance(DB_NAME)->insert("partners", $data);	
		}
		elseif ($_POST['role'] == 'principal') {
			DB::instance(DB_NAME)->insert("principals", $data);		
		}	
		
		# Store this token in a cookie. This logs in user so user need not log in as well.
		# Cookie tells us if this user has been authorized and is logged in. 
		setcookie("token", $token, strtotime('+1 year'), '/');		
		
		# Send them back to the Home page
		Router::redirect("/");
		
	}
	
	
	/* ------  Login ---------*/
	public function login($role, $error = NULL){
		# Setup view
		$this->template->content = View::instance("v_users_login");
		$this->template->title   = "Login";
		
		# Load CSS/JS (for new jQuery validation plugin)
		$client_files = Array(
						"/css/new_form_validation/validationEngine.jquery.css",
						"/css/new_form_validation/template.css",
						"/js/new_form_validation/languages/jquery.validationEngine-en.js",
						"/js/new_form_validation/jquery.validationEngine.js"
						);
		
		$this->template->client_files = Utils::load_client_files($client_files);			
		
		# Pass data to the view
		$this->template->content->role = $role;		
		$this->template->content->error = $error;
		
		# Render template
		echo $this->template;
	}
	
	public function p_login() {
	
		# Sanitize the user entered data to prevent any funny business(re: SQL Injection Attacks)
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
			# Ensure user is not already logged in. 
			if ($this->user) {
				# Already logged in; If so, take them to appropriate page and exit. 
				Router::redirect("/users/profile/");
				
				if($this->user->role = "partner") {
					Router::redirect("leads/add/");					
				}
				else {
					# Role is principal
					Router::redirect("/leads/track/");						
				}
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
	
	
	/* P4 */
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
		echo "Members only. <a href='/users/login'>Login</a>";
		
		# Create a view fragment with just the login form 
		$view_fragment = View::instance("v_users_login");
		
		# Tell the login form where we should end up (back here) when we're done loggin in
		$view_fragment->message     = "You don't have access to view this page. Please login.";
		$view_fragment->destination = "/users/profile";
		$view_fragment->title        = "Login";  # Doesn't work, because only template can access title
		
		# Display the login form
		echo $view_fragment;
		
		# Return will prevent anything else from happening in this controller
		return;		
		
		
		# Create view template with the login form; this option didn't retain message and 
		//$this->template->content          = View::instance("v_users_login");
		//$this->template->content->message = "You don't have access to view this page. Please login.";
		//$this->template->content->destination   = "/users/profile";
		//$this->template->title            = "Login";
		
		# Send them back to the login page
		//Router::redirect("/users/login/");		
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
