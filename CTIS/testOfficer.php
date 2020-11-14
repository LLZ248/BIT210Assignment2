<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS & JS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- CTIS CSS & JS-->
    <link rel="stylesheet" href="CTIS.css">
    <script src="CTIS.js"></script>
    <title>CTIS</title>

    <!--Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>
<body>
<?php
  session_start();
  if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
    // no username and usertype
    header("Location: http://localhost/CTIS");//back to login page
  }
  if(!($_SESSION['userType'] == 'Manager')){
    if($_SESSION['userType'] == 'Tester'){
      echo '<script>alert("You don\'t have permission to access this page");window.location.href="testReport.php";</script>';
    }else{
      echo '<script>alert("You don\'t have permission to access this page");window.location.href="index.html";</script>';
    }
  }
  ?>
  <nav class="navbar navbar-expand-lg bg-white navbar-light">
    <!-- Brand -->
    <a class="navbar-brand" href="#"><img src="picture/CTISlogo.png" width="70" height="70" alt=""></a>


    <!-- Toggler/collapsibe Button -->

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="testReport.php">Test Report</a>
            </li>
            <li class="nav-item managerShow">
                <a class="nav-link" href="testkit.php">TestKit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="updateTest.php">Update Test</a>
            </li>
            <li class="nav-item managerShow">
              <a class="nav-link" href="testOfficer.php">Manage Tester</a>
          </li>
        </ul>
        <figure class="mr-3 mt-2">
          <img src="picture/user.png" alt="user" width = 50 class="ml-lg-5"/>
          <figcaption>
             <?php
              echo $_SESSION['userID'];
              echo '('.$_SESSION['centreID'].')';
            ?>
          </figcaption>
        </figure>
        <form action="logout.php">  
          <button type="submit" class="btn btn-danger">Log Out</button>
        </form>
        
    </div>
</nav>
  <h1 class="text-center text-white bg-primary display-4">Tester Table</h1>
  <div class="d-flex justify-content-center">
      <button class="btn btn-success px-4 my-2" data-toggle="modal" data-target="#addTestOfficerModal">Add Tester</button>
      <button class="btn btn-danger px-4 my-2 ml-5" data-toggle="modal" data-target="#removeTestOfficerModal">Remove Tester</button>
  </div><br>
  
  <div class="modal" id="addTestOfficerModal">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <form onsubmit="addTestOfficer()" id="tester-form">
        <div class="modal-header">
          <h4 class="modal-title">Tester Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputtesteruname">Username</label>
                <input type="text" class="form-control" id="inputtesteruname" placeholder="Tester Username" required>
              </div>
              <div class="form-group col-md-6">
                <label for="inputtesterpwsd">Password</label>
                <input type="text" class="form-control" id="inputtesterpwsd" placeholder="Password" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputtetsername">Tester Name</label>
              <input type="text" class="form-control" id="inputtetsername" placeholder="Tester Name" required>
            </div>
            <button type="submit" class="btn btn-success">Create</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
        </form>
        </div>
    </div>
</div>

<div class="modal" id="removeTestOfficerModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <form onsubmit="removeTestOfficer()" id="remove-tester-form">
        <div class="modal-header">
          <h4 class="modal-title">Remove Tester</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
              <div class="form-group row">
                <label class="col-4" for="inputremovetesteruname">Tester Username</label>
                <input type="text" class="form-control col-8" id="inputremovetesteruname" placeholder="Tester Username" required>
              </div>
              
            <button type="submit" class="btn btn-danger">Remove</button>
        </div>
        </form>
      </div>
    </div>
</div>
      
   
    
<table id="test-officer-table" class="table bg-white" style="max-width: 800px; margin-right: auto; margin-left: auto;">
    <thead class="thead-dark">
        <tr>
        <th onclick="sortTable(0)" style="cursor: pointer;">Username</th>
        <th>Password</th>
        <th onclick="sortTable(2)" style="cursor: pointer;">Tester Name</th>
        </tr>
        
    </thead>
    <tbody>
    </tbody>
</table>

<!--Default userType is Manager, so all pages avaible will be shown, this will be modified when PHP is applied-->
<script>
    var userType = "Manager"
    showManagerPages(userType);

    
    
    generateTestOfficerTable();
</script>
    <div class="container m-5"><br></div>



<!--CTIS Footer-->
<footer class="fluid-container text-center ctis-footer fixed-bottom bg-dark text-white">
    &copy;Covid Testing Information Center 2020
    <p class="mx-auto"><a href="contact.html" class="text-white float-left">Contact Us</a><a class="text-white float-right" href="#">Back to top</a></p>
</footer>

</body>
</html>