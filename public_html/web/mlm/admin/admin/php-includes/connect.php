<?php
	$db_host = "localhost";
	$db_user = "u549105306_lopat";
	$db_pass = "Cjgy~s8Fp+BA+";
	$db_name = "u549105306_mlm";
	
	$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if(mysqli_connect_error()){
		echo 'connect to database failed';
	}
?>