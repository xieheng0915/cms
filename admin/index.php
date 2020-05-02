<?php session_start();
	include 'includes/db.php';
	if(isset($_SESSION['user']) && isset($_SESSION['password']) == true){
		$sel_sql = "SELECT * FROM users WHERE user_email = '$_SESSION[user]' AND user_password = '$_SESSION[password]'";
		if($run_sql = mysqli_query($conn, $sel_sql)){
	
            if(mysqli_num_rows($run_sql) == 1 ){
                // TODO: while()
                
            } else{
                header('Location:../index.php');
            }
			
		}
	} else {
		header('Location:../index.php');
    }
    
    /// posts number statistics
    $sql= "SELECT * FROM posts WHERE status = 'published'";
    $run_sql = mysqli_query($conn, $sql);
    $total_posts = mysqli_num_rows($run_sql);
    
    /// categories 
    $sql = "SELECT * FROM category";
    $run_sql = mysqli_query($conn, $sql);
    //exclude home category
    $total_cate = mysqli_num_rows($run_sql) - 1;

    /// users
    $sql = "SELECT * FROM users";
    $run_sql = mysqli_query($conn, $sql);
    $total_users = mysqli_num_rows($run_sql);

    /// comments
    $sql = "SELECT * FROM comments";
    $run_sql = mysqli_query($conn, $sql);
    $total_comments = mysqli_num_rows($run_sql);


    
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
    
    <?php include 'includes/header.php';?>
    <div style="width: 50px; height: 50px;"></div>
    <?php 
        // echo $_SESSION['user']; 
        include 'includes/sidebar.php';
    ?>

    <!-- Top Blocks Starts -->
    <div class="col-lg-8">
    <?php echo $_SESSION['user']; ?>
        <div style="width: 50px;height: 50px;"></div>
        <div class="col-md-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="glyphicon glyphicon-signal" style="font-size: 4.5em"></i></div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size: 2.5em"><?php echo $total_posts; ?></div>
                            <div>posts</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                <div class="panel-footer">
                    <div class="pull-left">View Posts</div>
                    <div class="pull-right"><a href="post_list.php" class="glyphicon glyphicon-circle-arrow-right"></a></div>
                    <div class="clearfix"></div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="glyphicon glyphicon-th-list" style="font-size: 4.5em"></i></div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size: 2.5em"><?php echo $total_cate; ?></div>
                            <div>Categories</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                <div class="panel-footer">
                    <div class="pull-left">View Categories</div>
                    <div class="pull-right"><a href="category_list.php" class="glyphicon glyphicon-circle-arrow-right"></a></div>
                    <div class="clearfix"></div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="glyphicon glyphicon-user" style="font-size: 4.5em"></i></div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size: 2.5em"><?php echo $total_users; ?></div>
                            <div>Users</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                <div class="panel-footer">
                    <div class="pull-left">View Users</div>
                    <div class="pull-right"><a href="#" class="glyphicon glyphicon-circle-arrow-right"></a></div>
                    <div class="clearfix"></div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3"><i class="glyphicon glyphicon-comment" style="font-size: 4.5em"></i></div>
                        <div class="col-xs-9 text-right">
                            <div style="font-size: 2.5em"><?php echo $total_comments; ?></div>
                            <div>Comments</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                <div class="panel-footer">
                    <div class="pull-left">View Comments</div>
                    <div class="pull-right"><a href="comment_list.php" class="glyphicon glyphicon-circle-arrow-right"></a></div>
                    <div class="clearfix"></div>
                </div>
                </a>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Top Blocks Ends -->

        <!-- User List Area Start -->
        <div class="col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>User List</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * FROM users";
                                $run = mysqli_query($conn, $sql);
                                while ($rows = mysqli_fetch_assoc($run)){
                                    echo '
                                    <tr>
                                        <td>'.$rows['user_id'].'</td>
                                        <td>'.$rows['user_f_name'].' '.$rows['user_l_name'].'</td>
                                        <td>'.$rows['role'].'</td>
                                    </tr>
                                    ';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        


        <!-- Profile Area -->

        <div class="col-lg-4">
            <div class="panel panel-primary">
			    <div class="panel-heading">
			    <div class="col-md-7">
                <br>
				<div><h4>Helen Miller</h4></div>
				</div>
				<div>
					<img src="../image/xiaomei.jpg" width="30%" class="img-circle">
				</div>
            
                    <div class="panel-body">
                        <table class="table table-condensed"> 
                            <?php 
                                $a_sql = "SELECT * FROM users WHERE role = 'admin'";
                                $r_sql = mysqli_query($conn, $a_sql);
                                if (mysqli_num_rows($r_sql) == 1) {
                                    $a_rows = mysqli_fetch_assoc($r_sql);
                                    $a_job = ucfirst($a_rows['user_designation']);
                                    $a_role = ucfirst($a_rows['role']);
                                    $a_email = $a_rows['user_email'];
                                    $a_contact = $a_rows['user_phone_no'];
                                    $a_addr = $a_rows['user_address'];
                                }
                            ?>
                            <thead>
                                <tr>
                                    <th>Job:</th>
                                    <td><?php echo $a_job; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Role:</th>
                                    <td><?php echo $a_role; ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?php echo $a_email; ?></td>
                                </tr>
                                <tr>
                                    <th>Contact:</th>
                                    <td><?php echo $a_contact; ?></td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td><?php echo $a_addr; ?></td>
                                </tr>
                            </tbody>
                            
                        </table>
                </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <!-- Post lists Starts -->
        <div class="panel panel-default panel-primary">
            <div class="panel-heading">Latest Posts</div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Author</th>
                        </tr>
                        
                    </thead>
                    <tbody>

                        <?php 
                            $sql = "SELECT * FROM posts p INNER JOIN category c ON (p.category = c.c_id) INNER JOIN users u ON (p.author = u.user_email) WHERE p.status = 'published' ORDER BY p.id DESC LIMIT 0,5";
                            $run_sql = mysqli_query($conn, $sql);
                            while($rows = mysqli_fetch_assoc($run_sql)){
                                echo '
                                <tr>
                                    <td>'.$rows['id'].'</td>
                                    <td>'.$rows['date'].'</td>
                                    <td><img src="../'.$rows['image'].'" width="50px"></td>
                                    <td>'.$rows['title'].'</td>
                                    <td>'.$rows['description'].'</td>
                                    <td>'.$rows['category_name'].'</td>
                                    <td>'.ucfirst($rows['user_f_name']).'</td>
                                </tr>
                                ';
                            }
                        ?>
                        
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Posts List End -->

        <!-- Comments List Start -->

        <div class="panel panel-default panel-primary">
            <div class="panel-heading">Latest Comments</div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Email</th>
                            <th>Post</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = "SELECT * FROM comments c INNER JOIN posts p ON (c.post_id = p.id) WHERE c.status = 'Approved' ORDER BY comment_id DESC";
                            //$sql = "SELECT * FROM comments";
                            $run = mysqli_query($conn, $sql);
                            while ($rows = mysqli_fetch_assoc($run)){
                                echo '
                                    <tr>
                                        <td>'.$rows['comment_id'].'</td>
                                        <td>'.$rows['date'].'</td>
                                        <td>'.$rows['name'].'</td>
                                        <td>'.$rows['email'].'</td>
                                        <td>'.$rows['title'].'</td>
                                        <td>'.$rows['subject'].'</td>
                                    </tr>
                                ';
                            }
                            
                        ?>
                        
                                 
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Comments List End -->

    </div>

    <footer>
    
    </footer>
</body>
</html>