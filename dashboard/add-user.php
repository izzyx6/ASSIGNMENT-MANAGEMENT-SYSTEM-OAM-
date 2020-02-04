<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>


<?php
if (isset($_POST['adduser'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'fname'        => 'required|alpha_space|max_len,30|min_len,3',
  'lname'        => 'required|alpha_space|max_len,30|min_len,3',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
  
));
$gump->filter_rules(array(
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

  }else if ($_POST['password'] !== $_POST['repassword']){
    $error =  "Passwords do not match";
  }else {
  $fname = $validated_data['fname'];
  $lname = $validated_data['lname'];
  $email = $validated_data['email'];
  $checkusername = "SELECT * FROM users WHERE email = '$email'";
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
  if ($_SESSION['role'] == 'admin'){
  $course1 = strtoupper($_POST['course1']);
  $course2 = strtoupper($_POST['course2']);
  $course3 = strtoupper($_POST['course3']);
  $course4 = strtoupper($_POST['course4']);
  }
  $gender = $_POST['gender'];

  $query = "INSERT INTO users(fname,lname,email,gender,pass,course1,course2,course3,course4)
       VALUES ('$fname', '$lname', '$email', '$gender', '$password', ' $course1',' $course2',' $course3',' $course4')";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) { 
        echo "<script>alert('NEW USER SUCCESSFULLY ADDED');
        window.location.href='view-user.php';</script>";
      }
      else {
        echo "<script>alert('An Error Occured Try Again!');</script>";
      }
    }
  }
}
$check = 0;
$confirm = 1;
if (isset($_GET['edit_id'])){
  $edit_id = $_GET['edit_id'];
  $check = 0;
  $confirm = 0;
  if ($_SESSION['role'] == 'lecturer'){
    $confirm = 1;
  $query = "SELECT * FROM users WHERE id = '$edit_id'";
}elseif($_SESSION['role'] == 'admin'){
  if(isset($_GET['user'])){
    $query = "SELECT * FROM users WHERE id = '$edit_id'";
  }else{
    $_SESSION['id'];
    $query = "SELECT * FROM admin WHERE id = '$edit_id'";
  }
   
}

  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
  if ($result = mysqli_num_rows($run_query) > 0) {
  while ($row = mysqli_fetch_array($run_query)) {
    $user_id = $row['id'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    if (($_SESSION['role'] == 'admin' && $confirm == 1 )){
    $course1 = $row['course1'];
    $course2 = $row['course2'];
    $course3 = $row['course3'];
    $course4 = $row['course4'];
    }

  }
}
}

if (isset($_POST['update'])){
  $session_id = $_SESSION["id"];
  $edit_id; 
  $check = 0;

  require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

if (!empty($_POST['password'])){
$gump->validation_rules(array(
  'fname'        => 'required|alpha_space|max_len,30|min_len,3',
  'lname'        => 'required|alpha_space|max_len,30|min_len,3',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',  
));
$gump->filter_rules(array(
  'fname'     => 'trim|sanitize_string',
  'lname'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  ));
}else{
  $gump->validation_rules(array(
    'fname'        => 'required|alpha_space|max_len,30|min_len,3',
    'lname'        => 'required|alpha_space|max_len,30|min_len,3',
    'email'       => 'required|valid_email', 
  ));
  $gump->filter_rules(array(
    'fname'     => 'trim|sanitize_string',
    'lname'     => 'trim|sanitize_string',
    'email'    => 'trim|sanitize_email',
    ));
}
  $validated_data = $gump->run($_POST);
  $check = 0;
  if($validated_data === false) {
    $check = 1;
    ?>
    <center><font color="red" > <?php $error = $gump->get_readable_errors(true); ?> </font></center>
    <?php
    }else if (!empty($_POST['password']) && ($_POST['password'] !== $_POST['repassword'])){
      $error =  "Passwords do not match";
    }else {
    $fname = $validated_data['fname'];
    $lname = $validated_data['lname'];
    $email = $validated_data['email'];
    $pass = $validated_data['password'];
    $gender = strtoupper($_POST['gender']);
    $password = password_hash("$pass" , PASSWORD_DEFAULT);
    if ($_SESSION['role'] == 'admin' && $confirm == 1){
    $course1 = strtoupper($_POST['course1']);
    $course2 = strtoupper($_POST['course2']);
    $course3 = strtoupper($_POST['course3']);
    $course4 = strtoupper($_POST['course4']);    
    }

    if(empty($password) && ($_SESSION['role'] == 'admin' && $confirm == 1)){
      
      $query = "UPDATE users SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender', course1 ='$course1', course2 ='$course2',
      course3 ='$course3', course4 ='$course4' WHERE id = '$edit_id'";
    }elseif(!empty($password) && ($_SESSION['role'] == 'admin' && $confirm == 1)){
      echo"na wa 1";
      die();
      $query = "UPDATE users SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender', pass ='$password', course1 ='$course1', course2 ='$course2',
      course3 ='$course3', course4 ='$course4' WHERE id = '$edit_id'";
    }elseif(empty($password) && ($_SESSION['role'] == 'lecturer')){
      $query = "UPDATE users SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender' WHERE id = '$edit_id'";
    }elseif(!empty($password) && ($_SESSION['role'] == 'lecturer')){
      $query = "UPDATE users SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender', pass ='$password' WHERE id = '$edit_id'";
    }elseif(empty($password) && ($_SESSION['role'] == 'admin')){
      
      $query = "UPDATE admin SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender' WHERE id = '$edit_id'";
      if(isset($_GET['user'])){
       
        $query = "UPDATE users SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender' WHERE id = '$edit_id'";
      }
    }elseif(!empty($password) && ($_SESSION['role'] == 'admin')){
     
      $query = "UPDATE admin SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender', pass ='$password' WHERE id = '$edit_id'";
         if(isset($_GET['user'])){
          $query = "UPDATE users SET fname ='$fname', lname ='$lname', email ='$email',
      gender ='$gender', pass ='$password' WHERE id = '$edit_id'";
         }
    }
    $query = mysqli_query($conn, $query) or die (mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) { 
      if($_SESSION['role'] == 'lecturer'){
        echo "<script>alert('Updated Successfully');
        window.location.href='view-profile.php';</script>";
      }else{
        echo "<script>alert('Updated Successfully');
        window.location.href='view-user.php';</script>";
      }
    }else {
     echo "<script>alert('Error Occured Try Again!');</script>";   
    }
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
                <h1 class="h4 text-gray-900 mb-4"> <?php if(isset($_GET['edit_id'])){echo 'Edit Details!';}else{
                  echo 'Add Lecturer!';
                } ?> </h1>
                
              </div>
              <h6 class="h6 text-grey-900">Personal Details</h6>
              <hr>
              <center><font color="red" > <?php if (isset($_POST['adduser']) OR $check == 1){echo $error;} ?> </font></center>
              <form class="user" method="POST" action="">
             
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" name="fname"  value = "<?php if(isset($_POST['adduser']) OR isset($_GET['edit_id'])) {
            echo $fname; } ?>" placeholder="First Name" required="">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" name="lname" value = "<?php if(isset($_POST['adduser']) OR isset($_GET['edit_id'])) {
            echo $lname; } ?>" placeholder="Last Name" required="">
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-12 mb-3">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="email" value = "<?php if(isset($_POST['adduser']) OR isset($_GET['edit_id'])) {
            echo $email; } ?>" placeholder="Email Address" required="">
                </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-6">
                  <select class="form-control" name="gender" required="">
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    </select>
                  </div>
                </div><?php if($_SESSION['role'] == 'admin' && $confirm == 1){ echo'
                <hr>
                <h6 class="h6 text-grey-900">(Allocate Course: a minimum of one, a maximum of 4!)</h6>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
           
                  <select class="form-control" name="course1" required="">
                 
                        <option value="csc110">CSC 110</option> <option value="csc111">CSC 111</option> <option value="csc120">CSC 120</option>
                    <option value="csc211">CSC 211</option> <option value="csc212">CSC 212</option> <option value="csc217">CSC 217</option>
                    <option value="csc217">CSC 217</option> <option value="csc237">CSC 237</option> <option value="csc220">CSC 220</option>
                    <option value="csc222">CSC 222</option> <option value="csc224">CSC 224</option> <option value="csc311">CSC 311</option>
                    <option value="csc312">CSC 312</option> <option value="csc333">CSC 333</option> <option value="csc313">CSC 313</option>
                    <option value="csc314">CSC 314</option> <option value="csc316">CSC 316</option> <option value="csc318">CSC 318</option>
                    <option value="csc321">CSC 321</option> <option value="csc323">CSC 323</option> <option value="csc325">CSC 325</option>
                    <option value="csc328">CSC 328</option> <option value="csc419">CSC 419</option> <option value="csc411">CSC 411</option>
                    <option value="csc413">CSC 413</option> <option value="csc418">CSC 418</option> <option value="csc421">CSC 421</option>
                    <option value="csc424">CSC 424</option> <option value="csc428">CSC 428</option> <option value="csc432">CSC 432</option>
                    <option value="csc414">CSC 414</option> <option value="csc412">CSC 412</option> <option value="csc415">CSC 415</option>
                    <option value="csc426">CSC 413</option> <option value="csc427">CSC 427</option> <option value="csc422">CSC 422</option>
                    

                    </select>
                </div>
                <div class="col-sm-6">
              
                  <select class="form-control" name="course2">
                  <option value="">None</option>
                        <option value="csc110">CSC 110</option> <option value="csc111">CSC 111</option> <option value="csc120">CSC 120</option>
                    <option value="csc211">CSC 211</option> <option value="csc212">CSC 212</option> <option value="csc217">CSC 217</option>
                    <option value="csc217">CSC 217</option> <option value="csc237">CSC 237</option> <option value="csc220">CSC 220</option>
                    <option value="csc222">CSC 222</option> <option value="csc224">CSC 224</option> <option value="csc311">CSC 311</option>
                    <option value="csc312">CSC 312</option> <option value="csc333">CSC 333</option> <option value="csc313">CSC 313</option>
                    <option value="csc314">CSC 314</option> <option value="csc316">CSC 316</option> <option value="csc318">CSC 318</option>
                    <option value="csc321">CSC 321</option> <option value="csc323">CSC 323</option> <option value="csc325">CSC 325</option>
                    <option value="csc328">CSC 328</option> <option value="csc419">CSC 419</option> <option value="csc411">CSC 411</option>
                    <option value="csc413">CSC 413</option> <option value="csc418">CSC 418</option> <option value="csc421">CSC 421</option>
                    <option value="csc424">CSC 424</option> <option value="csc428">CSC 428</option> <option value="csc432">CSC 432</option>
                    <option value="csc414">CSC 414</option> <option value="csc412">CSC 412</option> <option value="csc415">CSC 415</option>
                    <option value="csc426">CSC 413</option> <option value="csc427">CSC 427</option> <option value="csc422">CSC 422</option>
                    

                    </select>
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
               
                  <select class="form-control" name="course3">
                  <option value="">None</option>
                        <option value="csc110">CSC 110</option> <option value="csc111">CSC 111</option> <option value="csc120">CSC 120</option>
                    <option value="csc211">CSC 211</option> <option value="csc212">CSC 212</option> <option value="csc217">CSC 217</option>
                    <option value="csc217">CSC 217</option> <option value="csc237">CSC 237</option> <option value="csc220">CSC 220</option>
                    <option value="csc222">CSC 222</option> <option value="csc224">CSC 224</option> <option value="csc311">CSC 311</option>
                    <option value="csc312">CSC 312</option> <option value="csc333">CSC 333</option> <option value="csc313">CSC 313</option>
                    <option value="csc314">CSC 314</option> <option value="csc316">CSC 316</option> <option value="csc318">CSC 318</option>
                    <option value="csc321">CSC 321</option> <option value="csc323">CSC 323</option> <option value="csc325">CSC 325</option>
                    <option value="csc328">CSC 328</option> <option value="csc419">CSC 419</option> <option value="csc411">CSC 411</option>
                    <option value="csc413">CSC 413</option> <option value="csc418">CSC 418</option> <option value="csc421">CSC 421</option>
                    <option value="csc424">CSC 424</option> <option value="csc428">CSC 428</option> <option value="csc432">CSC 432</option>
                    <option value="csc414">CSC 414</option> <option value="csc412">CSC 412</option> <option value="csc415">CSC 415</option>
                    <option value="csc426">CSC 413</option> <option value="csc427">CSC 427</option> <option value="csc422">CSC 422</option>
                    

                    </select>
                </div>
                <div class="col-sm-6">
              
                  <select class="form-control" name="course4">
                  <option value="">None</option>
                        <option value="csc110">CSC 110</option> <option value="csc111">CSC 111</option> <option value="csc120">CSC 120</option>
                    <option value="csc211">CSC 211</option> <option value="csc212">CSC 212</option> <option value="csc217">CSC 217</option>
                    <option value="csc217">CSC 217</option> <option value="csc237">CSC 237</option> <option value="csc220">CSC 220</option>
                    <option value="csc222">CSC 222</option> <option value="csc224">CSC 224</option> <option value="csc311">CSC 311</option>
                    <option value="csc312">CSC 312</option> <option value="csc333">CSC 333</option> <option value="csc313">CSC 313</option>
                    <option value="csc314">CSC 314</option> <option value="csc316">CSC 316</option> <option value="csc318">CSC 318</option>
                    <option value="csc321">CSC 321</option> <option value="csc323">CSC 323</option> <option value="csc325">CSC 325</option>
                    <option value="csc328">CSC 328</option> <option value="csc419">CSC 419</option> <option value="csc411">CSC 411</option>
                    <option value="csc413">CSC 413</option> <option value="csc418">CSC 418</option> <option value="csc421">CSC 421</option>
                    <option value="csc424">CSC 424</option> <option value="csc428">CSC 428</option> <option value="csc432">CSC 432</option>
                    <option value="csc414">CSC 414</option> <option value="csc412">CSC 412</option> <option value="csc415">CSC 415</option>
                    <option value="csc426">CSC 413</option> <option value="csc427">CSC 427</option> <option value="csc422">CSC 422</option>
                    

                    </select>
                  </div>
                </div>'; }?>
                <hr>
                <h6 class="h6 text-grey-900">Password <font color="brown" > <?php if (isset($_GET['edit_id'])){echo '(Changing of password is optional!)';} ?> </font></h6>
                <div class="form-group row">

                <?php if(isset($_GET['edit_id'])){                         
                    echo ' <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="col-sm-6">
                      <input type="password" class="form-control form-control-user" id="confirm_password" name="repassword" placeholder="Repeat Password">
                    </div>
                    </div>';
                  }else{echo '
                    <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required="">
                    </div>
                    <div class="col-sm-6">
                      <input type="password" class="form-control form-control-user" id="confirm_password" name="repassword" placeholder="Repeat Password" required="">
                    </div>
                    </div>';}
                    ?>              
                
                <hr>
                <?php if(isset($_GET['edit_id'])){echo '<input type="submit" name="update" value="update" class="btn btn-info btn-user btn-block">';}else{
                  echo '<input type="submit" name="adduser" value="Add User" class="btn btn-info btn-user btn-block">';
                } ?>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php include './inc/footer.php';?>