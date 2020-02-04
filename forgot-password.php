<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php

  if (isset($_POST['recover'])) {
  
  $token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
  $email = mysqli_real_escape_string($conn , $_POST['email']);
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $query = "SELECT email FROM students WHERE email = '$email'";
    $run = mysqli_query($conn , $query) or die (mysqli_error($conn));
    if (mysqli_num_rows($run) > 0) {
      $query = "UPDATE students SET token = '$token' WHERE email = '$email'";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) { 
         
          echo "<script>alert('Password Reset On The Way!'); 
          window.location.href='forgot-password.php?token=".$token."&email=".$email."';       
        </script>";
       

        }

    }else{

      $query = "SELECT email FROM users WHERE email = '$email'";
      $run = mysqli_query($conn , $query) or die (mysqli_error($conn));
      if (mysqli_num_rows($run) > 0){

        $query = "UPDATE users SET token = '$token' WHERE email = '$email'";
        $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) { 
          echo "<script>alert('Password Reset On The Way!'); 
          window.location.href='forgot-password.php?token=".$token."&email=".$email."';       
        </script>";
        }
      }else{
        $query = "SELECT email FROM admin WHERE email = '$email'";
        $run = mysqli_query($conn , $query) or die (mysqli_error($conn));
        if (mysqli_num_rows($run) > 0) {
          $query = "UPDATE admin SET token = '$token' WHERE email = '$email'";
          $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
          if (mysqli_affected_rows($conn) > 0) { 
            echo "<script>alert('Password Reset On The Way!'); 
            window.location.href='forgot-password.php?token=".$token."&email=".$email."';       
          </script>";
          }
        }else{
          echo "<script>alert('Invalid email');
          window.location.href= 'forgot-password.php';</script>";
        }
      }

   }        
  }
 }

if (isset($_POST['change'])) {

    $token = $_POST['token'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $password = password_hash("$pass" , PASSWORD_DEFAULT);
    $query = "SELECT * FROM students WHERE email = '$email' AND token = '$token'";
    $run = mysqli_query($conn , $query) or die (mysqli_error($conn));
    if (mysqli_num_rows($run) > 0) {
      $query = "UPDATE students SET pass = '$password', token = '0'";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) { 
          echo "<script>alert('SUCCESSFUL!'); 
          window.location.href='index.php?successful';       
        </script>";
        }

    }else{

      $query = "SELECT * FROM users WHERE  email = '$email' AND token = '$token'";
      $run = mysqli_query($conn , $query) or die (mysqli_error($conn));
      if (mysqli_num_rows($run) > 0){

        $query = "UPDATE users SET pass = '$password',token = '0'";
        $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) { 
          echo "<script>alert('SUCCESSFUL!'); 
          window.location.href='index.php?successful';       
        </script>";
        }
      }else{
        $query = "SELECT * FROM admin WHERE  email = '$email' AND token = '$token'";
        $run = mysqli_query($conn , $query) or die (mysqli_error($conn));
        if (mysqli_num_rows($run) > 0) {
          $query = "UPDATE admin SET pass = '$password',token = '0'";
          $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
          if (mysqli_affected_rows($conn) > 0) { 
            echo "<script>alert('SUCCESSFUL!'); 
          window.location.href='index.php?successful';       
        </script>";
          }
        }else{
          echo "<script>alert('Invalid token supplied');
          window.location.href= 'forgot-password.php';</script>";
        }
      }

   }   
  }     



?>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">  <?php if(!isset($_GET['token'])){ echo'
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we"ll help you reset your password!</p>';}else{ echo '
                      <h1 class="h4 text-gray-900 mb-2">Change Password</h1>';
                    }
                    ?>
                  </div>
                  <form class="user" method="POST" action="#">
                    <div class="form-group">
                    <?php if(isset($_GET['token'])){$token = $_GET['token']; $email = $_GET['email']; echo'
                      <input type="password" class="form-control form-control-user" name="password" id="password" aria-describedby="emailHelp" placeholder="Enter Password..."required=""> <br>
                      <input type="password" class="form-control form-control-user" name="repassword" id="confirm_password" aria-describedby="emailHelp" placeholder="Enter Confirm Password..." required="">
                      <input type="text" class="form-control form-control-user" name="token" value="'.$token.'" id="password" aria-describedby="emailHelp" hidden="true">
                      <input type="text" class="form-control form-control-user" name="email" value="'.$email.'" id="confirm_password" aria-describedby="emailHelp" hidden="true" >
                      ';}else{ echo '
                      <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required="">
                      ';} ?>
                    </div>
                    <?php if(!isset($_GET['token'])){ echo'
                    <input type="submit" name="recover" value="Reset Password" class="btn btn-primary btn-user btn-block">';}else{ echo '
                      <input type="submit" name="change" value="Change Password" class="btn btn-primary btn-user btn-block">
                      ';

                    }?>

                  
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="index.php">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php include 'inc/footer.php';?>
