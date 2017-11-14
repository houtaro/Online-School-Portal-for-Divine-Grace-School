<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Online School Portal </title>
	<?php include "inc/navbar.php"; ?>
</head>
<body class="hold-transition fixed skin-green layout-top-nav">
	<div class="wrapper">
		<?php if ($userType == "teacher") { include "inc/emp_navbar.php"; }else if ($userType == "registrar") { include "inc/registrar_navbar.php"; }else{ include "inc/parent_navbar.php"; } ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1> Dashboard - <small><?php if ($userType == "teacher") { echo "Teacher"; }else if ($userType == "registrar") { echo "Registrar"; }else if ($userType == "registrar") { echo "Parent"; } ?></small> </h1>
			</section>
			<section class="content">
				<div class="row">
					<div class="col-md-3">
						<div class="box box-success">
							<div class="box-body">
								<img class="center-block profile-img img-responsive img-circle" src="<?php echo $profile_pic; ?>" alt="User profile picture">
								<h2 class="profile-username text-center"><b><?php echo $name; ?></b></h2>
								<h4 class="text-center"><?php echo $userType; ?></h4>
								<center>
									<button style="margin-bottom:8px;" class="btn btn-primary" data-toggle="modal" data-target="#changepicmodal">Change Profile Picture</button><br>
									<button class="btn btn-success" data-toggle="modal" data-target="#changepassmodal">Change Password</button>
								</center>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title"><img src="images/chat.png" width="24" height="24"> <b>Compose post</b></h3>
							</div>
							<div class="box-body">
								<form action="crud_function.php" method="post">
									<div class="input-group">
										<textarea name="txtpost" class="form-control" placeholder="What's on your mind, <?php echo $user_rows['fname']; ?>?"></textarea>
										<span class="input-group-btn">
											<button style="height:50px;" type="submit" name="btn_post" id="btn_post" class="btn btn-primary btn-flat">Post</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<?php 
						$qpost = mysqli_query($con, "SELECT * FROM posttbl order by id desc")or die (mysqli_error($con));
						while ($rowpost = mysqli_fetch_array($qpost)) {
							$quser = mysqli_query($con, "SELECT * FROM usertbl where id='".$rowpost['postby']."'")or die (mysqli_error($con));
							$rowu = mysqli_fetch_array($quser);
							?>
							<div class="box box-success">
								<form id="formpost" action="crud_function.php" method="post">
									<input type="hidden" name="delpost" value="1">
									<input type="hidden" name="postid" id="postid">
									<div class="box-header with-border">
										<?php  if ($sessionid == $rowu['id']) { ?>
										<button type="button" onclick="deletepost('<?php echo $rowpost['id']; ?>')" id="btn_delpost" name="btn_delpost" class="btn btn-danger pull-right">Delete</button>
										<?php } ?>
										<div class="user-block">
											<img class="img-circle" src="<?php echo $rowu['profile_pic']; ?>" alt="User Image">
											<span class="username"><a> <?php echo $rowu['fname']." ".$rowu['lname']; ?></a></span>
											<span class="description"><?php echo $rowpost['dateupload']; ?></span>
										</div>
									</div>
								</form>
								<div class="box-body">
									<h4><?php echo $rowpost['message']; ?></h4>
								</div>
							</div>
							<?php } ?>
						</div>

						<div class="col-md-3">
							<div class="box box-success">
								<div class="box-header with-border">
									<h3 class="box-title"><img src="images/megaphone.png" width="24" height="24"> <b>Announcement</b></h3>
								</div>
								<div class="box-body">
									<?php 
									$query = mysqli_query($con, "SELECT * FROM announcement order by id desc limit 5")or die(mysqli_error($con));
									if(mysqli_num_rows($query) > 0){
										?>
										<ul class="products-list product-list-in-box">
											<?php while ($rowa = mysqli_fetch_array($query)) { ?>
											<li class="item">
												<div class="product-img">
													<img src="images/<?php echo $rowa['image']; ?>" alt="Product Image">
												</div>
												<div class="product-info">
													<a class="product-title"><?php echo $rowa['title']; ?></a>
													<span class="product-description">
														<?php echo $rowa['description']; ?>"
													</span>
												</div>
											</li>
											<?php } ?>
										</ul>
										<?php }else { echo "<div class='alert alert-'>No announcement added.</div>"; } ?>
									</div>
									<div class="box-footer text-center">
										<a href="all_announcement.php" class="uppercase">View All Announcements</a>
									</div>
								</div>

								<div class="box box-success">
									<div class="box-header with-border">
										<h3 class="box-title"><img src="images/Calendar.png" width="24" height="24"> <b>Events</b></h3>
									</div>
									<div class="box-body">
										<?php 
										$query = mysqli_query($con, "SELECT * FROM event_tbl order by id desc limit 5")or die(mysqli_error($con));
										if(mysqli_num_rows($query) > 0){
											?>
											<ul class="products-list product-list-in-box">
												<?php while ($rowa = mysqli_fetch_array($query)) { ?>
												<li class="item">
													<div class="product-img">
														<img src="images/<?php echo $rowa['image']; ?>" alt="Product Image">
													</div>
													<div class="product-info">
														<a class="product-title"><?php echo $rowa['title']; ?></a>
														<span class="product-description">
															<?php echo $rowa['descript']; ?>
														</span>
														<small><?php echo $rowa['dateupload']; ?></small>
													</div>
												</li>
												<?php } ?>
											</ul>
											<?php }else { echo "<div class='alert alert-'>No event added.</div>"; } ?>
										</div>
										<div class="box-footer text-center">
											<a href="all_events.php" class="uppercase">View All Events</a>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>

				</div>
				<?php include "inc/script.php"; ?>
				<?php include "inc/modal.php"; ?>
				<script>
					function deletepost(id){
						var conf = confirm("Are you sure you want to delete this post?");
						if (conf == true) {
							$("#postid").val(id);
							$("#formpost").submit();
						}
					}
				</script>
			</body>
			</html>
