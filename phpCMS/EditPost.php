<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php echo confirm_login(); ?>

<?php 
global $ConnectionDB;
global $Connection;
$Edit_id=$_GET['Edit'];

	if (isset($_POST["submit"])) {
		$Title=mysqli_real_escape_string($Connection,$_POST["Title"]);
		$Category=$_POST["Category"];
		$Post=mysqli_real_escape_string($Connection,$_POST["Post"]);

		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);
		$Admin=$_SESSION["UserName"];
		$Image=$_FILES['ImageI']['name'];
		$Target="uploads/".basename($Image);
		if (empty($Title && $Post)) {
			$_SESSION['ErrorMessage']="Title & Post Can't be Empty";
			Redirect_to("AddNewPost.php");
		}elseif (strlen($Title)<3) {
			$_SESSION['ErrorMessage']="Title Can't be less then 4 character";
			Redirect_to("AddNewPost.php");
		}elseif (strlen($Post)<19) {
			$_SESSION['ErrorMessage']="Post Can't be less then 20 character";
			Redirect_to("AddNewPost.php");
		}else{
			global $ConnectionDB;
			global $Connection;
				$Query_update="UPDATE admin_panel SET datetime='$DateTime',title='$Title',category='$Category',author='$Admin',image='$Image', post='$Post' WHERE id='$Edit_id'";
			$ExecuteAdmin_panel=mysqli_query($Connection,$Query_update);
			move_uploaded_file($_FILES['ImageI']['tmp_name'], $Target);
			if ($ExecuteAdmin_panel) {
				$_SESSION['SuccessMessage']="Post Updated Successfully";
				Redirect_to("Dashboard.php");
			}else{
				$_SESSION['ErrorMessage']="Failed to Update Post";
				Redirect_to("Dashboard.php");
			}
			

			}
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/adminstyle.css">
	<style>
		
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<h2 style="color: white; ">Admin Panel</h2><hr>
				<ul id="sidemenu" class="nav nav-pills nav-stacked">
					<li class="active"><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Dashboard</a></li>
					<li ><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;ADD New Post</a></li>
					<li ><a href="Category.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Category</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Admins</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;&nbsp;Live Bloag</a></li>
					<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;LogOut</a></li>
				</ul>

			</div>
			<!-- col-sm-2 side area ending -->
			<div class="col-sm-10">
				<br>
				<h1>Edit Post</h1><hr>
				<?php 
					global $ConnectionDB;
					global $Connection;

					$Edit_id=$_GET['Edit'];
					$EditQuery="SELECT * FROM admin_panel WHERE id='$Edit_id'";
					$Run_Query=mysqli_query($Connection,$EditQuery);
					$ExecuteQuery=mysqli_fetch_array($Run_Query);
						$Edit_id=$ExecuteQuery['id'];
						$Edit_Date_Time=$ExecuteQuery['datetime'];
						$Edit_Title=$ExecuteQuery['title'];
						$Edit_Category=$ExecuteQuery['category'];
						$Edit_Admin=$ExecuteQuery['author'];
						$Edit_Image=$ExecuteQuery['image'];
						$Edit_Post=$ExecuteQuery['post'];

				 ?>
				<form action="Dashboard.php" method="post" enctype="multipart/form-data">
						<div class='form-group'>
							<label for='title' ><span class="catName">Title:</span></label>
							<input class="form-control" type="text" name="Title" id='title' value='<?php echo $Edit_Title; ?>' placeholder="Title"><span></span>
						</div>
						<div class='form-group'>
							<label for='categoryselect' ><span class="catName">Category:</span></label>
							<span class="catName">Existing Category:</span><?php echo $Edit_Category; ?>
							<select class="form-control" name="Category" id='categoryselect' >
								<?php 
									global $ConnectionDB;
									global $Connection;
									$ViewQuery="SELECT * FROM category ORDER BY datetime Desc";
								
									$ExecuteQuery=mysqli_query($Connection,$ViewQuery);
									while($DataRows=mysqli_fetch_array($ExecuteQuery)){

										$id=$DataRows['id'];
										$CategoryName=$DataRows['name'];
									 ?>
									 <option><?php echo $CategoryName; ?></option>

									<?php } ?>
							</select>
						</div>
						<div class='form-group'>
							<label for='imageselect' ><span class="catName">Select Image:</span></label>
							<span class="catName">Existing Image:</span><?php echo $Edit_Image; ?>
							<input class="form-control" type="file" name="ImageI" id='imageselect'>
						</div>

						<div class='form-group'>
							<label for='postarea' ><span class="catName">Post:</span></label>
							<textarea class="form-control"  name="Post" id='postarea' placeholder="Post"><?php echo $Edit_Post; ?> </textarea>
						</div>
						<div class='form-group'>
							<input class="btn btn-success btn-block" type="submit" name="submit" value="Update Post" formaction="">
							<br>
						</div>
				</form>

				
			</div>
			<!-- col-sm-10 -->
		</div>
		<!-- row ending -->
	</div>
	<!-- container-fluid ending -->
	<div id="footer">
		<hr><p>This Site is designed By Sumit</p><hr>
		<a href="#"><p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></a>
	</div>
	<div style="height: 10px; background-color: #27aae1;"></div>
</body>
</html>