<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php require_once('include/DB.php') ?>
<?php echo confirm_login(); ?>

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
					<li class="active"><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Dashboard
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
					<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;ADD New Post</a></li>
					<li><a href="Category.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Category</a></li>
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
				<h1>Admin Dashboard</h1><hr>
				<div><?php echo Message(); echo SuccessMessage();?></div><hr>
				
		<div class="table-responsive">
		<table class="table table-striped table-hover">
			<h2>Post Details</h2><hr>
				<thead>
					<tr>
						<th >No.</th>
						<th>Post Title</th>
						<th>Date & Time</th>
						<th>Author</th>
						<th>Category</th>
						<th>Banner</th>
						<th>Comments</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				global $ConnectionDB;
				global $Connection;
				$ViewQuery="SELECT * FROM admin_panel ORDER BY datetime desc";
				$SrNo=0;
				$ExecuteQuery=mysqli_query($Connection,$ViewQuery);
				while($DataRows=mysqli_fetch_array($ExecuteQuery)){

					$id=$DataRows['id'];
					$Date_Time=$DataRows['datetime'];
					$Title=$DataRows['title'];
					$Category=$DataRows['category'];
					$Admin=$DataRows['author'];
					$Image=$DataRows['image'];
					$Post=$DataRows['post'];
					$SrNo++;
				 ?>
					<tr>
						<td><?php echo $SrNo; ?></td>
						<td style="color: blue; font-weight: bold;"><?php
							 if (strlen($Title)>15) { $Title=substr($Title, 0,15)."...";}  
							 echo $Title; ?></td>
						<td><?php
							 if (strlen($Date_Time)>15) { $Date_Time=substr($Date_Time, 0,15)."...";}  
							 echo $Date_Time; ?></td>
						<td><?php echo $Admin; ?></td>
						<td><?php echo $Category; ?></td>
						<td><img src="uploads/<?php echo $Image; ?>" alt="" width="150px" heoght="50px"></td>
						<td>
							<!-- approved comments -->
						<?php 
							global $ConnectionDB;
							global $Connection;
							$ViewQueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='ON'";
							$ExecuteQueryApproved=mysqli_query($Connection,$ViewQueryApproved);
							$DataRowsApproved=mysqli_fetch_array($ExecuteQueryApproved);
							$TotalApproved=array_shift($DataRowsApproved);
						?>
						<span class="label label-success pull-right"><?php echo $TotalApproved; ?></span>
						<!--UN approved comments -->
						<?php 
							global $ConnectionDB;
							global $Connection;
							$ViewQueryUnApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='OFF'";
							$ExecuteQueryUnApproved=mysqli_query($Connection,$ViewQueryUnApproved);
							$DataRowsUnApproved=mysqli_fetch_array($ExecuteQueryUnApproved);
							$TotalUnApproved=array_shift($DataRowsUnApproved);
						?>
						<span class="label label-danger pull-left"><?php echo $TotalUnApproved; ?></span>
						
							
						</td>
						<td><a href="EditPost.php?Edit=<?php echo $id; ?>"><button class="btn btn-info">Edit</button></a></td>
						<td><a href="Delete.php?DeletePost=<?php echo $id; ?>"><button class="btn btn-danger">Delete</button></a></td>
						
						<td><a target="_blank" href="FullPost.php?Id=<?php echo $id; ?>" ><button class="btn btn-primary">Live Preview</button></a></td>
						
					</tr>
				<?php } ?>
					
				</tbody>
				
			</table>
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