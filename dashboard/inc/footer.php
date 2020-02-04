      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Department of Computer-Science 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

    <!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Do you Really Want to Delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Delete" below if you are ready to perform delete operation or select "Cancel" to stop operation.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" <?php echo 'href="?del='.$del_id.'"';?>>Delete</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/fullcalender/fullcalender.js"></script>
  <script>
  var events = [

    {'Date': new Date(2016, 6, 7), 'Title': 'Doctor appointment at 3:25pm.'},
    {'Date': new Date(2016, 6, 18), 'Title': 'New Garfield movie comes out!', 'Link': 'https://garfield.com'},
    {'Date': new Date(2016, 6, 27), 'Title': '25 year anniversary', 'Link': 'https://www.google.com.au/#q=anniversary+gifts'},
    ];var events = [
    {'Date': new Date(2016, 6, 7), 'Title': 'Doctor appointment at 3:25pm.'},
    {'Date': new Date(2016, 6, 18), 'Title': 'New Garfield movie comes out!', 'Link': 'https://garfield.com'},
    {'Date': new Date(2016, 6, 27), 'Title': '25 year anniversary', 'Link': 'https://www.google.com.au/#q=anniversary+gifts'},
    ];

    var settings = {
    Color: '',
    LinkColor: '',
    NavShow: true,
    NavVertical: false,
    NavLocation: '',
    DateTimeShow: true,
    DateTimeFormat: 'mmm, yyyy',
    DatetimeLocation: '',
    EventClick: '',
    EventTargetWholeDay: false,
    DisabledDays: [],
    ModelChange: model
    };

    var element = document.getElementById('caleandar');
    caleandar(element, events, settings);

  
  </script>

<script>
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

</script>


<?php
//auto script for updating deadline
if (isset($_SESSION['id'])){
  $today = date(" Y-m-d H:i");
  $query = "SELECT * FROM assignment";
  $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
  if ($result = mysqli_num_rows($run_query) > 0) {
  while ($row = mysqli_fetch_array($run_query)) {
     $file_id = $row['id'];
      $deadline = $row['deadline'];
      if (strtotime($deadline) < strtotime($today)){
        $querynew = "UPDATE assignment SET status ='0' WHERE id = '$file_id'";//0 for expire
        $run_querynew = mysqli_query($conn, $querynew) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
        
        }
      }       
} 
  }
/*  
  if (strtotime($deadline) < strtotime($today)){
    $querynew = "UPDATE assignment SET status ='0' WHERE id = '$file_id'";
    $run_query = mysqli_query($conn, $querynew) or die(mysqli_error($conn));
    if ($result = mysqli_num_rows($run_query) > 0) {
      while ($row = mysqli_fetch_array($run_query)) {

      }
    }
  }else{
    echo "NA WA"; die("");
  }*/
}

?>

</body>

</html>
