<?php require_once('include/sessions.php') ?>
<?php require_once('include/functions.php') ?>
<?php require_once('include/DB.php') ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blog Page</title>
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
					}elseif (isset($_GET["Category"])) {
						$Category=$_GET["Category"];
						$ViewQuery="SELECT * FROM admin_panel WHERE category='$Category' ORDER BY datetime Desc";

					}elseif (isset($_GET['Page'])) {
						$Page=$_GET['Page'];
						
						// echo $ShowPostFrom;
						if ($Page==0||$Page<1) {
							$ShowPostFrom=0;
						}else{
							$ShowPostFrom=($Page*5)-5;
						}
						$ViewQuery="SELECT * FROM admin_panel ORDER BY datetime Desc LIMIT $ShowPostFrom,5";


					}else{
						$ViewQuery="SELECT * FROM admin_panel ORDER BY datetime Desc LIMIT 0,5";
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
				 	<div class="post"><?php echo substr($Post,0,300)."......"; ?></div>
				 	<a href="FullPost.php?Id=<?php echo $Postid; ?>"><span class="btn btn-info readMore">Read More &rsaquo;&rsaquo;</span></a>
				 </div>

				 <?php } ?>
				
						<nav>
							<ul class="pagination ">
					<?php 
						if (@$_GET['Page']>1) {	?>
							<li class=><a href="Blog.php?Page=<?php echo @$_GET['Page']-1; ?>">Back</a></li>

					<?php	}

					 ?>
				 <?php 
							global $ConnectionDB;
							global $Connection;
							$QueryTotalPost="SELECT COUNT(*) FROM admin_panel";
							$ExecuteTotalPost=mysqli_query($Connection,$QueryTotalPost);
							$DataRowsPost=mysqli_fetch_array($ExecuteTotalPost);
							$TotalPost=array_shift($DataRowsPost);
							$NoPage=$TotalPost/5;
							$NoPage=ceil($NoPage);
							for($i=1;$i<=$NoPage;$i++){
								if ($i==@$_GET['Page']) {	?>
										
									<li class="active"><a href="Blog.php?Page=<?php echo $i; ?>">Page <?php echo $i; ?></a></li>

							<?php	}else{	?>
								
								<li><a href="Blog.php?Page=<?php echo $i; ?>">Page <?php echo $i; ?></a></li>

						<?php
							}

						} ?>
							<?php 
								if (isset($_GET['Page'])) { 

									 if ($_GET['Page']+1<=$NoPage) { ?>

								<li class=><a href="Blog.php?Page=<?php echo @$_GET['Page']+1; ?>">Next</a></li>
							
						<?php
									
								}
								}



							?>
								
						

							</ul>

						</nav>
				<!-- </div> -->
			</div>
			<!-- Ending of main Area -->
			<div  class="col-sm-offset-1 col-sm-3 sidearea">
				<!-- Starting of Side Area -->
				<!-- <div style="box-shadow: 0px 0px 20px black; padding: 30px; background-color: rgba(0,0,0,0.4); text-align: justify;"> -->
				<h2 >About Me</h2><hr>
				<img class="img-responsive img-circle aboutIcon pull-center" src="image/about.png" alt=""><hr>
				<p >
					Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, 
					
				</p>
				<hr>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Categories</h2>
					</div>
					<div class="panel-body ">
						
				<?php 
					global $ConnectionDB;
					global $Connection;
		
					$ViewQuery="SELECT * FROM category ORDER BY datetime desc";
					$ExecuteQuery=mysqli_query($Connection,$ViewQuery);
					while($DataRows=mysqli_fetch_array($ExecuteQuery)){

						$id=$DataRows['id'];
						$CategoryName=$DataRows['name'];
					 ?>
						<a href="Blog.php?Category=<?php echo $CategoryName; ?>"><span class="btn btn-warning"  id="title"><?php echo $CategoryName.'<br>'; ?></span><hr></a>
					<?php } ?>

					</div>
				</div>
				<hr>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Recent Post</h2>
					</div>
					<div class="panel-body">
						<?php 
							global $ConnectionDB;
							global $Connection;
							$ViewQuery="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
							$ExecuteQuery=mysqli_query($Connection,$ViewQuery);
							while($DataRows=mysqli_fetch_array($ExecuteQuery)){

								$id=$DataRows['id'];
								$Date_Time=$DataRows['datetime'];
								$Title=$DataRows['title'];
								$Category=$DataRows['category'];
								$Image=$DataRows['image'];
			
						 ?>
						 	<div>
						 		<a href="FullPost.php?Id=<?php echo $id; ?>">
						 		<img class="img-circle " src="uploads/<?php echo htmlentities($Image);?>" height=70; width=70; alt="">
								<span class="pull=-right" id="title"><?php echo $Title; ?></span><br>
								<span id="title"><?php echo substr($Date_Time,0,11); ?></span><hr>
								</a>
							</div>
						<?php } ?>
					</div>

				</div>
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