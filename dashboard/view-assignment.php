<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>

<?php 
    if(isset($_SESSION['id'])){
     $session_id = $_SESSION['id']; 
     if(isset($_GET['level']) AND $_SESSION['role'] !== 'student'){    
      $level = $_GET['level'];
     $query = "SELECT * FROM assignment WHERE file_uploader_id = '$session_id' AND level = '$level' ORDER BY upload_date ASC";
     }elseif(isset($_GET['level']) AND $_SESSION['role'] == 'student'){    
      $level = $_GET['level'];
      $session_level = $_SESSION['level'];
     $query = "SELECT * FROM assignment WHERE level = '$level' AND level <= '$session_level' ORDER BY upload_date ASC";
     }elseif(isset($_SESSION['level'])){
      $session_level = $_SESSION['level'];
      $query = "SELECT * FROM assignment WHERE level <= '$session_level' AND status = '1' ORDER BY upload_date ASC";
     }else{
      $query = "SELECT * FROM assignment WHERE file_uploader_id = '$session_id' ORDER BY upload_date ASC";
     }
    }

    if (isset($_GET['del'])) {
      $del = mysqli_real_escape_string($conn, $_GET['del']);
      $del_query = "DELETE FROM assignment WHERE id = '$del' AND file_uploader_id = '$session_id' ";
      $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
          echo "<script>alert('Deleted Successfully');
          window.location.href='view-assignment.php';</script>";
      }
      else {
       echo "<script>alert('error occured.try again!');</script>";   
      }
    }
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
        
        <div class="row">
          <!-- Page Heading -->
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary border-bottom-primary shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                                 
                      <a href="?level=100" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">100 level</a>
                      
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
                      <a href="?level=200" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">200 level</a>
                      
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
                      <a href="?level=300" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">300 level</a>
                      
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
                      <a href="?level=400" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">400 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-pen fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>
            
            </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="m-0 font-weight-bold text-primary" href="view-assignment.php"><?php if(isset($_GET['level'])){echo $_GET['level']. " Assignments";}else{
                echo 'All Assignments';
              }?></a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <th>Name</th> 
                        <th>Type </th>
                        <th>Level </th>
                        <th>Uploaded on</th>
                        <th>Deadline</th>
                        <th>Action</th>
                        
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                 
            $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
            if ($result = mysqli_num_rows($run_query) > 0) {
            while ($row = mysqli_fetch_array($run_query)) {
                $del_id = $row['id'];
                $file_name = $row['file_name'];
              
                $file_type = $row['file_type'];
                $upload_date = $row['upload_date'];
                $course = $row['course'];
                $level = $row['level'];
                $file = $row['file'];
                $deadline = $row['deadline'];
                    echo "<tr>";
                      echo "<td>$file_name</td>";
                   
                      echo "<td>$file_type</td>";
                      echo "<td>$level</td>";
                      echo "<td>$upload_date</td>";
                      echo "<td>$deadline</td>";
                      if(isset($_SESSION['level'])){
                        echo ' <td>                      
                      
                      <a class="btn btn-info"  href="uploaded/'.$file.'" target="_blank">
                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                        Download
                        </a>
                        
                        <a class="btn btn-info"  href="submit-assignment?aid='.$del_id.'&course='.$course.'">
                     
                          <i class="fas fa-mark fa-sm fa-fw mr-2 text-gray-400" ></i>
                          Submit
                        </a>
                        </div>
                        
            
                      </td>                      
                        ';

                      }else{
                      echo ' <td>

                      <a class="btn-info"  href="uploaded/'.$file.'" target="_blank">
                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                        Download
                        </a>

                      <a class="btn-primary"  href="upload-assignment?edit_id='.$del_id.'">
                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                        Edit
                      </a>

                      <a class="btn-success"  href="submitted-assignment?id='.$del_id.'">
                        <i class="fas fa-sign fa-sm fa-fw mr-2 text-gray-400"></i>
                        Submission
                      </a>
                      <a class="btn-danger"  href="?del='.$del_id.'" data-toggle="modal" data-target="#deleteModal">
                   
                        <i class="fas fa-times fa-sm fa-fw mr-2 text-gray-400" ></i>
                        Delete
                      </a>
                      </div></td>';

                    echo "</tr>"; 
                      }
                    
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