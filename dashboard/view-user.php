<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>

<?php     

    if (isset($_GET['del'])) {
      $del = mysqli_real_escape_string($conn, $_GET['del']);
      $del_query = "DELETE FROM users WHERE id = '$del'";
      $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
          echo "<script>alert(' User Deleted Successfully');
          window.location.href='view-user.php';</script>";
      }
      else {
       echo "<script>alert('error occured.try again!');</script>";   
      }
    }
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800"></h1>
          <p class="mb-4">
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of All Lecturers</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email </th>
                        <th>Courses</th>
                        <th>Action</th>
                        
                    </tr>
                  </thead>
                  <tbody>

                  <?php
            $query = "SELECT * FROM users ORDER BY id DESC";  
            $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
            if ($result = mysqli_num_rows($run_query) > 0) {
            while ($row = mysqli_fetch_array($run_query)) {
                $del_id = $row['id'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $email = $row['email'];
                $course1 = $row['course1'];
                $course2 = $row['course2'];
                $course3 = $row['course3'];
                $course4 = $row['course4'];
                
                    echo "<tr>";          
                      echo "<td>$fname</td>";
                      echo "<td>$lname</td>";
                      echo "<td>$email</td>";
                      echo "<td>".$course1." ".$course2." ".$course3." ".$course4."</td>";
                   
                      echo ' <td>
                     
                     
                      <a class="btn btn-info" href="add-user?edit_id='.$del_id.'&user=0">
                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                        Edit
                      </a>

                
                      <a class="btn btn-danger" href="?del='.$del_id.'">
                   
                        <i class="fas fa-times fa-sm fa-fw mr-2 text-gray-400" ></i>
                        Delete
                      </a>
                   </td>';

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