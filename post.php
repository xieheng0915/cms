<?php include 'includes/db.php';?>
<!DOCTYPE html>
<html>
	<head>
		<title>CMS System</title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
		<script src="../bootstrap/js/bootstrap.js"></script>
		<script src="../js/jquery.js"></script>
	</head>
	<body>
		<header class="navbar navbar-inverse navbar-static-top" >
			<div class="container">
				<a href="index.php" class="navbar-brand">CMS System</a>
				<ul class="nav navbar-nav navbar-right">
					<?php include 'includes/header.php';?>
					<li class=""><a href="contact.php">Contact Us</a></li>
					<li class=""><a href="registration.php">Registration</a></li>
				</ul>
			</div>
		</header>
		<div class="container">
			<article class="row">
				<section class="col-lg-8">
					<?php
					if(isset($_GET['post_id'])){
						$sel_sql = "SELECT * FROM posts WHERE id = '$_GET[post_id]'";
						$run_sql = mysqli_query($conn,$sel_sql);
						while($rows = mysqli_fetch_assoc($run_sql)){
							echo '
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="panel-header">
											<h2>'.$rows['title'].'</h2>
										</div>
										<img src="'.$rows['image'].'" width="100%">
										<p>'.$rows['description'].'</p>
									</div>
								</div>
							';
						}
					} else {
						echo '<div class="alert alert-danger">No Post You&apos;ve selected to Show!<a href="index.php">Click Here</a> to Select a Post</div>';
					}
						
					?>
					
				</section>
				<?php include 'includes/sidebar.php';?>
			</article>
		</div>
		<div style="width:50px;height:50px;"></div>
		<?php include 'includes/footer.php';?>
	</body>
</html>