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

  //Connect to the database and retrieve test information
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CTIS";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "SELECT testID,testDate,test.patUsername,patPwsd,patName,patType,symptoms,resultDate,result,status FROM test,patient WHERE centreID = '".$_SESSION['centreID']."' AND test.patUsername = patient.patUsername";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    echo '<script>let testList = []</script>';
    while($row = $result->fetch_assoc()) {
      $testID = $row['testID'];
      $testDate = $row['testDate'];
      $testDate = str_replace(' ', ',', $testDate);
      $testDate = str_replace('-', ',', $testDate);
      $testDate = str_replace(':', ',', $testDate);
      $patUsername = $row['patUsername'];
      $patPwsd = $row['patPwsd'];
      $patName = $row['patName'];
      $patType= $row['patType'];
      /*
      Patient type
      1-returnee
      2-quarantined
      3-close contact
      4-infected
      5-suspected
      */
      switch ($patType){
        case 1:
          $patType = "returnee";break;
        case 2:
          $patType = "quarantined";break;
        case 3:
          $patType = "close contact";break;
        case 4:
          $patType = "infected";break;
        case 5:
          $patType = "suspected";break;
      }
      $symptoms = $row['symptoms'];
      $resultDate = $row['resultDate'];
      if ($resultDate != NULL){
        $resultDate = str_replace(' ', ',', $resultDate);
        $resultDate = str_replace('-', ',', $resultDate);
        $resultDate = str_replace(':', ',', $resultDate);
      }
      if ($resultDate === NULL) $resultDate = 'null';
      /*
      result
      0 - negative
      1 - positive
      */
      $patResult = $row['result'];
      if($patResult != NULL){
        switch ($patResult){
          case 0:
            $patResult = "negative";break;
          case 1:
            $patResult = "positive";break;
        }
      }
      if ($patResult == null) $patResult = 'null';
      $status = $row['status'];
      /*
      status
      0 - pending
      1 - completed
      */
      switch ($status){
        case 0:
          $status = "pending";break;
        case 1:
          $status = "completed";break;
      }
      if ($resultDate === NULL){
      echo '<script>'.'testList.push({testID:"'.$testID.'",testDate:new Date('.$testDate.'),patUserName:"'.$patUsername.'",patUserPassword:"'.$patPwsd.'",patName:"'.$patName.'",patType:"'.$patType.'",patSymptom:"'.$symptoms.'",resultDate:'.$resultDate.',result:'.$patResult.',patStatus:"'.$status.'"})'.'</script>';}
      else{
        echo '<script>'.'testList.push({testID:"'.$testID.'",testDate:new Date('.$testDate.'),patUserName:"'.$patUsername.'",patUserPassword:"'.$patPwsd.'",patName:"'.$patName.'",patType:"'.$patType.'",patSymptom:"'.$symptoms.'",resultDate: new Date('.$resultDate.'),result:"'.$patResult.'",patStatus:"'.$status.'"})'.'</script>';
      }
    }
  } else {
    echo '<script>alert("There is no test recorded yet.");</script>';
  }
  $conn->close();
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
<h1 class="text-center text-white bg-primary display-4">Test Report</h1>
  <div class="d-flex justify-content-center">
    <button class="btn btn-success px-4 my-2" data-toggle="modal" data-target="#addTestRecordModal">+ test</button>

    <div class="modal" id="test-modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title">Test Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="cotainer">
              <div class="row">
                <div class="col-5">
                  Test ID
                </div>
                <div class="col-7" id="test-modal-testId">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Test Date
                </div>
                <div class="col-7" id="test-modal-testDate">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Patient Username
                </div>
                <div class="col-7" id="test-modal-patUsername">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Patient Name
                </div>
                <div class="col-7" id="test-modal-patName">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Patient Password
                </div>
                <div class="col-7" id="test-modal-patPassword">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Patient Type
                </div>
                <div class="col-7" id="test-modal-patType">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Symptoms
                </div>
                <div class="col-7" id="test-modal-symptoms">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Result Date
                </div>
                <div class="col-7" id="test-modal-resultDate">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Result
                </div>
                <div class="col-7" id="test-modal-result">

                </div>
              </div>
              <div class="row">
                <div class="col-5">
                  Status
                </div>
                <div class="col-7" id="test-modal-status">

                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="addTestRecordModal">
      <div class="modal-dialog">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <form id="test-form" Method="GET" action="functionPHP/recordTest.php">
          <div class="modal-header">
            <h4 class="modal-title">Test Information</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
    
          <!-- Modal body -->
          <div class="modal-body">
              <div class="text-danger pb-4">*If the patient is existing patient, Type in the patient's username and proceed will auto-fill his/her name and password<br>*Every field must be filled</div>
              <div class="form-row"><small>(Patient's name first letter + last 3 letters + patient's birthday(DDMM))<br>Example: Ali Baba(B-day:25/05/1998) = AABA2505</small>
                <div class="form-group col-md-6">
                  <label for="inputpatuname">Patient Username</label>
                  <input type="text" class="form-control" id="inputpatuname" name="inputpatuname" placeholder="patient username" onfocusout="existingPatient(this.value)" pattern="[A-Z0-9]{8}" title="8 letters(Uppercase alphabets and number only)" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputpatpwsd">Password</label>
                  <input type="text" class="form-control" id="inputpatpwsd" name ="inputpatpwsd" placeholder="Password" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputpatname">Patient Name</label>
                <input type="text" class="form-control" id="inputpatname" name="inputpatname" placeholder="patient name" required>
              </div>
              <div class="form-group">
                <label for="selectpattype">Patient Type</label>
                <select class="custom-select my-1 mr-sm-2" id="selectpattype" name="selectpattype" required>
                  <option selected value="">Please Select</option>
                  <option value = 1 >suspected</option>
                  <option value = 2 >returnee</option>
                  <option value = 3 >quarantined</option>
                  <option value = 4 >close contact</option>
                  <option value = 5 >infected</option>
                </select>
              </div>
              <div class="form-group"> 
                <label for="inputsymptoms">Symptoms</label>
                <textarea class="form-control" id="inputsymptoms" name="inputsymptoms" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-success">Create</button>
              <button type="reset" class="btn btn-danger">Reset</button>
          </div>
    
        </form>
    
        </div>
      </div>
    </div>
  </div>
  
	
  <!--Table that show every tests-->
  <table id="patient-table" class="table table-striped table-bordered bg-light">
    <thead class="thead-dark">
      <tr>
        <th class="th-sm" onclick="sortTable(0)" style="cursor: pointer;">TestID
        </th>
        <th class="th-sm" onclick="sortTable(1)" style="cursor: pointer;">Date
        </th>
        <th class="th-sm" onclick="sortTable(2)" style="cursor: pointer;">Patient Username
        </th>
        <th class="th-sm" onclick="sortTable(3)" style="cursor: pointer;">Patient Name
        </th>
        <th class="th-sm">Patient Password
        </th>
        <th class="th-sm" onclick="sortTable(5)" style="cursor: pointer;">Patient Type
        </th>
        <th class="th-sm">Symptoms
        </th>
        <th class="th-sm" onclick="sortTable(7)" style="cursor: pointer;">Result Date
        </th>
        <th class="th-sm" onclick="sortTable(8)" style="cursor: pointer;">Result
        </th>
        <th class="th-sm">Status
        </th>
        <th class="th-sm">View
        </th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
  <div class="container m-5"><br></div>

<script>
  //generate the tests retrieved from the database
  generateTestTable();
</script>
<?php
if(($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
  //Hide the unavailable pages for tester and show the pages if manager in the navbar
  echo '<script>var userType = "'.$_SESSION['userType'].'";showManagerPages(userType);</script>';
}
?>
<script>
function existingPatient(str) {
  if (str != "") {
    var respond = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        respond= this.responseText;
        if (respond != ""){
        respondList = respond.split("|");
        document.getElementById("inputpatname").value = respondList[0];
        document.getElementById("inputpatpwsd").value = respondList[1];
      }
      }
    };
    xmlhttp.open("GET","functionPHP/searchExistingPatient.php?uname="+str,true);
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