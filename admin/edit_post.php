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
	if(isset($_POST['submit_edit_post'])){
        $title = strip_tags($_POST['title']);
        $description = strip_tags($_POST['description']);
		$date = date('Y-m-d h:i:s');
		if($_FILES['image']['name'] != ''){
			$image_name = $_FILES['image']['name'];
			$image_tmp = $_FILES['image']['tmp_name'];
			$image_size = $_FILES['image']['size'];
			$image_ext = pathinfo($image_name,PATHINFO_EXTENSION);
            //$image_path = '../image/'.$image_name;
            $image_path = '/Applications/XAMPP/htdocs/php/cms_blog/image/'.$image_name;
			$image_db_path = 'image/'.$image_name;
			
			if($image_size < 1000000){
				if($image_ext == 'jpg' || $image_ext == 'png' || $image_ext == 'gif'){
					if(move_uploaded_file($image_tmp,$image_path)){
                        
                        $upd_sql = "UPDATE posts SET title = '$title', description = '$description', image = '$image_db_path', category = '$_POST[category]', status = '$_POST[status]', date = '$date', author='$_SESSION[user]' WHERE id = '$_POST[edit_id]'";
						if(mysqli_query($conn,$upd_sql)){
							header('Location: post_list.php');
						}else {
							$error = '<div class="alert alert-danger">The Query Was not Working!</div>';
						}
					}else{
						$error = '<div class="alert alert-danger">Sorry, Unfortunately Image hos not been uploaded!</div>';
					}
					
				} else {
					$error = '<div class="alert alert-danger">Image Format was not Correct!</div>';
				}
				
			} else {
				$error = '<div class="alert alert-danger">Image File Size is much bigger then Expect!</div>';
			}
		} else {
            
            $upd_sql = "UPDATE posts SET title = '$title', description = '$description', category = '$_POST[category]', status = '$_POST[status]', date = '$date', author='$_SESSION[user]' WHERE id = '$_POST[edit_id]'";
			if(mysqli_query($conn,$upd_sql)){
				header('Location: post_list.php');
			}else {
				$error = '<div class="alert alert-danger">The UPD Query Was not Working!</div>';
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
		<script src="../../js/jquery.js"></script>
		<script src="../../bootstrap/js/bootstrap.js"></script>
		<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
		<script>tinymce.init({selector:'textarea'});</script>
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div style="width:50px;height:50px;"></div>
		
        <?php echo $error; include 'includes/sidebar.php';?>
        
		<div class="col-lg-8">
            <?php 
                if(isset($_GET['edit_id'])){
                    $sql = "SELECT * FROM posts WHERE id = '$_GET[edit_id]'";
                    $run_sql = mysqli_query($conn, $sql);
                    while($rows = mysqli_fetch_assoc($run_sql)){ 
            ?>

            <div class="page-header"><h1>Edit Post</h1></div>
			<div class="container-fluid">
                <form class="form-horizontal" action="edit_post.php" method="post" enctype="multipart/form-data">
                <img src="<?php echo "../".$rows['image']; ?>" width="100px">
					<div class="form-group">
						<label for="image">Upload an Image</label>
						<input id="image" type="file" name="image" class="btn btn-primary">
					</div>
					<div class="form-group">
                    <input type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>">
						<label for="title">Title</label>
						<input id="title" type="text" name="title" value="<?php echo $rows['title']; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="category">Category</label>
						<select id="category" name="category" class="form-control" required>
							<option value="">Select Any Category</option>
							<?php
								$sel_sql = "SELECT * FROM category";
								$run_sql = mysqli_query($conn,$sel_sql);
								while($c_rows = mysqli_fetch_assoc($run_sql)){
									if($c_rows['category_name'] == 'home'){
										continue;
									}
									echo '<option value="'.$c_rows['c_id'].'">'.ucfirst($c_rows['category_name']).'</option>';
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea id="description" name="description"><?php echo $rows['description']; ?></textarea>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<select id="status" name="status" class="form-control">
							<option value="draft">Draft</option>
							<option value="publish">Publish</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" name="submit_edit_post" value="Submit editting" class="btn btn-danger btn-block">
					</div>
				</form>
			</div>
			
		
            <?php
                        
                    }
                }
            ?>

			
        </div>
		<footer></footer>
	</body>
</html>