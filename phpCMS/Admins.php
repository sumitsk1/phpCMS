<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php echo confirm_login(); ?>
<?php 
global $ConnectionDB;
global $Connection;
	if (isset($_POST["Submit"])) {
		$UserName=mysqli_real_escape_string($Connection,$_POST["UserName"]);
		$Password=mysqli_real_escape_string($Connection,$_POST["Password"]);
		$ConfirmPassword=mysqli_real_escape_string($Connection,$_POST["ConfirmPassword"]);
		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);
		$Admin=$_SESSION["UserName"];
		if (empty($UserName)||empty($Password)||empty($ConfirmPassword)) {
			$_SESSION['ErrorMessage']="Field Must be Filled";
			Redirect_to("Admins.php");
		}elseif (strlen($Password)<4) {
			$_SESSION['ErrorMessage']="Atleast 4 characters for Password";
			Redirect_to("Admins.php");

		}elseif ($Password!==$ConfirmPassword) {
			$_SESSION['ErrorMessage']="Password Does Not Matched";
			Redirect_to("Admins.php");
		}else{
			global $ConnectionDB;
			global $Connection;
			$QueryAdmin="INSERT INTO registration(datetime,username,password,addedby)
			VALUES('$DateTime','$UserName','$Password','$Admin')";
			$ExecuteAdmin=mysqli_query($Connection,$QueryAdmin);
			if ($ExecuteAdmin) {
				$_SESSION['SuccessMessage']="New Admin Added Successfully";
				Redirect_to("Admins.php");
			}else{
				$_SESSION['ErrorMessage']="Failed to Add New Admin";
				Redirect_to("Admins.php");
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
					<li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;ADD New Post</a></li>
					<li ><a href="Category.php"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Category</a></li>
					<li class="active"><a href="Admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Manage Admins</a></li>
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
				<h1>Manage Admin Access</h1><hr>
				<div><?php echo Message(); echo SuccessMessage();?></div><hr>
				<form action="Admins.php" method="post">
						<div class='form-group'>
							<label for='username' ><span class="catName">User Name:</span></label>
							<input class="form-control" type="text" name="UserName" id='username' placeholder="User Name"><span></span>
						</div>
						<div class='form-group'>
							<label for='password' ><span class="catName">Password:</span></label>
							<input class="form-control" type="password" name="Password" id='password' placeholder="Password"><span></span>
						</div>
						<div class='form-group'>
							<label for='confirmpassword' ><span class="catName">Confirm Password:</span></label>
							<input class="form-control" type="password" name="ConfirmPassword" id='confirmpassword' placeholder="Enter Password Again"><span></span>
						</div>
						<div class='form-group'>
							<input class="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admin" formaction="">
							<br>
						</div>
				</form>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<h2>Category Details</h2><hr>
			<thead>
				<tr>
					<th >S No.</th>
					<th>Date & Time</th>
					<th>Admin Name</th>
					<th>Added By</th>
					<th>Delete</th>
					<!-- <th>Update</th> -->
					
				</tr>
			</thead>
			<tbody>
			<?php 
			global $ConnectionDB;
			global $Connection;
			$ViewQueryAdmin="SELECT * FROM registration ORDER BY datetime Desc";
			$SrNo=0;
			$ExecuteQueryAdmin=mysqli_query($Connection,$ViewQueryAdmin);
			while($DataRows=mysqli_fetch_array($ExecuteQueryAdmin)){

				$AdminId=$DataRows['id'];
				$Date_Time_Admin=$DataRows['datetime'];
				$UserNameAdmin=$DataRows['username'];
				$AddedByName=$DataRows['addedby'];
				$SrNo++;
			 ?>
				<tr>
					<td><?php echo $SrNo; ?></td>
					<td><?php echo $Date_Time_Admin; ?></td>
					<td><?php echo $UserNameAdmin; ?></td>
					<td><?php echo $AddedByName; ?></td>
					<td><a href="delete.php?DeleteAdmin=<?php echo $AdminId; ?>"><button class="btn btn-danger">Delete</button></a></td>
					
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