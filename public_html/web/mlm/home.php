<?php
require('php-includes/connect.php');
include('php-includes/check-login.php');
$email = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Кабинет миллионера</title>
    <link rel="shortcut icon" href="/web/mlm/static/favicon.png" type="image/png">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
     <link rel="stylesheet" href="/web/mlm/static/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/web/mlm/static/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/web/mlm/static/bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/web/mlm/static/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/web/mlm/static/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/web/mlm/static/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="/web/mlm/static/style.css">
   <link rel="stylesheet" href="/web/mlm/static/assets/css/styles.css" />
        <link rel="stylesheet" href="/web/mlm/static/assets/countdown/jquery.countdown.css" />
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
  <body>
        <?php
        
        // $active:
        // 1 - Активированный аккаунт
        // 0 - Не активированный аккаунт
        
        $active = 0;
        $i=1;
		$query = mysqli_query($con,"select account from users where email='$email' order by id desc");
							if(mysqli_num_rows($query)>0){
								while($row=mysqli_fetch_array($query)){
									$active = $row['account'];
//									$id     = $row['id'];
//									$ddate  = $row['date'];
									$i++;
								}
							}        
        ?>
    </body>
    
  

        <!-- Navigation -->
        <?php //include('php-includes/menu.php'); ?>

        <!-- Page Content -->
        
                        <?php
                        if (($active != 1) and ($active != 2) and ($active != 3)){
                            include('user_status_pages/begin_user.php');
                        } else {
                            include('user_status_pages/active_user.php');
                        }
                        ?>
                        
