<?php session_start();
	include 'includes/db.php';
	if(isset($_SESSION['user']) && isset($_SESSION['password']) == true){
		$sel_sql = "SELECT * FROM users WHERE user_email = '$_SESSION[user]' AND user_password = '$_SESSION[password]'";
		if($run_sql = mysqli_query($conn, $sel_sql)){		
			if(mysqli_num_rows($run_sql) == 1 ){
				while($rows = mysqli_fetch_assoc($run_sql)){
					if($rows['role'] == 'admin'){
						$user_f_name = $rows['user_f_name'];
						$user_l_name = $rows['user_l_name'];
						$user_email = $rows['user_email'];
						$user_designation = $rows['user_designation'];
						$user_address = $rows['user_address'];
						$user_phone_no = $rows['user_phone_no'];
						$user_website = $rows['user_website'];
					} else {
						header('Location:../index.php');
					}
				}	
			} else{
				header('Location:../index.php');
			}	
		}
	} else {
		header('Location:../index.php');
	}
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <!-- <script src="../../js/jquery.js"></script> -->
    <!-- Collapsible menu only workable in jquery 1.11.3 version -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js" integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g=" crossorigin="anonymous"></script>
	<script src="../../bootstrap/js/bootstrap.js"></script>
    
</head>
<body>
    
	<header class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<a href="index.php" class="navbar-brand">Admin Panel of CMS</a>
			
			<ul class="nav navbar-nav navbar-right">
				<li><?php echo $_SESSION['user']; ?></li>
				<li><a href="index.php">Home</a></li>
				<li><a href="../accounts/logout.php">Log Out</a></li>
			</ul>
		
		</div>
	</header>

    <div style="width: 50px; height: 50px;"></div>
    <?php include 'includes/sidebar.php';?>
    <div class="col-lg-9">
    <div style="width:20px;height:30px;"></div>
			<!----- Profile Area ------>
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="col-md-3">
							<img src="../image/xiaomei.jpg" width="100%" class="img-thumbnail">
						</div>
						<div class="col-md-7">
							<h3><u><?php echo $user_f_name.' '.$user_l_name;?></u></h3>
							<p><i class="glyphicon glyphicon-heart"></i><?php echo ' '.$user_designation;?></p>
							<p><i class="glyphicon glyphicon-road"></i> <?php echo ' '.$user_address;?></p>
							<p><i class="glyphicon glyphicon-phone"></i><?php echo ' '.$user_phone_no;?></p>
							<p><i class="glyphicon glyphicon-envelope"></i><?php echo ' '.$user_email;?></p>
							<p><i class="glyphicon glyphicon-globe"></i> <?php echo ' '.$user_website;?></p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
    </div>
    <footer>
    
    </footer>
</body>
</html>