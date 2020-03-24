<?php
include('php-includes/check-login.php');
include('php-includes/connect.php');
$product_amount = 300;
?>
<?php
//Clicked on send buton
if(isset($_POST['send'])){
	$userid = mysqli_real_escape_string($con,$_POST['userid']);
	$name = mysqli_real_escape_string($con,$_POST['name']);
	$id = mysqli_real_escape_string($con,$_POST['id']);
	
	$no_of_pin = $amount/$product_amount;
	//Insert pin
	$i=1;
	while($i<=$no_of_pin){
		$new_pin = pin_generate();
		mysqli_query($con,"insert into pin_list (`userid`,`pin`) values('$userid','$new_pin')");
		$i++;	
	}
	
	//updae pin request status
	mysqli_query($con,"update users set account='1' where id='$id' limit 1");
	
	echo '<script>alert("Пользаватель активирован.");window.location.assign("view-pin-request.php");</script>';	
}

//Pin generate
function pin_generate(){
	global $con;
	$generated_pin = rand(100000,999999);
	
	$query = mysqli_query($con,"select * from pin_list where pin = '$generated_pin'");
	if(mysqli_num_rows($query)>0){
		pin_generate();
	}
	else{
		return $generated_pin;
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mlml Website  - View Pin Request</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

 

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('php-includes/menu.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Admin - Неактивированные аккаунты</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                	<div class="col-lg-12">
                    	<div class="table-responsive">
                        	<table class="table table-striped table-bordered">
                            	<tr>
                                	<th>S.n.</th>
                                    <th>Почта</th>
                                    <th>Кошелёк</th>
                                    <th>Дата регистрации</th>
                                    <th>Активация</th>
                                    <th>Cancel</th>
                                </tr>
                                <?php
									$query = mysqli_query($con,"select * from users where account='0'");
									if(mysqli_num_rows($query)>0){
										$i=1;
										while($row=mysqli_fetch_array($query)){
											$id = $row['id'];
											$email = $row['email'];
											$name = $row['name'];
											$date = $row['date'];
										?>
                                        	<tr>
                                            	<td><?php echo $i; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $name; ?></td>
                                                <td><?php echo $date;
                                                // $string = '1234'; 
                                                // $string = substr(chunk_split($date, 4, ''), 0, -3);
                                                // echo $string;
                                                ?></td>
                                                <form method="post">
                                                	<input type="hidden" name="userid" value="<?php echo $email ?>">
                                                    <input type="hidden" name="amount" value="//<?php echo $amount ?>">
                                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                                	<td><input type="submit" name="send" value="Активировать" class="btn btn-primary"></td>
                                                </form>
                                                <td>Оставить</td>
                                            </tr>
                                        <?php
											$i++;
										}
									}
									else{
									?>
                                    	<tr>
                                        	<td colspan="6" align="center">You have no pin request.</td>
                                        </tr>
                                    <?php
									}
								?>
                            </table>
                        </div><!--/.table-responsive-->
                    </div>
                </div><!--/.row-->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
