<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php echo confirm_login(); ?>

<?php 
$Admin='Amit';
global $ConnectionDB;
global $Connection;

date_default_timezone_set("Asia/Kolkata");
$CurrentTime=time();
$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);

$get_id=$_GET['UpdateCategory'];
// to show the data in form
$show_query="SELECT * FROM category WHERE id='$get_id'";
$run_show_query=mysqli_query($Connection,$show_query);
$Datadis=mysqli_fetch_array($run_show_query);
				$id=$Datadis['id'];
				$Date_Time=$Datadis['datetime'];
				$Name=$Datadis['name'];
				$CreatorName=$Datadis['creatorname'];

// to update the data in form and submit
if (isset($_POST['submit'])) {
	if (!empty($_POST['Category']) ) {
		$Date_Time_Updated=$DateTime;
		$Name_Updated=$_POST['Category'];
		$CreatorName_Updated=$Admin;

		$Update_query="UPDATE category SET datetime='$Date_Time_Updated',name='$Name_Updated',creatorname='$CreatorName_Updated' WHERE id='$get_id'";
		$execute = mysqli_query($Connection, $Update_query);
		if ($execute) {
			$_SESSION['SuccessMessage']="Category Updated Successfully";
			Redirect_to("Category.php");
		}else{
			$_SESSION['ErrorMessage']="Failed to Add Category";
			Redirect_to("Category.php");
		}
	}else{
		$_SESSION['ErrorMessage']="Field Must be Filled";
		Redirect_to("Category.php");
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
		body{
			background-color: white;
			padding: 100px;
		}
		form{
			padding: 50px;
			border: 1px solid gray;
		}

	</style>
</head>
<body>
	<body>
		<div class="container-fluid">
			<form action="Category.php" method="post">
				<div class='form-group'>
					<label for='categoryname'>Name</label>
					<input class="form-control" class="input" type="text" name="Category" value="<?php echo $Name; ?>" id='categoryname' placeholder="Name"><span></span>
				</div>
				<div class='form-group'>
					<input class="btn btn-success btn-block" type="submit" name="submit" value="Update Category" formaction=""><br>
				</div>
			</form>
		
		</div>
</body>
</html>