<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');



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
		$message[] = '<div class="alert alert-danger"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp User Already Exist!</div>';
	} else {
		if ($pass != $cpass) {
			$message[] = '<div class="alert alert-danger"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Password not matched!</div>';
		} elseif ($image_size > 2000000) {
			$message[] = '<div class="alert alert-danger"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Image size is too larged!</div>';
		} else {
			$insert = $conn->prepare("INSERT INTO `users`(name, email, user_type, password, image) VALUES(?,?,?,?,?)");
			$insert->execute([$name, $email, $user_type, $cpass, $image]);
			if ($insert) {
				move_uploaded_file($image_tmp_name, $image_folder);
				$message[] = '<div class="alert alert-primary"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Registered Sucessfully!</div>';
			}
		}
	}
}
