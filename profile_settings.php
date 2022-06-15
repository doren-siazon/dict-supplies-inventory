<?php

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');
session_start();
// Redirect the user to  page if he is not logged in.
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:index.php');
}

if (isset($_POST['update'])) {

	$id = $_POST['id'];
	$id = filter_var($id, FILTER_SANITIZE_STRING);
	$name = $_POST['name'];
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_STRING);
	$user_type = $_POST['user_type'];
	$user_type = filter_var($user_type, FILTER_SANITIZE_STRING);


	$update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, user_type = ? WHERE id = ?");
	$update_profile->execute([$name, $email, $user_type, $id]);

	$old_image = $_POST['old_image'];
	$image = $_FILES['image']['name'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_size = $_FILES['image']['size'];
	$image_folder = 'uploaded_img/' . $image;

	if (!empty($image)) {

		if ($image_size > 2000000) {
			$message[] = 'image size is too large';
		} else {
			$update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
			$update_image->execute([$image, $id]);

			if ($update_image) {
				move_uploaded_file($image_tmp_name, $image_folder);
				unlink('uploaded_img/' . $old_image);
				$message[] = '';
				$message[] = '<div class="alert alert-success">&nbsp Image has been updated!</div>';
			}
		}
	}

	$new_pass = md5($_POST['new_pass']);
	$new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
	$confirm_pass = md5($_POST['confirm_pass']);
	$confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

	if (!empty($new_pass) || !empty($confirm_pass)) {
		if ($new_pass != $confirm_pass) {
			$message[] = '<div class="alert alert-primary"><button type="button" class="close" data-dismiss="alert">&times;</button> &nbsp Confirm password not matched!</div>';
		} else {
			$update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
			$update_password->execute([$confirm_pass, $id]);
			$message[] = '<div class="alert alert-primary"> &nbsp Password has been Updated!</div>';
		}
	}
}
?>

<?php
$profile_id = $_GET['profile'];
$select_profile = $conn->prepare("SELECT * FROM users WHERE id = ? ");
$select_profile->execute([$profile_id]);
$profile_fetch = $select_profile->fetch(PDO::FETCH_ASSOC);
// print_r($fetch_profile);
?>



<link rel="stylesheet" href="assets/css/style.css">

<body>
	<?php
	require 'inc/navigation-admin.php';
	?>




	<section class="update-profile-container">


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

			<img src="uploaded_img/<?= $profile_fetch['image']; ?>" alt="" width="250" height="250" class="rounded-circle">
			<div class="flex">
				<div class="inputBox">
					<span>Name : </span>
					<input type="hidden" name="id" value="<?= $profile_fetch['id']; ?>" hidden>

					<input type="text" name="name" required class="box" value="<?= $profile_fetch['name']; ?>">
					<span>Email : </span>
					<input type="email" name="email" required class="box" value="<?= $profile_fetch['email']; ?>">
					<span>User Role : </span>
					<input type="text" name="user_type" required class="box" value="<?= $profile_fetch['user_type']; ?>" title="Type new user role (Admin or User)">
				</div>
				<div class="inputBox">
					<span>Profile Picture : </span>
					<input type="hidden" name="old_image" value="<?= $profile_fetch['image']; ?>">
					<input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
					<span>New Password :</span>
					<input type="password" class="box" name="new_pass" placeholder="Enter new password">
					<span>Confirm Password :</span>
					<input type="password" class="box" name="confirm_pass" placeholder="Confirm new password">
				</div>
			</div>
			<div class="flex-btn">
				<input type="submit" value="update profile" name="update" class="btn">
				<a href="admin_page.php" class="option-btn">Home</a>
			</div>
		</form>

	</section>
	<?php
	require 'inc/footer.php';
	?>

</body>

</html>