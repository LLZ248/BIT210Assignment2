﻿<!doctype html>
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
    <link rel="icon" type="image/png" sizes="192x192" href="icon/android-icon-192x192.png">
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
  include('config.php');
  {
  if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
    // no username and usertype
    header("Location: http://localhost/CTIS");//back to login page
  }
  if(!($_SESSION['userType'] == 'Manager')){
      echo '<script>alert("You don\'t have permission to access this page");window.location.href="index.html";</script>';
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
        <div class="dropdown">
          <figure class="my-0">
            <img src="picture/user.png" alt="user" width = 50 class="ml-5"/>
          </figure>
          <button class="btn dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
              echo $_SESSION['userID'];
              echo '('.$_SESSION['centreID'].')';
            ?>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownUser">
            
            <a class="dropdown-item" href="functionPHP/changePassword.php">Change Password</a>
            <form class="dropdown-item"  action="functionPHP/logout.php">  
            <button type="submit" class="btn btn-danger">Log Out</button>
            </form>
          </div>
        </div>        
    </div>
</nav>
   <div class="display-4 text-center text-white bg-primary">Test Kits</div>
    <div class="fluid-container">
        <br>
        <div class="d-flex justify-content-center">
            <a class="btn btn-success" href="addTestkit.php">Add Testkit</a>
        </div>
        <hr />
        <table id="tk-table" class="table table-striped table-bordered bg-light">
            <thead>
                <tr id="tk-table-header">
                    <th class="sortable-attribute" onclick="sortTableTK(0)">ID</th>
                    <th class="sortable-attribute" onclick="sortTableTK(1)">Name</th>
                    <th class="sortable-attribute" onclick="sortTableTK(2)">Stock</th>
                    <th class="unsortable-attribute">Update</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php 
            $id = $_SESSION['centreID'];
            $sql = "SELECT * from test_centre_testkit tct, testkit tk where tct.kitID = tk.kitID and centreID=:id";
            $query = $dbh -> prepare($sql);
            $query->bindParam(':id',$id,PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0)
            {
            foreach($results as $result)
            {               
            ?>
            <tr>
                <td><?php echo htmlentities($result->kitID);?></td>
                <td><?php echo htmlentities($result->testName);?></td>  
                <td><?php echo htmlentities($result->availableStock);?></td>  
                <td><a class="btn btn-success" href="updateTestkit.php?id=<?php echo htmlentities($result->kitID);?>">Update</a></td>
       
            </tr>
    </tbody><?php }} ?>
          
        </table>
    </div>
    <div class="container m-5">
        <br>
    </div>
<?php
if(($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
  //Hide the unavailable pages for tester and show the pages if manager in the navbar
  echo '<script>var userType = "'.$_SESSION['userType'].'";showManagerPages(userType);</script>';
}
?>

<!--CTIS Footer-->
<footer class="fluid-container text-center ctis-footer fixed-bottom bg-dark text-white">
    &copy;Covid Testing Information Center 2020
    <p class="mx-auto"><a href="contact.html" class="text-white float-left">Contact Us</a><a class="text-white float-right" href="#">Back to top</a></p>
</footer>

</body>
</html>
<?php } ?> 