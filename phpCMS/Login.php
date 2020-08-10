<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php require_once('include/DB.php') ?>
<?php 
global $ConnectionDB;
global $Connection;
	if (isset($_POST["Submit"])) {
		$UserName=mysqli_real_escape_string($Connection,$_POST["UserName"]);
		$Password=mysqli_real_escape_string($Connection,$_POST["Password"]);
	
		if (empty($UserName)||empty($Password)) {
			$_SESSION['ErrorMessage']="All Field Must be Filled";
			Redirect_to("Login.php");
		}else{
			$Account_Found=Login_Attempt($UserName,$Password);
			$_SESSION["User_ID"]=$Account_Found['id'];
			$_SESSION["UserName"]=$Account_Found['username'];
			if ($Account_Found) {
				$_SESSION['SuccessMessage']="Login Successful , Welcome {$_SESSION["UserName"]}";
				Redirect_to("Dashboard.php");
			}else{
				$_SESSION['ErrorMessage']="Invalid Email And Password";
				Redirect_to("Login.php");	
			}

		}
	}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/adminstyle.css">
	<style>
		
	</style>
</head>
<body>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
					<ul class="nav navbar-nav">
						<li style="margin-left: 30px;" ><a href="Blog.php" target="_blank">Home</a></li>
					</ul>
			</div>
		</div>
	</nav>
	
	<div class="container-fluid">
		<div class="row">
			<br><br><br>
			<div class="col-sm-offset-4 col-sm-4 loginpage">
				<br>
				<div><?php echo Message(); echo SuccessMessage();?></div>
				<h1>Admin Login !</h1><hr>
				<form action="Login.php" method="post">
						<div class='form-group'>
							<label for='username' ><span class="catName">User Name:</span></label>
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-user text-primary"></span>
								</span>
								<input class="form-control" type="text" name="UserName" id='username' placeholder="User Name"><span></span>
							</div>
						</div>
						<div class='form-group'>
							<label for='password' ><span class="catName">Password:</span></label>
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-lock text-primary"></span>
								</span>
								<input class="form-control" type="password" name="Password" id='password' placeholder="Password"><span>
							</div>
							</span>
						</div>
						<div class='form-group'>
							<input class="btn btn-primary" type="submit" name="Submit" value="Login" formaction="">
							<br>
						</div>
				</form>
				<br>
				
			</div>
			<!-- col-sm-10 -->
		</div>
		<!-- row ending -->
	</div>
	<!-- container-fluid ending -->

</body>
</html>