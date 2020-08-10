<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>

<?php 
global $ConnectionDB;
global $Connection;
if ($delete_id=$_GET['DeleteCategory']) {
	$delete_id=$_GET['DeleteCategory'];
	$delete_query="DELETE FROM category WHERE id='$delete_id'";
	$run_query=mysqli_query($Connection,$delete_query);
	if ($run_query) {
		$_SESSION['SuccessMessage']="Category Deleted Successfully";
		Redirect_to("Category.php");
}	else{
		$_SESSION['ErrorMessage']="Failed to Delete Category";
		Redirect_to("Category.php");
}

}elseif ($delete_id=$_GET['DeletePost']) {
	$delete_id=$_GET['DeletePost'];
	$delete_query="DELETE FROM admin_panel WHERE id='$delete_id'";
	$run_query=mysqli_query($Connection,$delete_query);
	if ($run_query) {
		$_SESSION['SuccessMessage']="Post Deleted Successfully";
		Redirect_to("Dashboard.php");
	}else{
		$_SESSION['ErrorMessage']="Failed to Delete Post";
		Redirect_to("Dashboard.php");
	}
}elseif ($delete_id=$_GET['DeleteComment']) {
	$delete_id=$_GET['DeleteComment'];
	$delete_query="DELETE FROM comments WHERE id='$delete_id'";
	$run_query=mysqli_query($Connection,$delete_query);
	if ($run_query) {
		$_SESSION['SuccessMessage']="Comment Deleted Successfully";
		Redirect_to("Comments.php");
	}else{
		$_SESSION['ErrorMessage']="Failed to Delete Comment";
		Redirect_to("Comments.php");
	}
}elseif ($delete_id=$_GET['DeleteAdmin']) {
	$delete_id=$_GET['DeleteAdmin'];
	$delete_query="DELETE FROM registration WHERE id='$delete_id'";
	$run_query=mysqli_query($Connection,$delete_query);
	if ($run_query) {
		$_SESSION['SuccessMessage']="Admin Deleted Successfully";
		Redirect_to("Admins.php");
	}else{
		$_SESSION['ErrorMessage']="Failed to Delete Admin";
		Redirect_to("Admins.php");
	}
}





 ?>