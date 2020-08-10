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
					<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;ADD New Post</a></li>
					<li><a href="Category.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Category</a></li>
					<li><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Admins</a></li>
					<li class="active"><a href="Comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;Comments
							
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
				<h1>Manage Comments</h1><hr>
				<div><?php echo Message(); echo SuccessMessage();?></div><hr>
				<!-- UN-Approved comments table -->
		<div class="table-responsive">
		<table class="table table-striped table-hover">
			<h2>Un-Approved Comments</h2><hr>
				<thead>
					<tr>
						<th >No.</th>
						<th>Name</th>
						<th>Date</th>
						<th>Comment</th>
						<th>Approve</th>
						<th>Delete</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					global $ConnectionDB;
					global $Connection;
					$SrNo=0;
					$ViewCommentQuery="SELECT * FROM comments WHERE status='OFF' ORDER BY datetime desc";
					$ExecuteCommentQuery=mysqli_query($Connection,$ViewCommentQuery);
					while($DataRows=mysqli_fetch_array($ExecuteCommentQuery)){

					$Commentid=$DataRows['id'];
					$CommentDate_Time=$DataRows['datetime'];
					$CommenterName=$DataRows['name'];
					$CommentComment=$DataRows['comment'];
					$Admin_panel_id=$DataRows['admin_panel_id'];

					$SrNo++;
				 ?>
					<tr>
						<td><?php echo $SrNo; ?></td>
						<td style="color: blue; font-weight: bold;"><?php
							 if (strlen($CommenterName)>15) { $CommenterName=substr($CommenterName, 0,15)."...";}  
							 echo $CommenterName; ?></td>
						<td><?php
							 if (strlen($CommentDate_Time)>17) { $CommentDate_Time=substr($CommentDate_Time, 0,17)."...";}  
							 echo $CommentDate_Time; ?></td>
						<td style="word-wrap: break-word;min-width: 200px;max-width: 400px;"><?php echo $CommentComment; ?></td>

						<td><a href="ApproveComments.php?Approve=<?php echo $Commentid; ?>"><button class="btn btn-info">Approve</button></a></td>
						<td><a href="Delete.php?DeleteComment=<?php echo $Commentid; ?>"><button class="btn btn-danger">Delete</button></a></td>
						
						<td><a target="_blank" href="#" ><button class="btn btn-primary">Preview</button></a></td>
						
					</tr>
				<?php } ?>
					
				</tbody>
				
			</table>
			</div>
<!-- Approved comments table -->
			<div class="table-responsive">
		<table class="table table-striped table-hover">
			<h2>Approved Comments</h2><hr>
				<thead>
					<tr>
						<th >No.</th>
						<th>Name</th>
						<th>Date</th>
						<th>Comment</th>
						<th>Approved By</th>
						<th>Un-Approve</th>
						<th>Delete</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					global $ConnectionDB;
					global $Connection;
					$Admin=$_SESSION["UserName"];
					$SrNo=0;
					$ViewCommentQuery="SELECT * FROM comments WHERE status='ON' ORDER BY datetime desc";
					$ExecuteCommentQuery=mysqli_query($Connection,$ViewCommentQuery);
					while($DataRows=mysqli_fetch_array($ExecuteCommentQuery)){

					$Commentid=$DataRows['id'];
					$CommentDate_Time=$DataRows['datetime'];
					$CommenterName=$DataRows['name'];
					$CommentComment=$DataRows['comment'];
					$ApprovedBy=$DataRows['approvedby'];
					$Admin_panel_id=$DataRows['admin_panel_id'];

					$SrNo++;
				 ?>
					<tr>
						<td><?php echo $SrNo; ?></td>
						<td style="color: blue; font-weight: bold;"><?php
							 if (strlen($CommenterName)>15) { $CommenterName=substr($CommenterName, 0,15)."...";}  
							 echo $CommenterName; ?></td>
						<td><?php
							 if (strlen($CommentDate_Time)>17) { $CommentDate_Time=substr($CommentDate_Time, 0,17)."...";}  
							 echo $CommentDate_Time; ?></td>
						<td style="word-wrap: break-word;min-width: 200px;max-width: 400px;"><?php echo $CommentComment; ?></td>

						<td><?php echo $ApprovedBy; ?></td>
						<!-- Admin Is Here -->
						<td><a href="ApproveComments.php?UnApprove=<?php echo $Commentid; ?>"><button class="btn btn-info">Un-Approve</button></a></td>
						<td><a href="Delete.php?DeleteComment=<?php echo $Commentid; ?>"><button class="btn btn-danger">Delete</button></a></td>
						
						<td><a target="_blank" href="FullPost.php?Id=<?php echo $Admin_panel_id; ?>" ><button class="btn btn-primary">Preview</button></a></td>
						
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