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
    
    $per_page = 5;
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	} else {
		$page =1;
	}

    $start_from = ($page -1) * $per_page;
    
    $result='';
    if(isset($_GET['new_status'])){
        $new_status = $_GET['new_status'];
        $sql = "UPDATE posts SET status = '$new_status' WHERE id = '$_GET[id]'";
        $run_sql = mysqli_query($conn, $sql);
        if ($run_sql){
            //$result = '<div class="alert alert-success">We have just submitted the new status.</div>';
        }else {
            $result = '<div class="alert alert-danger">Status has not been updated correctly.</div>';
        }

    }

    if(isset($_GET['del_id'])){
        $del_id = $_GET['del_id'];
        $del_sql = "DELETE FROM posts WHERE id = '$del_id' ";
        if($run_sql = mysqli_query($conn,$del_sql)){
            $result = '<div class="alert alert-warning">You deleted A row no. '.$del_id.'</div>';
        }
    }
?>

<?php include 'includes/db.php'; ?>
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
    <?php include 'includes/sidebar.php';?>
    <?php 
            echo $_SESSION['user']; 
            echo $result;      
    ?>
    <div class="col-lg-9">
        <div style="height: 50px;"></div>
        
   
        <!-- Post lists Starts -->
        <div class="panel panel-default panel-primary">
            <div class="panel-heading"><h3>Posts</h3></div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Edit</th>
                            <th>View</th>
                            <th>Delete</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <?php 
                            //$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $start_from,$per_page"; 
                            $sql = "SELECT * FROM posts p INNER JOIN users u ON (p.author = u.user_email) JOIN category c ON (p.category = c.c_id) ORDER BY id DESC LIMIT $start_from,$per_page"; 

                            $run_sql = mysqli_query($conn, $sql);
                            while ($rows = mysqli_fetch_assoc($run_sql)){
                                echo '
                                <tr>
                                    <td>'.$rows['id'].'</td>
                                    <td>'.$rows['date'].'</td>
                                    <td><img src="../'.$rows['image'].'" width="50px"></td>
                                    <td>'.$rows['title'].'</td>
                                    <td>'.$rows['description'].'</td>
                                    <td>'.$rows['category_name'].'</td>
                                    <td>'.$rows['user_f_name'].'</td>
                                    <td>'.$rows['status'].'</td>
                                    <td>'.($rows['status'] == 'draft'? '<a href="post_list.php?page='.$page.'&new_status=published&id='.$rows['id'].'" class="btn btn-primary btn-xs">Publish</a>': '<a href="post_list.php?page='.$page.'&new_status=draft&id='.$rows['id'].'" class="btn btn-info btn-xs">Draft</a>').'</td>
                                    <td><a href="edit_post.php?edit_id='.$rows['id'].'" class="btn btn-warning btn-xs">Edit</a></td>
                                    <td><a href="../post.php?post_id='.$rows['id'].'" class="btn btn-success btn-xs">View</a></td>
                                    <td><a href="post_list.php?del_id='.$rows['id'].'" class="btn btn-danger btn-xs">Delete</a></td>
                                </tr>
                                ';
                            }
                        ?>
                        

                        
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Posts List End -->
        
        <div class="text-center">
        <ul class="pagination">
					<?php 
						$pagination_sql = "SELECT * FROM posts";
						$run_sql = mysqli_query($conn, $pagination_sql);
						$count = mysqli_num_rows($run_sql);
						$total_pages = ceil($count / $per_page);
						for ($i=1; $i<=$total_pages;$i++){
							echo '<li><a href="post_list.php?page='.$i.'">'.$i.'</a></li>';
						}
					?>
					
					
			
				</ul>
        </div>
        
    </div>

    

    <footer>
    
    </footer>
</body>
</html>