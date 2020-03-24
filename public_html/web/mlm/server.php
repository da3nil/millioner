<?php
session_start();

// initializing variables

$email    = "";
$errors = array(); 

// connect to the database
	$db_host = "localhost";
	$db_user = "u549105306_lopat";
	$db_pass = "Cjgy~s8Fp+BA+";
	$db_name = "u549105306_mlm";
	
	$db =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if(mysqli_connect_error()){
		echo 'connect to database failed';
	}
// $db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
//   $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
//   if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE  email='$email' LIMIT 1";
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
      $password = $password_1;
//   	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users ( email, password) 
  			  VALUES( '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

else {
    echo "<script>alert('error');</script>";
}
?>