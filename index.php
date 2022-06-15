<?php

require_once('inc/config/constants.php');
require_once('inc/config/db.php');

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select->execute([$email, $pass]);
   $row = $select->fetch(PDO::FETCH_ASSOC);

   if($select->rowCount() > 0){

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_id'] = $row['id'];
         header('location:user_page.php');

      }else{
		 $message[] = '<div class="alert alert-danger"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp No user found!</div>';

      }
      
   }else{
	  $message[] = '<div class="alert alert-danger"><i class="fas fa-times" onclick="this.parentElement.remove();"></i> &nbsp Incorrect Email or Password!</div>';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login </title>
  <meta content="" name="description">
  <meta content="" name="keywords">
 
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">
    <!-- Favicons -->
  <link href="assets/img/fav.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/login.css" rel="stylesheet">


</head>
<body>

   


	<!-- Default Page Content (login form) -->
    <div class="container">
      <div class="row justify-content-center">
	      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

	 	 	      <div class="d-flex justify-content-center py-4">
              <a class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo_.png" alt="">
                <span class="d-none d-lg-block"> Department of Information and Communication Technolgy </span>
              </a>
            </div><!-- End Logo -->

          <div class="card">
            <div class="card-header">
              <div class="pt-1 pb-0.5">
                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                <p class="text-center small">Enter your credentials to login</p>
              </div>
            </div>

            <div class="card-body">
              <form class="row g-3 needs-validation" action="" method="post" enctype="multipart/form-data">
                <?php
                if(isset($message)){
                  foreach($message as $message){
                    echo '
                    <div class="message">
                      <span>'.$message.'</span>
                    </div>
                    ';
                  }
                }
                ?>
                <div class="form-group col-12">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group col-12">
                  <label for="pass">Password</label>
                  <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
                
                <div class="col-12">
                    <p class="small mb-0">Dont have an account? <a href="register.php">Register now</a></p>
                </div>
			       </form>
			      </div>
		      </div>

		    </div>
      </div>
    </div>





</body>
</html>