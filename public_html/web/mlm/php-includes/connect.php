<?php
	$db_host = "localhost";
	$db_user = "admin";
	$db_pass = "password";
	$db_name = "u549105306_mlm";
	
	$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if(mysqli_connect_error()){
		echo 'connect to database failed';
	}
?>