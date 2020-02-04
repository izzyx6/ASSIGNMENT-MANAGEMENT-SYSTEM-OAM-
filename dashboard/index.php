<?php include 'inc/header.php';?>
<?php include 'inc/connection.php';?>
<?php include 'inc/nav.php';?>


        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard </h1>
            
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Submit</div>
                      <a href="#" class="h5 mb-0 font-weight-bold text-gray-800" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assignment</a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Action:</div>
                      <?php if($_SESSION['role'] == 'student'){echo ' <a class="dropdown-item" href="submit-assignment.php">Submit Assignment</a>';} ?>
                      <?php if($_SESSION['role'] !== 'admin'){echo '
                      <a class="dropdown-item" href="view-assignment.php">View Assignment</a>';}?>
                      <?php if($_SESSION['role'] == 'lecturer'){echo '<a class="dropdown-item" href="upload-assignment.php">Upload Assignment </a> ';}?>
                      <div class="dropdown-divider"></div>
                   
                    </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Manage</div>
                      <a href="#" class="h5 mb-0 font-weight-bold text-gray-800" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Action:</div>
                      <?php if($_SESSION['role'] !== "student"){?>
                      <a class="dropdown-item" href="add-user.php?edit_id=<?php echo $_SESSION['id'] ?>">Edit Profile</a><?php }elseif($_SESSION['role'] == "student"){?>
                      <a class="dropdown-item" href="edit-profile.php">Edit Profile</a><?php }?>
                      <a class="dropdown-item" href="view-profile.php">View Profile</a>
                      <div class="dropdown-divider"></div>
                      
                    </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- Pending Requests Card Example -->
            <?php if($_SESSION['role'] == 'admin'){ echo '
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">manage</div>
                      
                      <a href="" class="h5 mb-0 font-weight-bold text-gray-800" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Users</a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Action:</div>
                      <a class="dropdown-item" href="add-user.php">Add Users</a>
                      <a class="dropdown-item" href="view-user">View Users</a>
                      <div class="dropdown-divider"></div>
                    
                    </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>'; }?>

            <!-- Pending Requests Card Example --> <?php if($_SESSION['role'] !== 'admin'){ echo '
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Assignment</div>
                      
                      <a href="view-assignment.php?level=100" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">100 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-secondary shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Assignment</div>
                      
                      <a href="view-assignment.php?level=200" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">200 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>

           <!-- Pending Requests Card Example -->
           <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Assignment</div>
                      
                      <a href="view-assignment.php?level=300" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">300 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-secondary shadow h-100 py-2 d-flex flex-row align-items-center justify-content-between">
              
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Assignment</div>
                      
                      <a href="view-assignment.php?level=400" class="h5 mb-0 font-weight-bold text-gray-800" role="button"  aria-haspopup="true">400 level</a>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-pen fa-2x text-gray-300"></i>
                    </div>
                    
                  </div>
                </div>
               </div>
            </div>';}?>
          </div>

       

          <!-- Content Row 

          <div class="row">

             Area Chart 
            <div class="col-xl-12 col-lg-16">
              <div class="card shadow mb-4">
                 Card Header - Dropdown 
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Calender</h6>
                  <div class="dropdown no-arrow" >
                   
                    
                    </a>
                    
                  </div>
                </div>
                Card Body 
                <div class="card-body">
                  <div class="chart-area" id="caleandar">
                
                  </div>
                </div>
              </div>
            </div>-->

       
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

            
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <?php include 'inc/footer.php';?>