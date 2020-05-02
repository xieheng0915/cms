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
    
    if(isset($_GET['del_c_id'])){
        $del_c_id = $_GET['del_c_id'];
        $del_sql = "DELETE FROM category WHERE c_id = '$del_c_id' ";
        if($run_sql = mysqli_query($conn,$del_sql)){
            $result = '<div class="alert alert-warning">You deleted A row no. '.$del_c_id.'</div>';
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

    <div class="col-lg-6">
    <?php echo $_SESSION['user']; ?>
        <div style="height: 50px;"></div>
   
        <!-- Post lists Starts -->
        <div class="panel panel-default panel-primary">
            <div class="panel-heading"><h3>Categories</h3></div>
            <div class="panel-body">
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        
                    </thead>
                    <tbody>

                    <?php 
                        $sql = "SELECT * FROM category";
                        $run_sql = mysqli_query($conn,$sql);
                        while($rows = mysqli_fetch_assoc($run_sql)){
                            if($rows['category_name']== 'home'){}else {
                                echo '
                                <tr>
                                    <td>'.$rows['c_id'].'</td>
                                    <td>'.$rows['category_name'].'</td>
                                    <td><a href="edit_category.php?edit_c_id='.$rows['c_id'].'" class="btn btn-warning btn-xs">Edit</a></td>
                                    <td><a href="category_list.php?del_c_id='.$rows['c_id'].'" class="btn btn-danger btn-xs">Delete</a></td>
                                </tr>
                                ';
                            }
                            
                        }
                    ?> 
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Posts List End -->
        
       
        
    </div>

    

    <footer>
    
    </footer>
</body>
</html>