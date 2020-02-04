<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>

<?php 
    if(isset($_SESSION['id'])){
     $session_id = $_SESSION['id']; 
     if(isset($_GET['level'])){    
      $level = $_GET['level'];
     $query = "SELECT * FROM submittedassignment WHERE student_id = '$session_id' ORDER BY upload_date ASC";
     } if(isset($_GET['id'])){    
      $assignment_id = $_GET['id'];
     $query = "SELECT * FROM submittedassignment WHERE assignment_id = '$assignment_id' ORDER BY upload_date ASC";
     }elseif($_SESSION['role'] == 'lecturer'){
      $query = "SELECT student_id,assignment_id,upload_date FROM submittedassignment";
     }elseif($_SESSION['role'] == 'student'){
      $query = "SELECT * FROM submittedassignment";
     }
    }

    if (isset($_GET['del'])) {
      $del = mysqli_real_escape_string($conn, $_GET['del']);
      $del_query = "DELETE FROM submittedassignment WHERE id = '$del'";
      $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
          echo "<script>alert('Deleted Successfully');
          window.location.href='submitted-assignment.php';</script>";
      }
      else {
       echo "<script>alert('error occured.try again!');</script>";   
      }
    }
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
<?php if ($_SESSION['role'] !== 'student'){echo '
        <div class="row">
          <!-- Page Heading -->
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary border-bottom-primary shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                                 
                      <a href="view-assignment.php?level=400" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">100 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-pen fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info border-bottom-info shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">                      
                      <a href="view-assignment.php?level=400" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">200 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-pen fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success border-bottom-success  shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">                      
                      <a href="view-assignment.php?level=400" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">300 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-pen fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-secondary border-bottom-secondary  shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">                      
                      <a href="view-assignment.php?level=400" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">400 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-pen fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>
            
            </div>';}?>

          <!-- Page Heading -->

         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="m-0 font-weight-bold text-primary" href="submitted-assignment.php">Submitted Assignments</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <?php if($_SESSION['role'] == 'student'){
                     echo '
                    <th>Title</th>
                   
                        <th>Level </th>
                        <th>Deadline</th>
                        <th>Submited on</th>
                        <th>Action</th>
                        ';}else{
                          echo '
                    <th>Mat No</th>
                        <th>Course</th>
                        <th>Student Level</th>
                        <th>Deadline</th>
                        <th>Submited on</th>
                      
                        ';
                        }
                        
                        ?>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                 
            $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
            if ($result = mysqli_num_rows($run_query) > 0) {
            while ($row = mysqli_fetch_array($run_query)) {
              if ($_SESSION['role'] == 'student'){
                $del_id = $row['id'];
                $student_id = $row['student_id'];
                $assignment_id = $row['assignment_id'];
                $answer = $row['answer'];
                $upload_date = $row['upload_date'];
                
                $querynew = "SELECT * FROM assignment WHERE id = '$assignment_id'";                
                $run_querynew = mysqli_query($conn, $querynew) or die(mysqli_error($conn));
                if ($resultnew = mysqli_num_rows($run_querynew) > 0) {
                  while ($row = mysqli_fetch_array($run_querynew)) {
                  $file_name = $row['file_name'];                 
                  $course = $row['course'];
                  $level = $row['level'];                 
                  $deadline = $row['deadline'];
                  $status = $row['status'];
              
              }
            }


              }else{
                $assignment_id = $row['assignment_id'];
                $student_id = $row['student_id'];
                $upload_date = $row['upload_date'];
                $query = "SELECT * FROM assignment";
                $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                if ($result = mysqli_num_rows($run_query) > 0) {
                while ($row = mysqli_fetch_array($run_query)) {
                  $check_ass_id = $row['id'];
                  $check_uploader_id = $row['file_uploader_id'];
                  $session_id;

               
                  $file_name = $row['file_name'];                 
                  $course = $row['course'];
                  $level = $row['level'];                 
                  $deadline = $row['deadline'];
                  $status = $row['status'];

                  $query = "SELECT * FROM students WHERE id = '$student_id'";
                  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                  if ($result = mysqli_num_rows($run_query) > 0) {
                  while ($row = mysqli_fetch_array($run_query)) {
                    
                    $matno = $row['matno'];
                    $student_level = $row['level']; 
                
                }

              }
            }
          }

          }
            
                

                    echo "<tr>";
                    if($_SESSION['role'] == "student"){
                      echo "<td>$file_name</td>";
                    
                      echo "<td>$level</td>";}else{
                        echo "<td>".$matno."</td>";
                        echo "<td>".strtoupper($course)."</td>";
                        echo "<td>$student_level</td>";
                      }
                      echo "<td>$deadline</td>";
                      echo "<td>$upload_date</td>";
                      if($_SESSION['role'] == "student"){
                      echo ' <td>';
                      
                      if ($status == '1'){ echo '<a href="submit-assignment?edit_id='.$del_id.'" class="btn btn-primary">'; }else{
                        echo '<a href="#" class="btn btn-secondary">';
                      }
                       echo  '<i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                         Edit
                      </a>';

                      if ($status == '1'){ echo ' <a href="?del='.$del_id.'" class="btn btn-danger">';}else{
                        echo '<a href="#" class="btn btn-secondary">';
                      }
                   
                        echo '<i class="fas fa-times fa-sm fa-fw mr-2 text-gray-400" ></i>
                        Delete
                      </a>
                      </div>
                     </td>';}

                    echo "</tr>"; 
                    
            }
          }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include "inc/footer.php";  ?>