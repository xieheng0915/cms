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
						if(isset($_GET['search_submit'])){
							echo '
							<div class="panel panel-default">
								<div class="panel-body">
									<h4>You Searched for "'.$_GET['search'].'"</h4>
								</div>
							</div>
							';
							$sel_sql = "SELECT * FROM posts WHERE title LIKE '%$_GET[search]%' OR description LIKE '%$_GET[search]%'";
							$run_sql = mysqli_query($conn,$sel_sql);
							while($rows = mysqli_fetch_assoc($run_sql)){
								echo '
								<div class="panel panel-success">
									<div class="panel-heading">
										<h3><a href="post.php?post_id='.$rows['id'].'">'.$rows['title'].'</a></h3>
									</div>
									<div class="panel-body">
										<div class="col-lg-4">
											<img src="'.$rows['image'].'" width="100%">
										</div>
										<div class="col-lg-8">
											<p>'.substr($rows['description'],0,300).'........</p>
										</div>
										<a href="post.php?post_id='.$rows['id'].'" class="btn btn-primary">Read More</a>
									</div>
								</div>
								';
							}
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