<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php echo confirm_login(); ?>
<?php 
global $ConnectionDB;
global $Connection;
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
		if (empty($Title) || empty($Post)) {
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
			$QueryAdmin_panel="INSERT INTO admin_panel(datetime,title,category,author,image,post) 
			VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
			$ExecuteAdmin_panel=mysqli_query($Connection,$QueryAdmin_panel);
			move_uploaded_file($_FILES['ImageI']['tmp_name'], $Target);
			if ($ExecuteAdmin_panel) {
				$_SESSION['SuccessMessage']="Post Added Successfully";
				Redirect_to("AddNewPost.php");
			}else{
				$_SESSION['ErrorMessage']="Failed to Add Post";
				Redirect_to("AddNewPost.php");
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
	<div class="Line"></div>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" callapsed data-toggle='collapse' data-target='#collapse'>
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="Blog.php" class="navbar-brand">
					<img style="margin-top: -12px; margin-left: -30px; margin-right: 30px; border-radius: 5px;" src="image/header.png" width=200; height=45px; alt="">
				</a>
			</div>
			<div class="collapse navbar-collapse" id='collapse'>
			<ul class="nav navbar-nav">
				<li><a href="Blog.php" target="_blank">Home</a></li>
				<li class="active" ><a href="Blog.php" target="_blank">Blog</a></li>
				<li><a href="">AboutUs</a></li>
				<li><a href="">Services</a></li>
				<li><a href="">Contact Us</a></li>
				<li><a href="">Features</a></li>
			</ul>
			<!-- Search Form -->
			<form action="Blog.php" class="navbar-form navbar-right" >
				<div class='form-group'>
					<input class="form-control" type="text" name="Search" placeholder="Search">
				</div>
				<button class="btn btn-default" style="" name="SearchButton">Go</button>
			</form>
			</div>
		</div>
	</nav>
	<div class="Line " style="margin-top: -20px;"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<h2 style="color: white; ">Admin Panel</h2><hr>
				<ul id="sidemenu" class="nav nav-pills nav-stacked">
					<li ><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Dashboard
						<?php 
							global $ConnectionDB;
							global $Connection;
							$QueryTotalPost="SELECT COUNT(*) FROM admin_panel";
							$ExecuteTotalPost=mysqli_query($Connection,$QueryTotalPost);
							$DataRowsPost=mysqli_fetch_array($ExecuteTotalPost);
							$TotalPost=array_shift($DataRowsPost);
						?>
						<span class="label label-primary pull-right"><?php echo $TotalPost; ?></span>
					</a></li>
					<li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;ADD New Post</a></li>
					<li ><a href="Category.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Category</a></li>
					<li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Admins</a></li>
					<li><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;Comments
							
						<?php 
							global $ConnectionDB;
							global $Connection;
							$QueryTotalUnApproved="SELECT COUNT(*) FROM comments WHERE status='OFF'";
							$ExecuteTotalUnApproved=mysqli_query($Connection,$QueryTotalUnApproved);
							$DataRowsUnApproved=mysqli_fetch_array($ExecuteTotalUnApproved);
							$TotalUnApprovedIN=array_shift($DataRowsUnApproved);
						?>
						<span class="label label-danger pull-right"><?php echo $TotalUnApprovedIN; ?></span>
						<?php 
							global $ConnectionDB;
							global $Connection;
							$QueryTotalApproved="SELECT COUNT(*) FROM comments WHERE status='ON'";
							$ExecuteTotalApproved=mysqli_query($Connection,$QueryTotalApproved);
							$DataRowsApproved=mysqli_fetch_array($ExecuteTotalApproved);
							$TotalApprovedIN=array_shift($DataRowsApproved);
						?>
						<span class="label label-success pull-right"><?php echo $TotalApprovedIN; ?></span>
					</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;&nbsp;Live Bloag</a></li>
					<li><a href="Logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;LogOut</a></li>
				</ul>

			</div>
			<!-- col-sm-2 side area ending -->
			<div class="col-sm-10">
				<br>
				<h1>Add New Post</h1><hr>
				<div><?php echo Message(); echo SuccessMessage();?></div><hr>
				<div>
				<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
						<div class='form-group'>
							<label for='title' ><span class="catName">Title:</span></label>
							<input class="form-control" type="text" name="Title" id='title' placeholder="Title"><span></span>
						</div>
						<div class='form-group'>
							<label for='categoryselect' ><span class="catName">Category:</span></label>
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
							<input class="form-control" type="file" name="ImageI" id='imageselect'>
						</div>

						<div class='form-group'>
							<label for='postarea' ><span class="catName">Post:</span></label>
							<textarea rows="20" class="form-control"  name="Post" id='postarea' placeholder="Post"></textarea>
						</div>
						<div class='form-group'>
							<input class="btn btn-success btn-block" type="submit" name="submit" value="Add New Post" formaction="">
							<br>
						</div>
				</form>
				</div>

				
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