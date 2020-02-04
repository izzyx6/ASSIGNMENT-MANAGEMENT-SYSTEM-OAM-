<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>
<?php

if (isset($_POST['upload'])){

  $course = $_POST['course'];
  $assignment_id = $_POST['id'];
  $upload_date = date("Y-m-d H:i A");

  $student_id = $_SESSION['id'];

  $file = $_FILES['file']['name'];
  $ext = pathinfo($file, PATHINFO_EXTENSION);
  $validExt = array ('pdf', 'txt', 'doc', 'docx', 'ppt' , 'zip');
  if (empty($file)) {
  echo "<script>alert('Attach a file');</script>";
  }else if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000 )
  {
  echo "<script>alert('file size is not proper');</script>";
  }
  else if (!in_array($ext, $validExt)){
  echo "<script>alert('Not a valid file');</script>";

  }else {
    $folder  = 'submitted/';
    $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
    $notefile = rand(1000 , 1000000) .'.'.$fileext;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$notefile)) {
        $query = "INSERT INTO submittedassignment(student_id, assignment_id, answer, upload_date) VALUES 
        ('$student_id', '$assignment_id', '$notefile','$upload_date')";

        $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script> alert('Assignment Submitted Successfully.');
            window.location.href='submitted-assignment.php';</script>";
        }else {
            "<script> alert('Error while uploading..try again');</script>";
        }
    }
}
}

if (isset($_GET['edit_id'])){
  $edit_id = $_GET['edit_id'];
  $query = "SELECT * FROM assignment WHERE id = '$edit_id'";

  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
  if ($result = mysqli_num_rows($run_query) > 0) {
  while ($row = mysqli_fetch_array($run_query)) {
      $file_id = $row['id'];
      $file_title = $row['file_name'];
    
      $course = $row['course'];
      $level = $row['level'];
      $status = $row['status'];

  }
}
}

if (isset($_POST['update'])){
  $session_id = $_SESSION["id"];
  $edit_id;
  $upload_date = date("Y-m-d H:i A");

    $file = $_FILES['file']['name'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $validExt = array ('pdf', 'txt', 'doc', 'docx', 'ppt' , 'zip');
    if (empty($file)) {
    echo "<script>alert('Attach a file');</script>";
    }else if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000 )
    {
    echo "<script>alert('file size is not proper');</script>";
    }
    else if (!in_array($ext, $validExt)){
    echo "<script>alert('Not a valid file');</script>";
  
    }else {
      $folder  = 'submitted/';
      $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
      $notefile = rand(1000 , 1000000) .'.'.$fileext;
      if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$notefile)) {

      $query = "UPDATE submittedassignment SET answer ='$notefile', upload_date ='$upload_date' 
      WHERE id = '$edit_id' AND student_id ='$session_id'";
      $query = mysqli_query($conn, $query) or die (mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Updated Successfully');
        window.location.href='submitted-assignment.php';</script>";
    }else {
     echo "<script>alert('error occured.try again!');</script>";   
    }
  }
}
     
  }
  if(isset($_GET['aid'])){
    $aid = $_GET['aid'];
    $query = "SELECT * FROM assignment WHERE id = '$aid'";
    $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if ($result = mysqli_num_rows($run_query) > 0) {
    while ($row = mysqli_fetch_array($run_query)) {                    
       $status = $row['status'];
       if ($status == '0'){
        echo "<script>alert('Deadline Exceeded!');
        window.location.href='view-assignment.php';</script>";
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
                <h1 class="h4 text-gray-900 mb-4">     <?php if(isset($_GET['edit_id'])){echo 'Edit Assignment!';}else{
                  echo 'Avaliable Assignment!';
                } ?></h1>
  
                <?php
                if (isset($_SESSION['level'])){
                  $session_level = $_SESSION['level'];
                  if(isset($_GET['edit_id'])){
                    $query = "SELECT * FROM submittedassignment WHERE id = '$edit_id'";
                    $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    if ($result = mysqli_num_rows($run_query) > 0) {
                    while ($row = mysqli_fetch_array($run_query)) {                    
                       $a_id = $row['assignment_id'];
                       $querynew = "SELECT * FROM assignment WHERE id = '$a_id'";
                       $run_querynew = mysqli_query($conn, $querynew) or die(mysqli_error($conn));
                       if ($resultnew = mysqli_num_rows($run_querynew) > 0) {
                         while ($row = mysqli_fetch_array($run_querynew)) {
                         $course = $row['course'];
                       }
                     }
                     
                     if(isset($_GET['edit_id'])){
                        echo '<a href="#" class="btn btn-secondary">'.strtoupper($course).'</a> ';
                     }else{
                      echo '<a href="?aid='.$file_id.'&course='.$course.'" class="btn btn-secondary">'.strtoupper($course).'</a> ';
                     }
                  
                    }
                  }else{
                    echo "<script>alert('No Asignment Given Yet!');</script>"; 
                  }

                  }else{
                    $query = "SELECT * FROM assignment WHERE level <= '$session_level' AND status = '1'";
                    $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                    if ($result = mysqli_num_rows($run_query) > 0) {
                    while ($row = mysqli_fetch_array($run_query)) {                    
                       $file_id = $row['id'];
                       $course = $row['course'];
                       $deadline = $row['deadline'];
                       
                        echo '<a href="?aid='.$file_id.'&course='.$course.'" class="btn btn-secondary">'.strtoupper($course).'</a> ';
                  
                    }
                  }else{
                    echo "<script>alert('No Asignment Given Yet!');</script>"; 
                  }
                }              
                
                 
                }

                  ?>
              </div>
             
              <form class="user" method="POST" action="" enctype="multipart/form-data">
             
                <div class="form-group row">
                  <div class="col-sm-14 mb-3">
                  <?php if(isset($_GET['aid']) && isset($_GET['course']) ){ echo'<label for="post_image">Select File</label><font color="brown">';
                  echo "(allowed file: 'pdf','doc','ppt','txt','zip' | maximum size: 30 mb)";
                 }elseif(isset($_GET['edit_id'])){  echo'<label for="post_image">Select File</label><font color="brown">';
                  echo "(allowed file: 'pdf','doc','ppt','txt','zip' | maximum size: 30 mb)";

                 } ?>
                   </font>
                <input type="file" name="file" <?php if((isset($_GET['aid']) && isset($_GET['course'])) OR isset($_GET['edit_id'])){}else{echo 'hidden="true"';}
                ?> > 
                <!--HIDDEN ID'S-->
                <input type="text" name="id" value="<?php if(isset($_GET['aid']) && isset($_GET['course'])){ echo $_GET['aid'];}elseif(isset($_GET['edit_id'])){
                  echo $_GET['edit_id'];}?>" hidden="true"> 
        
                   
                  </div>
                </div>
                
                <div class="form-group row">
                <div class="col-sm-12 mb-3">
                  <input type="text" class="form-control" name="course" id="exampleInputEmail" <?php if(isset($_GET['aid']) && isset($_GET['course'])){ $course=$_GET['course'];
                    echo 'placeholder="'.strtoupper($course).'" required="" readonly ';}else{echo 'hidden="true"';} ?> >
                  
                </div>
                </div> 
                <hr>              
                <input type="submit" name="upload" value="Submit Assignment" class="btn btn-info btn-user btn-block" <?php if(isset($_GET['aid']) && isset($_GET['course'])){}else{
                 echo 'hidden="true"';} ?> > 
                 <input type="submit" name="update" value="Update Assignment" class="btn btn-info btn-user btn-block" <?php if(isset($_GET['edit_id'])){}else{
                 echo 'hidden="true"';} ?> > 
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php include 'inc/footer.php';?>
