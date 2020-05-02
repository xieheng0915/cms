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
    
    $per_page = 10;
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	} else {
		$page =1;
	}

    $start_from = ($page -1) * $per_page;

    $result='';
    if(isset($_GET['new_m_status'])){
        $new_m_status = $_GET['new_m_status'];
        $sql = "UPDATE comments SET status = '$new_m_status' WHERE comment_id = '$_GET[comment_id]'";
        $run_sql = mysqli_query($conn, $sql);
        if ($run_sql){
            //$result = '<div class="alert alert-success">We have just submitted the new status.</div>';
        }else {
            $result = '<div class="alert alert-danger">Status has not been updated correctly.</div>';
        }

    }

    if(isset($_GET['del_m_id'])){
        $del_m_id = $_GET['del_m_id'];
        $del_sql = "DELETE FROM comments WHERE comment_id = '$del_m_id' ";
        if($run_sql = mysqli_query($conn,$del_sql)){
            $result = '<div class="alert alert-warning">You deleted A row no. '.$del_m_id.'</div>';
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

    <div class="col-lg-9">
    <?php echo $_SESSION['user']; ?>
        <div style="height: 50px;"></div>
   
        <!-- Post lists Starts -->
        <div class="panel panel-default panel-primary">
            <div class="panel-heading"><h3>Comments</h3></div>
            <div class="panel-body">
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Email</th>
                            <th>Post</th>
                            <th>Subject</th>
                            <th>Comment</th>
                            <th>Status</th>                         
                            <th>Delete</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                    <?php 
                        $sql = "SELECT * FROM comments";
                        $run_sql = mysqli_query($conn,$sql);
                        while($rows = mysqli_fetch_assoc($run_sql)){
                            
                                echo '
                                <tr>
                                    <td>'.$rows['comment_id'].'</td>
                                    <td>'.$rows['date'].'</td>
                                    <td>'.$rows['name'].'</td>
                                    <td>'.$rows['email'].'</td>
                                    <td>'.$rows['post_id'].'</td>
                                    <td>'.$rows['subject'].'</td>
                                    <td>'.$rows['comment'].'</td>
                                    
                                    <td>'.($rows['status'] == 'Approved'? $rows['status']: '<a href="comment_list.php?comment_id='.$rows['comment_id'].'&new_m_status=Approved" class="btn btn-warning btn-xs">Approve</a>').'</td>

                                    

                                    <td><a href="comment_list.php?del_m_id='.$rows['comment_id'].'" class="btn btn-danger btn-xs">Delete</a></td>
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
						$pagination_sql = "SELECT * FROM comments";
						$run_sql = mysqli_query($conn, $pagination_sql);
						$count = mysqli_num_rows($run_sql);
						$total_pages = ceil($count / $per_page);
						for ($i=1; $i<=$total_pages;$i++){
							echo '<li><a href="comment_list.php?page='.$i.'">'.$i.'</a></li>';
						}
					?>
					
					
			
				</ul>
        </div>
        
    </div>

    

    <footer>
    
    </footer>
</body>
</html>