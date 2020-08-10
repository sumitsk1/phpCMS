<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php require_once('include/DB.php') ?>
<!-- PHP for comments -->
<?php 
global $ConnectionDB;
global $Connection;
	if (isset($_POST["Submit"])) {
		$Name=mysqli_real_escape_string($Connection,$_POST["Name"]);
		$Email=mysqli_real_escape_string($Connection,$_POST["Email"]);
		$Comment=mysqli_real_escape_string($Connection,$_POST["Comment"]);

		date_default_timezone_set("Asia/Kolkata");
		$CurrentTime=time();
		$DateTime=strftime("%d-%m-%Y %H:%M:%S",$CurrentTime);
		$POstId=$_GET['Id'];

		if (empty($Name)|| empty($Email)||empty($Comment)) {
			$_SESSION['ErrorMessage']="All Fields Required";

		}elseif (strlen($Comment)>500) {
			$_SESSION['ErrorMessage']="Only 500 characters Allowed in Comment";
		
		}else{
			global $ConnectionDB;
			global $Connection;
			$QueryCommet="INSERT INTO comments(datetime,name,email,comment,approvedby,status,admin_panel_id) 
			VALUES('$DateTime','$Name','$Email','$Comment','Pending','OFF','$POstId')";
			$Execute_QueryCommet=mysqli_query($Connection,$QueryCommet);
			
			if ($Execute_QueryCommet) {
				$_SESSION['SuccessMessage']="Comment Added Successfully, Wait For Approval";
				Redirect_to("FullPost.php?Id={$POstId}");

			}else{
				$_SESSION['ErrorMessage']="Failed to Add Comment";
				Redirect_to("FullPost.php?Id={$POstId}");
			}
			

			}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Full Blog Post</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/publicstyle.css">
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
				<li><a href="Blog.php">Home</a></li>
				<li class="active"><a href="Blog.php">Blog</a></li>
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
	<div class="container">
		<div class="row">
			<div class="blog-header">
				<br>
				<h2>Imagination is more important than knowledge</h2>
				<p>Sumit Sk</p>
				<hr>
					<div><?php echo Message(); echo SuccessMessage();?></div><hr>
				<br>
			</div>
			<div class="col-sm-8">
				<!-- Starting of Main Area -->
				<!-- <div style="box-shadow: 0px 0px 20px black; padding: 30px; background-color: rgba(0,0,0,0.4); text-align: justify;"> -->
				<?php
					global $ConnectionDB;
					global $Connection;

					if (isset($_GET['SearchButton'])) {
						$search=$_GET['Search'];
						$ViewQuery="SELECT * FROM admin_panel 
						WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' ";
					}else{
						$PostidGet=$_GET['Id'];
						$ViewQuery="SELECT * FROM admin_panel WHERE id='$PostidGet' ORDER BY datetime Desc";
					}

					$ExecuteQuery=mysqli_query($Connection,$ViewQuery);
					while($DataRows=mysqli_fetch_array($ExecuteQuery)){

					$Postid=$DataRows['id'];
					$DateTime=$DataRows['datetime'];
					$Title=$DataRows['title'];
					$Category=$DataRows['category'];
					$Admin=$DataRows['author'];
					$Image=$DataRows['image'];
					$Post=$DataRows['post'];

				
				 ?>
				 <div class="blog thumbnail">
				 	
				 	<img src="uploads/<?php echo $Image; ?>" alt="thumbnail" class="img-responsive img-rounded">
				 	<div class="caption">
				 		<h1  id="title" ><?php echo htmlentities($Title); ?></h1>
				 		<p class="desc">Category: <?php echo htmlentities($Category);?>&nbsp;&nbsp;&nbsp;Published On: <?php echo htmlentities($DateTime); ?></p>
				 	</div>
				 	<div class="post"><?php echo nl2br($Post); ?></div>
				 </div>

				 <?php } ?>
				 <br>
				 <!-- comment Form starting -->
				<span class="catName" style="font-size: 2.5rem;">Add Your Comments</span><hr>

				<form action="FullPost.php?Id=<?php echo $POstId; ?>" method="post" enctype="multipart/form-data">
						<div class='form-group'>
							<label for='name' ><span class="catName">Name:</span></label>
							<input class="form-control" type="text" name="Name" id='name' placeholder="Name"><span></span>
						</div>
						<div class='form-group'>
							<label for='email' ><span class="catName">Email:</span></label>
							<input class="form-control" type="email" name="Email" id='email' placeholder="Email"><span></span>
						</div>
						
						<div class='form-group'>
							<label for='commentarea' ><span class="catName">Comment:</span></label>
							<textarea rows="5" class="form-control"  name="Comment" id='commentarea' placeholder="Comment 500 Character Allowed Only"></textarea>
						</div>
						<div class='form-group'>
							<input class="btn btn-primary" type="submit" name="Submit" value="Comment" formaction="">
							<br>
						</div>
				</form>
				<hr>
				 <!-- display comments -->
				<div>
					<br>
				<span class="catName" style="font-size: 3rem;">Comments</span><hr>
				<?php 
					global $ConnectionDB;
					global $Connection;

					$POstId=$_GET['Id'];

					$ViewCommentQuery="SELECT * FROM comments WHERE admin_panel_id='$POstId' AND status='ON' ORDER BY datetime desc";
					$ExecuteCommentQuery=mysqli_query($Connection,$ViewCommentQuery);
					while($DataRows=mysqli_fetch_array($ExecuteCommentQuery)){

					$Commentid=$DataRows['id'];
					$CommentDate_Time=$DataRows['datetime'];
					$CommenterName=$DataRows['name'];
					$CommentComment=$DataRows['comment'];
				 ?>

					<div class="comments thumbnail">
					 	<div class="row">
					 		<div class="col-sm-2">
					 			<img class="pull-right" src="image/comment.png" alt="thumbnail" class="img-responsive img-rounded" width="100px" height="100px">
					 		</div>

					 		<div class="col-sm-10">
					 			<p ><span class="catName">Name:</span>&nbsp;&nbsp;<?php echo $CommenterName; ?></p>
								<p ><span class="catName ">Time:</span>&nbsp;&nbsp;<?php echo $CommentDate_Time; ?></p>
								<p ><span class="catName">Comment:</span>&nbsp;&nbsp;<?php echo $CommentComment; ?></p>
					 		</div>
					 	</div>
					 	
					 </div>
						<hr>
				<?php } ?>
				<br>
				<br>
				
				</div>
				<!-- comment Form starting -->

				<!-- </div> -->
			</div>
			<!-- Ending of main Area -->
			<div  class="col-sm-offset-1 col-sm-3">
				<!-- Starting of Side Area -->
				<!-- <div style="box-shadow: 0px 0px 20px black; padding: 30px; background-color: rgba(0,0,0,0.4); text-align: justify;"> -->
				<p >
					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
					
				</p>
				<!-- </div> -->
			</div>
			<!--Ending od SideBar  -->
		</div>
		<!--Ending of row  -->
		
	</div>
	<!-- Ending Of Container -->
	<div id="footer">
		<hr><p>This Site is designed By Sumit</p><hr>
		<a href="#"><p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></a>
	</div>
	<div style="height: 10px; background-color: #27aae1;"></div>

</body>
</html>