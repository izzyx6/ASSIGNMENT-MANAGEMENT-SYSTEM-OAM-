<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>


<?php
session_start();
if (isset($_SESSION['id'])){
  echo "<script>window.location.href= 'index.php';</script>";
}

if (isset($_POST['login'])) {
  $username  = $_POST['username'];
  $password = $_POST['pass'];
  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM students WHERE matno = '$username' OR email = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $matno = $row['matno'];
    $pass = $row['pass'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $level = $row['level'];
    $role = $row['role'];
    if (password_verify($password, $pass )) {
     $_SESSION['id'] = $id;
     $_SESSION['matno'] = strtoupper($matno);
     $_SESSION['fname'] = strtoupper($fname);
     $_SESSION['lname'] = strtoupper($lname);
     $_SESSION['email']  = $email;
     $_SESSION['level'] = $level;
     $_SESSION['role'] = $role;
      header('location: dashboard/'); 
    }else {
        echo "<script>alert('Invalid Username/Password');
        window.location.href= 'index.php';</script>";

    }
  }
}elseif (mysqli_num_rows($result) == 0){
  $username  = $_POST['username'];
  $password = $_POST['pass'];
  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM users WHERE email = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];

    $pass = $row['pass'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $role = $row['role'];
    if (password_verify($password, $pass )) {
     $_SESSION['id'] = $id;
   
     $_SESSION['fname'] = strtoupper($fname);
     $_SESSION['lname'] = strtoupper($lname);
     $_SESSION['email']  = $email;
     $_SESSION['role'] = $role;
      header('location: dashboard/'); 
    }else {
        echo "<script>alert('Invalid Username/Password');
        window.location.href= 'index.php';</script>";

    }
  }
}else{
  $username  = $_POST['username'];
  $password = $_POST['pass'];
  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM admin WHERE email = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $pass = $row['pass'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $role = $row['role'];
    if (password_verify($password, $pass )) {
     $_SESSION['id'] = $id;

     $_SESSION['fname'] = strtoupper($fname);
     $_SESSION['lname'] = strtoupper($lname);
     $_SESSION['email']  = $email;
     $_SESSION['role'] = $role;
      header('location: dashboard/'); 
    }else {
        echo "<script>alert('Invalid Username/Password');
        window.location.href= 'index.php';</script>";

    }
  }
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
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" method="POST" action="">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" name="username" placeholder="Enter Email Address..." required="">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="pass" placeholder="Password" required="">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <input type="submit" value="Login" name="login" class="btn btn-primary btn-user btn-block">
                     
                    <hr>
                    
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Create an Account!</a>
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