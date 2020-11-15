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
  if(!($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
    header("Location: http://localhost/CTIS");
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
          <button class="btn btn-inline dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
   
    <div class="text-white font-weight-bold display-4 text-center">Enter the Test ID</div>
    <form class="form-inline d-flex justify-content-center mt-2">
      <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" id="targetTestID" placeholder="TestID" required>
      </div>
      <button type="button" onclick="existingTest()" class="btn btn-primary mb-2">Submit</button>
    </form> 
    <br>
    <table id="test-table" class="table bg-white" style="max-width: 800px; margin-right: auto; margin-left: auto;">
      
      <tbody class="container">
        <tr>
          <th scope="row">TestID</th>
          <td id="testID" name="targetTestID"></td>
        </tr>
        <tr>
          <th>Date</th>
          <td id="Date"></td>
        </tr>
        <tr>
          <th>Patient Username</th>
          <td id="patUsername"></td>
        </tr>
        <tr>
          <th>Patient Name</th>
          <td id="patName"></td>
        </tr>
        <tr>
          <th>Patient Password</th>
          <td id="patPswd"></td>
        </tr>
        <tr>
          <th>Patient Type</th>
          <td id="patType"></td>
        </tr>
        <tr>
          <th>Symptoms</th>
          <td id="symptoms"></td>
        </tr>
        <tr>
          <th>Result Date</th>
          <td id="resultDate"></td>
        </tr>
        <tr>
          <th>Result</th>
          <td id="result"></td>
        </tr>
        <tr>
          <th>Status</th>
          <td id="status"></td>
        </tr>
        
  
      </tbody>
    </table>
    <div class="container m-5"><br></div>

<?php
if(($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
  //Hide the unavailable pages for tester and show the pages if manager in the navbar
  echo '<script>var userType = "'.$_SESSION['userType'].'";showManagerPages(userType);</script>';
}
?>
<script>
  //Using AJAX here
function existingTest() {
  targetID = document.getElementById("targetTestID").value;
  if (targetID != "") {
    var respond = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        respond = this.responseText;
        if (respond != ""){
          if(respond == "completed"){// error code is completed
            //the test is already completed and the user can't modify the result anymore
            alert("the Test is alreay completed!");
          }else{
            //valid respond
            respondList = respond.split("|");
            //generate the form and displaying the test details
            generateTestTableForUpdate(respondList[0],respondList[1],respondList[2],respondList[3],respondList[4],respondList[5],respondList[6],respondList[9]);
          }
        }else{
          //There is no test with this testID in the system
          //or the test is in another centre
          alert("There is no test with this test ID!");
        }
      }
    }
    xmlhttp.open("GET","functionPHP/RetrieveTestInDatabase.php?targetID="+targetID,true);
    xmlhttp.send();
  }
}

</script>

<!--CTIS Footer-->
<footer class="fluid-container text-center ctis-footer fixed-bottom bg-dark text-white">
  &copy;Covid Testing Information Center 2020
  <p class="mx-auto"><a href="contact.html" class="text-white float-left">Contact Us</a><a class="text-white float-right" href="#">Back to top</a></p>
</footer>

</body>
</html>