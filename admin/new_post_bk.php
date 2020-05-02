<?php session_start();
	include 'includes/db.php';
	if(isset($_SESSION['user']) && isset($_SESSION['password']) == true){
		$sel_sql = "SELECT * FROM users WHERE user_email = '$_SESSION[user]' AND user_password = '$_SESSION[password]'";
		if($run_sql = mysqli_query($conn, $sel_sql)){
			while($rows = mysqli_fetch_assoc($run_sql)){
				if(mysqli_num_rows($run_sql) == 1 ){
					if($rows['role'] == 'admin'){
					} else {
						header('Location:../index.php');
					}
				} else{
					header('Location:../index.php');
				}
			}
		}
	} else {
		header('Location:../index.php');
    }

    $error = '';
    if(isset($_POST['submit_post'])){
        $title = strip_tags($_POST['title']);
        $date = date('Y-m-d h:i:s');
        if($_FILES['image']['name'] != ''){
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_ext = pathinfo($image_name,PATHINFO_EXTENSION);
            $image_path = '../image/'.$image_name;
            $image_db_path = 'image/'.$image_name;

            if($image_size < 1000000){
                if($image_ext == 'jpg' || $image_ext == 'png' || $image_ext == 'gif' || $image_ext == 'jpeg' ){
                    if(move_uploaded_file($image_tmp,$image_path)){
                        $ins_sql = "INSERT INTO posts (title, description, image, category, date, author) VALUES ('$title', '$_POST[description]', '$image_db_path', '$_POST[category]',  '$date', '$_SESSION[user]')";
                        if(mysqli_query($conn,$ins_sql)){
                            header('Location: post_list.php');
                        }else {
                            $error = '<div class="alert alert-danger">The query was not working properly.</div>';
                        }
                    }else {
                        $error = '<div class="alert alert-danger">Sorry, Unfortunately Image has not been uploaded correctly.</div>';
                    }

                } else {
                    $error = '<div class="alert alert-danger">Image Format was incorrect.</div>';
                }
            }else {
                $error = '<div class="alert alert-danger">Image File Size is much bigger than Expected.</div>';
            }
        } else {
			
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
        <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
		<script>tinymce.init({selector:'textarea'});</script>
        
    </head>

    <body>
        <?php include 'includes/header.php';?>
        <div style="width: 50px; height: 50px;"></div>
        <?php include 'includes/sidebar.php';?>

        <div class="col-lg-8">
        <?php echo $_SESSION['user']; ?>
            <div class="page-header"><h1>New Post</h1></div>

            <div class="container-fluid">
                <form class="form-horizontal" action="new_post.php" method="post" enctype="multipart/form-data">
                <!-- **multipart/form-data: do not encode, it's a must setting when you have files to be uploaded** -->
                    <div class="form-group">
                        <label for="image">Upload an Image</label>
                        <input id="image" type="file" name="image" class="btn btn-primary">
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-control" required>
                            <?php 
                                $sel_sql = "SELECT * FROM category";
                                $run_sql = mysqli_query($conn, $sel_sql);
                                while($rows = mysqli_fetch_assoc($run_sql)) {
                                    if($rows['category_name'] == 'home'){

                                    } else {
                                        echo '<option value="'.$rows['category_name'].'">'.ucfirst($rows['category_name']).'</option>';
                                    }
                                    
                                }
                            ?>
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <input type="submit" value="submit post" name="submit_post" class="btn btn-danger btn-block">
                    </div>

                </form>
                
            </div>
        </div>


        <!-- <div class="col-lg-10">
           
        </div> -->

        <footer></footer>
        
    </body>


</html>