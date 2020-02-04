<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>
<?php
$id = $_SESSION['id'];
if (isset($_SESSION['id']) && isset($_SESSION['level'])) {

  $query = "SELECT * FROM students WHERE id = '$id' ";
  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn)) ;
  if (mysqli_num_rows($run_query) > 0 ) {
  while ($row = mysqli_fetch_array($run_query)) {
  $fname = $row['fname'];
  $lname = $row['lname'];
  $email = $row['email'];
  $matno = $row['matno'];
  $level = $row['level'];
  $gender = $row['gender'];
}
}
}

if (isset($_POST['update'])) {
  require "../gump.class.php";
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST); 
  
  
  $gump->validation_rules(array(
    'fname'   => 'required|alpha_space|max_len,30|min_len,2',
    'lname'   => 'required|alpha_space|max_len,30|min_len,2',
    'email'       => 'required|valid_email',
    'matno'    => 'max_len,150',
    
    'newpassword'    => 'max_len,50|min_len,6',
  ));
  $gump->filter_rules(array(
    'fname' => 'trim|sanitize_string',
    'lname' => 'trim|sanitize_string',
    
    'newpassword' => 'trim',
    'email'    => 'trim|sanitize_email',
    'matno' => 'trim',
    ));
  $validated_data = $gump->run($_POST);
  if($validated_data === false) {
    $error = $gump->get_readable_errors(true);

  }else if (empty($_POST['newpassword'])) {
    $fname = $validated_data['fname'];
	  $lname = $validated_data['lname'];
    $useremail = $validated_data['email'];
    $matno = $validated_data['matno'];
    $level = $_POST['level'];
    $gender = $_POST['gender'];
	 
    $updatequery = "UPDATE students SET  fname = '$fname' ,lname = '$lname', email='$useremail',matno='$matno', gender='$gender',level='$level' WHERE id = '$id' " ;
    $result1 = mysqli_query($conn , $updatequery) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');
      window.location.href='view-profile.php';</script>";
    }else {
      echo "<script>alert('An error occured, Try again!');</script>";
    }
  
  }else if (isset($_POST['newpassword']) &&  ($_POST['newpassword'] !== $_POST['confirmnewpassword'])){
     $error = "New password and Confirm New password do not match";
    
  }else {
    $fname = $validated_data['fname'];
	  $lname = $validated_data['lname'];
    $useremail = $validated_data['email'];
	  $pass = $validated_data['newpassword'];
    $matno = $validated_data['matno'];
    $level = $_POST['level'];
    $gender = $_POST['gender'];
	 
      $userpassword = password_hash("$pass" , PASSWORD_DEFAULT);
    $updatequery = "UPDATE students SET  fname = '$fname' ,lname = '$lname', email='$useremail',matno='$matno', gender='$gender',level='$level', pass= '$userpassword'
		WHERE id = '$id' " ; }
    $result1 = mysqli_query($conn , $updatequery) or die(mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');
      window.location.href='view-profile.php';</script>";
    }else {
      echo "<script>alert('An error occured, Try again!');</script>";
    }
  }
  

?>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Editing Account Information!</h1>
              </div>
              <center><font color="red" > <?php if (isset($_POST['update'])){echo $error;} ?></font></center>
              <form class="user" method="POST" action="#">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" value=" <?php echo $fname?>" name="fname" placeholder="First Name" required="">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" value=" <?php echo $lname?>" name="lname" placeholder="Last Name" required="">
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-12 mb-3">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" value=" <?php echo $email?>" name="email" placeholder="Email Address" required="">
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleRepeatPassword" value=" <?php echo $matno?>" name="matno" placeholder="Matriculation Number" required="">
                  </div>

                <div class="col-sm-6">
                   
                  </div>
                </div>
           
                <div class="form-group row">
                
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="post_image">Level</label>
                  <select class="form-control" name="level" required="">
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                    </select>
                  </div>
                 
                  <div class="col-sm-6">
                  <label for="post_image">Gender</label>
                  <select class="form-control" name="gender" required="">
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    </select>
                  </div>
                </div>
                <font color="brown"> (Changing of password is optional) </font>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password" name="newpassword" placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="confirm_password" name="confirmnewpassword" placeholder="Repeat Password">
                  </div>
                </div>
                
                <input type="submit" name="update" value="Update" class="btn btn-primary btn-user btn-block">
                
                <hr>
                
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php include 'inc/footer.php';?>