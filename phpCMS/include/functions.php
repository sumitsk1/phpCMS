<?php require_once('include/DB.php') ?>
<?php require_once('include/sessions.php') ?>

<?php  

function Redirect_to($New_Location){
	header("Location:".$New_Location);
	exit;
}

function Login_Attempt($UserName,$Password){
	global $ConnectionDB;
	global $Connection;

	$QueryLogin="SELECT * FROM registration 
	WHERE username='$UserName' AND password='$Password'";
	$ExecuteLogin=mysqli_query($Connection,$QueryLogin);

	if($admin=mysqli_fetch_assoc($ExecuteLogin)){
		return $admin;
	}else{
		return null;
	}



}
function login(){
	if (isset($_SESSION["User_ID"])) {
		return true;
	}
}
function confirm_login(){
	if (!login()) {
		$_SESSION['ErrorMessage']="Login Required";
		Redirect_to("Login.php");
	}
}

?>