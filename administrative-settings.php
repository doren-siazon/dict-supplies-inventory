<?php
session_start();
// Redirect the user to login page if he is not logged in.
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:index.php');
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');



if (isset($_POST['submit'])) {

	$name = $_POST['name'];
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_STRING);
	$user_type = $_POST['user_type'];
	$user_type = filter_var($user_type, FILTER_SANITIZE_STRING);
	$pass = md5($_POST['pass']);
	$pass = filter_var($pass, FILTER_SANITIZE_STRING);
	$cpass = md5($_POST['cpass']);
	$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

	$image = $_FILES['image']['name'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_size = $_FILES['image']['size'];
	$image_folder = 'uploaded_img/' . $image;

	$select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
	$select->execute([$email]);

	if ($select->rowCount() > 0) {
		$message[] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp User Already Exist!</div>';
	} else {
		if ($pass != $cpass) {
			$message[] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Password not matched!</div>';
		} elseif ($image_size > 2000000) {
			$message[] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Image size is too larged!</div>';
		} else {
			$insert = $conn->prepare("INSERT INTO `users`(name, email, user_type, password, image) VALUES(?,?,?,?,?)");
			$insert->execute([$name, $email, $user_type, $cpass, $image]);
			if ($insert) {
				move_uploaded_file($image_tmp_name, $image_folder);
				$message[] = '<div class="alert alert-primary"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Registered Sucessfully!</div>';
			}
		}
	}
}
?>



<link rel="stylesheet" href="assets/css/image.css">

<body>
	<?php
	require 'inc/navigation-admin.php';
	?>
	<!-- Page Content -->
	<div class="container-fluid">



		<div class="row">
			<div class="col-lg-12">
				<div class="tab-content" id="v-pills-tabContent">


					<div class="tab-pane show active" id="v-pills-administrative" role="tabpanel" aria-labelledby="v-pills-administrative-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Administrative Settings
								<a href="admin_page.php" class="btn btn-success btn-md" role="button" aria-pressed="true" style="float:right"><i class="bi bi-house-door-fill"></i>&nbsp;Back to Home</a>
							</div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#addusersTab">Add Users</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#update-list">User List</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#reports-list">User Report</a>
									</li>

								</ul>

								<div class="tab-content">
									<!-- Add New User -->
									<div class="tab-content">
										<div id="addusersTab" class="container-fluid tab-pane active">
											<div class="card-body">
												<form action="" method="post" enctype="multipart/form-data">
													<?php
													if (isset($message)) {
														foreach ($message as $message) {
															echo '
																	<div class="message">
																	<span>
																	' . $message . '
																	</span>
																	</div>
																	';
														}
													}
													?>
													<div class="container">
														<div class="wrapper">
															<div class="image">
																<img id="output_image" alt="" />
															</div>
															<br>
															<div class="content">
																<div class="icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
																<div class="text">No, File chosen, yet!</div>
															</div>
															<div id="cancel-btn"><i class="bi bi-file-excel"></i></div>
															<div class="file-name">File name here!</i></div>
														</div> <br>
														<input type="file" name="image" accept="image/jpg, image/png, image/jpeg" onchange="preview_image(event)">
													</div>


													<div class="form-row">
														<div class="form-group col-6">
															<label for="user_type">User Role</label>
															<select class="form-select col-md-5" name="user_type" aria-label="Default select example">
																<option selected value="user">User</option>
																<option value="admin">Admin</option>
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col-6">
															<label for="name">Name</label>
															<input type="text" class="form-control" id="name" name="name">
														</div>
														<div class="form-group col-6">
															<label for="pass">Password</label>
															<input type="password" class="form-control" id="pass" name="pass">
														</div>
														<div class="form-group col-6" style="place-align: center">
															<label for="email">Email</label>
															<input type="email" class="form-control" id="email" name="email">
														</div>

														<div class="form-group col-6">
															<label for="pass">Confirm Password</label>
															<input type="password" class="form-control" id="cpass" name="cpass">
														</div>

														<button type="submit" value="register now" name="submit" class="btn btn-primary">Add User</button> &nbsp;&nbsp;
														<button type="reset" id="usersClear" class="btn">Clear</button>



													</div>
												</form>
											</div>
										</div>
										<!-- USER LIST -->
										<div id="update-list" class="container-fluid tab-pane fade"><br><br>
											<div id="usersDetailsMessage"></div>

											<?php
											$select_profile = $conn->prepare("SELECT * FROM users WHERE id");
											$select_profile->execute();
											$fetch_profile = $select_profile->fetchAll(PDO::FETCH_ASSOC);
											?>




											<table class="table table-bordered table-striped">
												<thead>
													<th>ID</th>
													<th>User Name</th>
													<th>Password</th>
													<th>User Type</th>
													<th>Actions</th>
												</thead>
												<tbody id="myTable">
													<?php foreach ($fetch_profile as $profile) { ?>
														<tr>
															<td><?= $profile['id']; ?></td>
															<td><?= $profile['name']; ?></td>
															<td><?= $profile['email']; ?></td>
															<td><?= $profile['user_type']; ?></td>
															<td>
																<a href="profile_settings.php?profile=<?= $profile['id']; ?>" class="btn btn-primary btn-sm">Update</span></a>
																<!-- <a href="admin_page.php?delete<?= $profile['id']; ?>" onClick="return confirm('Do you really want to remove this record?');" class="btn btn-danger btn-sm">Delete</span></a> -->
																<button type="button" name="deleteusersButton" class="btn btn-danger" data-profile="<?= $profile['id']; ?>">Delete</button>

															</td>

														</tr>
													<?php } ?>





												</tbody>
											</table>

										</div>

										<div id="reports-list" class="container-fluid tab-pane fade">
											<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button>

											<div class="card-body">
												<br>
												<div class="table-responsive" id="usersReportsTableDiv"></div>
											</div>
										</div>


									</div>


								</div>

							</div>
						</div>
					</div>




				</div>



			</div>
		</div>
	</div>
	<?php
	require 'inc/footer.php';
	?>

	<?php
	require 'inc/footer.php';
	?>

</body>

</html>