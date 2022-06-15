<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');


if (isset($_POST['update'])) {

	$id = $_POST['id'];
	$id = filter_var($id, FILTER_SANITIZE_STRING);
	$name = $_POST['name'];
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_STRING);

	// Check if the given id is in the DB
	$idSelectSql = 'SELECT id FROM users WHERE id = :id';
	$idSelectStatement = $conn->prepare($idSelectSql);
	$idSelectStatement->execute(['id' => $id]);

	if ($idSelectStatement->rowCount() > 0) {


		$update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ?, user_type = ? WHERE id = ?");
		$update_profile->execute([$name, $email, $user_type]);

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
				$update_image->execute([$image]);

				if ($update_image) {
					move_uploaded_file($image_tmp_name, $image_folder);
					unlink('uploaded_img/' . $old_image);
					$message[] = 'image has been updated!';
				}
			}
		}

		$old_pass = $_POST['old_pass'];
		$previous_pass = md5($_POST['previous_pass']);
		$previous_pass = filter_var($previous_pass, FILTER_SANITIZE_STRING);
		$new_pass = md5($_POST['new_pass']);
		$new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
		$confirm_pass = md5($_POST['confirm_pass']);
		$confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

		if (!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)) {
			if ($previous_pass != $old_pass) {
				$message[] = '<div class="alert alert-primary"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Old password not matched!</div>';
			} elseif ($new_pass != $confirm_pass) {
				$message[] = '<div class="alert alert-primary"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Confirm password not matched!</div>';
			} else {
				$update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
				$update_password->execute([$confirm_pass]);
				$message[] = '<div class="alert alert-primary"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Password has been Updated!</div>';
			}
		}
	}
}
