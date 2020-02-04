<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>

<?php
if (isset($_POST['signup'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'MatNumber'    => 'required|alpha_numeric|max_len,10|min_len,10',
  'fname'        => 'required|alpha_space|max_len,30|min_len,3',
  'lname'        => 'required|alpha_space|max_len,30|min_len,3',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
  
));
$gump->filter_rules(array(
  'MatNumber' => 'trim|sanitize_string',
  'fname'     => 'trim|sanitize_string',
  'lname'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  ));
  $validated_data = $gump->run($_POST);
  $check = 0;
  if($validated_data === false) {
    $check = 1;
    ?>
    <center><font color="red" > <?php $error = $gump->get_readable_errors(true); ?> </font></center>
    <?php

  }else if ($_POST['password'] !== $_POST['repassword']) 
{
  echo  "<center><font color='red'>Passwords do not match </font></center>";
}else {
  $matno = $validated_data['MatNumber'];
  $email = $validated_data['email'];
  $checkusername = "SELECT * FROM students WHERE matno = '$matno' OR email = '$email'";
  $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
  $countusername = mysqli_num_rows($run_check); 
  if ($countusername > 0 ) {
    $error = '<center><font color="red">Account Already Exist!</font></center>';
}else {
  $fname = $validated_data['fname'];
  $lname = $validated_data['lname'];
  $email = $validated_data['email'];
  $pass = $validated_data['password'];
  $password = password_hash("$pass" , PASSWORD_DEFAULT);
  $matno = $_POST['MatNumber'];
  $level = $_POST['level'];
  $gender = $_POST['gender'];

  $query = "INSERT INTO students(fname,lname,email,matno,gender,level,pass)
       VALUES ('$fname', '$lname', '$email', '$matno', '$gender', '$level','$password')";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) { 
        echo "<script>alert('SUCCESSFULLY REGISTERED');
        window.location.href='index.php';</script>";
}
else {
  echo "<script>alert('An Error Occured Try Again!');</script>";
}

}
}
}

?>


<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <center><font color="red" > <?php if(isset($_POST['signup']) && $check == 1){ echo $error; } ?> </font></center>
              <form class="user" method="POST" action="">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name" name="fname" required="" value="<?php if(isset($_POST['signup'])) { echo $_POST['fname']; } ?>">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name" name="lname" required="" value="<?php if(isset($_POST['signup'])) { echo $_POST['lname']; } ?>">
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" required="" value="<?php if(isset($_POST['signup'])) { echo $_POST['email']; } ?>">
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Matriculation Number" name="MatNumber" min="10" max="10" required="" value="<?php if(isset($_POST['signup'])) { echo $_POST['MatNumber']; } ?>">
                  </div>

                <div class="col-sm-6">
                   
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password" required="">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="confirm_password" placeholder="Repeat Password" name="repassword" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <select class="form-control" name="level" required="">
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                  <select class="form-control" name="gender" required="">
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    </select>
                  </div>
                </div>
                <input type="submit" name="signup" value="Register Account" class="btn btn-primary btn-user btn-block">
                
                <hr>
                
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.php">Forgot Password?</a>
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
  <?php include 'inc/footer.php';?>