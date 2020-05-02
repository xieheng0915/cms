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
    
    $result = '';
    if(isset($_POST['change_category']) && isset($_POST['edit_c_id'])){
        $category = strip_tags($_POST['category']);
        $sql = "UPDATE category SET category_name = '$category' WHERE c_id = '$_POST[edit_c_id]'";
        if(mysqli_query($conn, $sql)){
            //$result = '<div class="alert alert-success">You updated a category: '.$category.'.</div>';
            header('Location: category_list.php');
        } else {
            $result = '<div class="alert alert-danger">SQL Query doesn&apos;t  worked properly.</div>';
        }
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
        <?php include 'includes/header.php';?>
        <div style="width: 50px; height: 50px;"></div>
        <?php include 'includes/sidebar.php';?>

        <div class="col-lg-8">
        <?php 
            echo $_SESSION['user']; 
            echo $result;
        ?>

        <div class="page-header"><h1>Edit Category</h1></div>

        <div class="container-fluid">
        <form class="form-horizontal col-lg-6" action="edit_category.php" method="post">
  
        <div class="form-group">
            

        <?php 
            if(isset($_GET['edit_c_id'])){
                $sql = "SELECT * FROM category WHERE c_id = '$_GET[edit_c_id]'";
                $run_sql = mysqli_query($conn, $sql);
                while($rows = mysqli_fetch_assoc($run_sql)){
        ?>

                <input type="hidden" name="edit_c_id" value="<?php echo $_GET['edit_c_id'];?>"> 
                <label for="category">Category Name</label>
                <input id="category" type="text" name="category" value="<?php echo $rows['category_name']; ?>" class="form-control">
                <div class="form-group">
                    <label></label>
                    <input type="submit" value="Change Category" name="change_category" class="btn btn-danger btn-block">
                </div>

        </form>
            
        </div>
       </div>
        <?php
            }
        }
        ?>

        </div>
                   
                   



        <footer></footer>
        
    </body>


</html>