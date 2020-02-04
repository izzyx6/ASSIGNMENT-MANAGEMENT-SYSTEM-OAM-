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
}elseif(isset($_SESSION['id']) && ($_SESSION['role'] !== 'student')){

  if($_SESSION['role'] == 'lecturer'){
  $query = "SELECT * FROM users WHERE id = '$id'";
  }elseif($_SESSION['role'] == 'admin'){
  $query = "SELECT * FROM admin WHERE id = '$id'";
  }
  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn)) ;
  if (mysqli_num_rows($run_query) > 0 ) {
  while ($row = mysqli_fetch_array($run_query)) {
  $fname = $row['fname'];
  $lname = $row['lname'];
  $email = $row['email'];
  $role = $row['role'];
  $gender = $row['gender'];
  if($_SESSION['role'] == 'lecturer') {
  $course1 = $row['course1'];
  $course2 = $row['course2'];
  $course3 = $row['course3'];
  $course4 = $row['course4'];
  }
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
                <h1 class="h4 text-gray-900 mb-4">Account Information! </h1>
                
              </div>
              
              <form class="user">
              <h6 class="h6 text-gray-400 mb-4">Personal Details</h6>
              <hr>
              <h6>Names:</h6>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" value=" <?php echo $fname?>" placeholder="First Name" required="" readonly>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" value=" <?php echo $lname?>" placeholder="Last Name" required="" readonly>
                  </div>
                </div>
                <h6>Email:</h6>
                <div class="form-group row">
                <div class="col-sm-12 mb-3">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" value=" <?php echo $email?>" placeholder="Email Address" required="" readonly>
                </div>
                <div class="col-sm-6"><?php if($_SESSION['role'] == 'student'){
                   echo ' <input type="text" class="form-control form-control-user" id="exampleRepeatPassword" value="'.$matno.'"placeholder="Matriculation Number" required="" readonly>
                  </div>';}?>                
                </div>
                
                <div class="form-group row"><?php if($_SESSION['role'] == 'student'){
                  echo '   
                  <div class="col-sm-6 mb-3 mb-sm-0">
                   <select class="form-control" name="level" required="" readonly>
                   <option value="'.$level.'?>">'.$level.'</option>                   
                    </select> 
                  </div>
                  <div class="col-sm-6 ">
                  <select class="form-control" name="gender" required="" readonly>
                    <option value="'.$gender.'">'.$gender.'</option>                   
                    </select>
                  </div>
                  ';}elseif($_SESSION['role'] == 'lecturer'){
                    echo '&nbsp&nbsp&nbsp
                    <div class="col-sm-6 mb-3 mb-sm-0">
                  <select class="form-control" name="gender" required="" readonly>
                    <option value="'.$gender.'">'.$gender.'</option>                   
                    </select>
                  </div>
                    ';
                  }?>
               
               <br>
             <?php 
               if($_SESSION['role'] == 'lecturer') {?>
               
                  <h6 class="h6 text-gray-400 mb-4 btn-block">&nbsp&nbsp&nbsp&nbsp Course Allocation</h6>
                  <hr>
                  
                  <div class="form-group row">
                  
                  &nbsp&nbsp&nbsp&nbsp
                  <div class="col-sm-3 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" value="<?php echo $course1;?>" required="" readonly>
                  </div>
                  <?php if($course2 != NULL){ echo'
                  <div class="col-sm-3">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" value=" '.$course2.'" required="" readonly>
                  </div>';}?>
                  <?php if($course3 !== NULL){ echo'
                  <div class="col-sm-3">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" value=" '.$course3.'" required="" readonly>
                  </div>';}?>
                  <?php if($course4 !== NULL){ echo'
                  <div class="col-sm-3">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" value=" '.$course4.'" required="" readonly>
                  </div>';}?>
                </div><?php } ?>
                  </div>
                
                
                <hr>
                <a  class="btn btn-info btn-user" href="<?php if($_SESSION['role'] !== 'student'){ echo'add-user.php?edit_id='.$id.'';}else{echo'edit-profile.php';}?>"> Edit </a>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php include 'inc/footer.php';?>