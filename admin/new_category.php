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
    if(isset($_POST['submit_category'])){
        $category = strip_tags($_POST['category']);
        $sql = "INSERT INTO category (category_name) VALUES ('$category')";
        if(mysqli_query($conn, $sql)){
            //$result = '<div class="alert alert-success">You added a new category: '.$category.'.</div>';
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
            <div class="page-header"><h1>New Category</h1></div>

            <div class="container-fluid">
                <form class="form-horizontal col-lg-6" action="new_category.php" method="post">
              
                    <div class="form-group">
                        <label for="category">New Category Name</label>
                        <input id="category" type="text" name="category" class="form-control">
                    </div>
                   
                    <div class="form-group">
                        <label></label>
                        <input type="submit" value="Add Category" name="submit_category" class="btn btn-danger btn-block">
                    </div>

                </form>
                
            </div>
        </div>



        <footer></footer>
        
    </body>


</html>