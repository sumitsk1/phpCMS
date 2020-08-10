<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php 

$_SESSION['User_Id']=null;
session_destroy();
Redirect_to('Login.php');

 ?>

