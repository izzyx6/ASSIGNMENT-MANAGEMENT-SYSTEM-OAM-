<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>
<?php

if (isset($_POST['upload'])){
  $check = 0;
  $date = $_POST['date'];
  $time = $_POST['time'];
  $expire = $date." ".$time; 
  $today = date("Y-m-d H:i A");

  if ( strtotime($expire) < strtotime($today)){
    echo "<script>alert('Invalid Deadline Set!');
    window.location.href='upload-assignment.php';
    </script>"; die('');
  }
  /*

  echo $expire = $_POST['date']." ".$_POST['time']; 
  echo " PHP ";
  echo  $today = date("Y-m-d H:i");

  if ($today > $expire){

  */

  require "../gump.class.php";
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST); 

  $gump->validation_rules(array(

      'title'    => 'required|max_len,300|min_len,0',
  ));
  $gump->filter_rules(array(

      'title' => 'trim|sanitize_string',
      ));
  $validated_data = $gump->run($_POST);
  $check = 0;
  if($validated_data === false) {
    $check = 1;
    $error = $gump->get_readable_errors(true); 


}else {
 
  $file_title = $validated_data['title'];
 $course = $_POST['course'];
  $upload_date = date("F j, Y");

  $level = explode("C",$course);
  $level = $level[2];
  if(($level >= "100") AND ($level <= "199")){
    $level = '100';
  }elseif(($level >= "200") AND ($level <= "299")){
    $level ='200';
  }elseif(($level >= "300") AND ($level <= "399")){
    $level = '300';
  }elseif(($level >= "400") AND ($level <= "499")){
    $level ='400';
  }
  $file_uploader_id = $_SESSION['id'];

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
    $folder  = 'uploaded/';
    $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
    $notefile = rand(1000 , 1000000) .'.'.$fileext;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$notefile)) {
        $query = "INSERT INTO assignment(file_name,file_type, file_uploader_id, level, course, file, deadline, status,upload_date) VALUES 
        ('$file_title' ,'$fileext' , '$file_uploader_id' , '$level', '$course', '$notefile', '$expire', '1','$upload_date')";

        $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script> alert('Assignment Uploaded Successfully.');
            window.location.href='view-assignment.php';</script>";
        }else {
            "<script> alert('Error while uploading..try again');</script>";
        }
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

  }
}
}

if (isset($_POST['update'])){
  $session_id = $_SESSION["id"];
  $edit_id; 
  $check = 0;
  $date = $_POST['date'];
  $time = $_POST['time'];
  $expire = $date." ".$time; 
  echo $today = date("Y-m-d H:i A");

  if ( strtotime($expire) < strtotime($today)){
    echo "<script>alert('Invalid Deadline Set!');</script>";
  }elseif (strtotime($expire) > strtotime($today)){
  /*
  echo $expire = $_POST['date']." ".$_POST['time']; 
  echo " PHP ";
  echo  $today = date("Y-m-d H:i");

  if ($today > $expire){
  */
  require "../gump.class.php";
  $gump = new GUMP();
  $_POST = $gump->sanitize($_POST); 

  $gump->validation_rules(array(
   
      'title'    => 'required|max_len,300|min_len,0',
  ));
  $gump->filter_rules(array(
    
      'title' => 'trim|sanitize_string',
      ));
  $validated_data = $gump->run($_POST);
  $check = 0;
  if($validated_data === false) {
    $check = 1;
    $error = $gump->get_readable_errors(true); 

}else {
  
  $file_title = $validated_data['title'];
  $course = $_POST['course'];
  $level = $_POST['level'];
  $upload_date = date("F j, Y");

  if (empty($file)){  
    $query = "UPDATE assignment SET file_name ='$file_title', file_uploader_id ='$session_id',
    level ='$level', course ='$course', deadline ='$expire', upload_date ='$upload_date' WHERE id = '$edit_id' AND file_uploader_id = '$session_id'";
    $query = mysqli_query($conn, $query) or die (mysqli_error($conn));
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Updated Successfully');
        window.location.href='view-assignment.php';</script>";
    }else {
     echo "<script>alert('error occured.try again!');</script>";   
    }

  }else{
    $file = $_FILES['file']['name'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $validExt = array ('pdf', 'txt', 'doc', 'docx', 'ppt' , 'zip');
    if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000 )
  {
  echo "<script>alert('file size is not proper');</script>";
  }
  else if (!in_array($ext, $validExt)){
  echo "<script>alert('Not a valid file');</script>";

  }else {
    $folder  = 'uploaded/';
    $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
    $notefile = rand(1000 , 1000000) .'.'.$fileext;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$notefile)){
      $query = "UPDATE assignment SET file_name ='$file_title',file_type ='$file_type', file_uploader_id ='$session_id',
      level ='$level', course ='$course', file ='$notefile', deadline ='$expire', upload_date ='$upload_date' WHERE id = '$edit_id'";
      $query = mysqli_query($conn, $query) or die (mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Updated Successfully');
        window.location.href='view-assignment.php';</script>";
    }else {
     echo "<script>alert('error occured.try again!');</script>";   
    }
  }
}
     
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
                  echo 'Upload Assignment!';
                } ?></h1>
                
              </div>
              <center><font color="red" > <?php if (isset($_POST['upload']) && $check == 1){echo $error;} ?> </font></center>
              <form class="user" method="POST" action="" enctype="multipart/form-data">
             
                <div class="form-group row">
                  <div class="col-sm-14 mb-3">
                  <label for="post_image">Select File</label><font color="brown"> (allowed file: 'pdf','doc','ppt','txt','zip' | maximum size: 30 mb) </font>
		            <input type="file" name="file" <?php if(isset($_GET['edit_id'])){ ;}else{ echo 'required=""';} ?> > 
                   
                  </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-12 mb-3">
                  <input type="text" class="form-control" id="exampleInputEmail" name="title" value = "<?php if(isset($_POST['upload']) OR isset($_GET['edit_id'])) {
            echo $file_title; } ?>" placeholder="Title..." required="">
                </div>
                </div>
              
                
                <label for="post_image">Deadline</label>
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                
                    <input type="date" class="form-control form-control-user" id="exampleRepeatPassword" name="date" value = "<?php if(isset($_POST['upload'])) {
            echo $date; } ?>" placeholder="Deadline" required="">
                </div>
                <div class="col-sm-6 mb-3">
                    <input type="time" class="form-control form-control-user" id="exampleRepeatPassword" name="time" value = "<?php if(isset($_POST['upload'])) {
            echo $time; } ?>" placeholder="Deadline" required="">
                </div>

                </div>
                
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="post_image">Course</label>
                  <select class="form-control" name="course" required="">
                  <?php  $session_id = $_SESSION["id"];
                  $query = "SELECT * FROM users WHERE id = '$session_id'";
                  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                  if ($result = mysqli_num_rows($run_query) > 0) {
                  while ($row = mysqli_fetch_array($run_query)) {
                     $course1 = $row['course1'];
                     $course2 = $row['course2'];
                     $course3 = $row['course3'];
                     $course4 = $row['course4'];
                      echo "<option value='".$course1."'>".$course1."</option>";
                      if($row['course2'] !== NULL){
                        echo "<option value=".$row['course2'].">".$row['course2']."</option>";
                      }elseif($row['course3'] !== NULL){
                        echo "<option value=".$row['course3'].">".$row['course3']."</option>";
                      }elseif($row['course4'] !== NULL){
                        echo "<option value=".$row['course4'].">".$row['course4']."</option>";
                      }
                  }
                }
                        
                        ?>

                    </select>
                  </div>

                </div>
           
                <hr>
                <?php if(isset($_GET['edit_id'])){echo '<input type="submit" name="update" value="update" class="btn btn-info btn-user btn-block">';}else{
                  echo '<input type="submit" name="upload" value="upload" class="btn btn-info btn-user btn-block">';
                } ?>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

<?php include 'inc/footer.php';?>
