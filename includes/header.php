
					
<?php
	$sel_cat = "SELECT * FROM category";
	$run_cat = mysqli_query($conn,$sel_cat);
	while($rows = mysqli_fetch_assoc($run_cat)){
		if(isset($_GET['cat_id'])){
			if($_GET['cat_id'] == $rows['c_id']){
			$class = 'active';
			} else {
				$class = '';
			}
		}else {
			$class='';
		}
		if($rows['category_name'] == 'home'){
			if($_SERVER['PHP_SELF'] == '/php/cms/index.php'){
				echo '<li class="active"><a href="index.php">'.ucfirst($rows['category_name']).'</a>';
			} else {
				echo '<li class=""><a href="index.php">'.ucfirst($rows['category_name']).'</a>';
				
			}
		}else {
			echo '<li class="'.$class.'"><a href="menu.php?cat_id='.$rows['c_id'].'">'.ucfirst($rows['category_name']).'</a></li>';
		}
	}
?>
