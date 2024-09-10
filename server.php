<?php
    session_start();
    
    // initializing variables
    $username = "";
    $email    = "";
    $errors = array(); 
    
    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');
    
    // REGISTER USER
    if (isset($_POST['reg_user'])) {

      
      // receive all input values from the form
      $username = mysqli_real_escape_string($db, $_POST['username']);
      $email = mysqli_real_escape_string($db, $_POST['email']);
      $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
      $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    
      // form validation: ensure that the form is correctly filled ...
      // by adding (array_push()) corresponding error unto $errors array
      if (empty($username)) { array_push($errors, "Username is required"); }
      if (empty($email)) { array_push($errors, "Email is required"); }
      if (empty($password_1)) { array_push($errors, "Password is required"); }
      if ($password_1 != $password_2) {
    	array_push($errors, "The two passwords do not match");
      }
    
      // first check the database to make sure 
      // a user does not already exist with the same username and/or email
      $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
      $result = mysqli_query($db, $user_check_query);
      $user = mysqli_fetch_assoc($result);
      
      if ($user) { // if user exists
        if ($user['username'] === $username) {
          array_push($errors, "Username already exists");
        }
    
        if ($user['email'] === $email) {
          array_push($errors, "email already exists");
        }
      }
    
      // Finally, register user if there are no errors in the form
      if (count($errors) == 0) {
      	$password = md5($password_1);//encrypt the password before saving in the database
    
      	$query = "INSERT INTO users (username, email, password) 
      			  VALUES('$username', '$email', '$password')";
      	mysqli_query($db, $query);
      	$_SESSION['username'] = $username;
      	$_SESSION['success'] = "You are now logged in";
      	header('location: index.php');
      }
    }
    // LOGIN USER
   

    if (isset($_POST['login_user'])) {
      $username = mysqli_real_escape_string($db, $_POST['username']);
      $password = mysqli_real_escape_string($db, $_POST['password']);
      
      // Initialize an empty errors array if not already defined
      $errors = isset($errors) ? $errors : array();
  
      // Check for empty username and password
      if (empty($username)) {
          array_push($errors, "Username is required");
      }
      if (empty($password)) {
          array_push($errors, "Password is required");
      }
  
      // If no errors, proceed with login
      if (count($errors) == 0) {
          // Encrypt the password using md5 or use more secure hashing in production like bcrypt or password_hash()
          $password = md5($password);
  
          // Query to check the user credentials and fetch the role
          $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
          $results = mysqli_query($db, $query);
  
          // If a matching user is found
          if (mysqli_num_rows($results) == 1) {
              // Fetch user data, including role
              $logged_in_user = mysqli_fetch_assoc($results);
  
              // Set session variables
              $_SESSION['username'] = $logged_in_user['username'];
              $_SESSION['role'] = $logged_in_user['role']; // Storing the user's role (admin/user)
              $_SESSION['success'] = "You are now logged in";
  
              // Redirect based on role
              if ($logged_in_user['role'] == 'admin') {
                  header('location: admin.php'); // Redirect to admin dashboard
              } else {
                  header('location: index.php'); // Redirect to regular user dashboard
              }
          } else {
              array_push($errors, "Wrong username/password combination");
          }
      }
  }
  

  
    // Registration code...
    if (isset($_POST['register'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $role = "user";  // By default, register as a user

        // Encrypt password before saving in the database
        $password = md5($password);

        $query = "INSERT INTO users (username, email, password, role) 
                  VALUES('$username', '$email', '$password', '$role')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }

  
  ?>