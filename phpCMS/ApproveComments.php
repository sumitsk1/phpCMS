<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php 

global $ConnectionDB;
global $Connection;

if ($get_id=$_GET['Approve']) {
	
	$get_id=$_GET['Approve'];
	$Admin=$_SESSION["UserName"];
	$Update_query="UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$get_id'";
	$execute = mysqli_query($Connection, $Update_query);
	if ($execute) {
		$_SESSION['SuccessMessage']="Comment Approved Successfully";
		Redirect_to("Comments.php");
	}else{
		$_SESSION['ErrorMessage']="Failed to Approve Comment";
		Redirect_to("Comments.php");
	}

}elseif ($get_id=$_GET['UnApprove']) {
	
	$get_id=$_GET['UnApprove'];
	$Update_query="UPDATE comments SET status='OFF' WHERE id='$get_id'";
	$execute = mysqli_query($Connection, $Update_query);
	if ($execute) {
		$_SESSION['SuccessMessage']="Comment Approved Successfully";
		Redirect_to("Comments.php");
	}else{
		$_SESSION['ErrorMessage']="Failed to Approve Comment";
		Redirect_to("Comments.php");
	}
}



 ?>