<?php


require_once('inc/config/constants.php');
require_once('inc/config/db.php');

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

            header('location:index.php');
         }
      }
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





   <div class="container">
      <div class="row justify-content-center">
         <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
               <a class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo_.png" alt="">
                  <span class="d-none d-lg-block"> Department of Information and Communication Technology </span>
               </a>
            </div><!-- End Logo -->

            <div class="card">
               <div class="card-header">
                  <div class="pt-1 pb-0.5">
                     <h5 class="card-title text-center pb-0 fs-4">Register</h5>
                     <p class="text-center small">Enter your details to create admin account</p>
                  </div>
               </div>

               <div class="card-body">
                  <form class="row g-3 needs-validation" action="" method="post" enctype="multipart/form-data">
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

                     <div class="form-group col-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                     </div>

                     <div class="form-group col-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                     </div>
                     <div class="form-group col-12">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                     </div>
                     <div class="form-group col-12">
                        <label for="pass">Confirm Password</label>
                        <input type="password" class="form-control" id="pass" name="cpass">
                     </div>
                     <div class="form-group col-12">
                        <label for="user_type">User Role</label>
                        <select class="form-select col-md-5" name="user_type" aria-label="Default select example">
                           <option selected value="admin">Admin</option>
                        </select>
                     </div>
                     <div class="form-group col-12">
                        <label for="image">Upload Profile Picture</label>
                        <input type="file" name="image" accept="image/jpg, image/png, image/jpeg">
                     </div>



                     <button type="submit" value="register now" name="submit" class="btn btn-primary">Register</button>

                     <div class="col-12">
                        <p class="small mb-0">Already have an account? <a href="index.php">Login</a></p>
                     </div>

                  </form>
               </div>
            </div>

         </div>
      </div>
   </div>





</body>

</html>