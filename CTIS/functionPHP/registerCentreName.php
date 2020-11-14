<?php
session_start();
if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
  // no username and usertype
  header("Location: http://localhost/CTIS");//back to login page
}
if(!($_SESSION['userType'] == 'Manager')){
    echo '<script>alert("You don\'t have permission to access this page");window.location.href="index.html";</script>';
}
$oldCentreID = $_SESSION['centreID'];

//generate new centreID to replace the old temparory centreID
$cName = ucwords($_POST['cName']);
$expression = "/[a-zA-Z\s]{5,50}/";//at least 6 characters, maximum is 50

if(!preg_match($expression,$cName)){
  echo '<script>alert("This name is invalid. Aplhabet Only. 6-50 Characters!.");</script>';
  echo'<script>history.go(-1);</script>';
  exit();
}

$centreID = substr($cName,0,3);
$centreID = $centreID.substr($cName,-1);
for($i=0;$i<4;$i++){
    $centreID = $centreID . rand(0,9);
}
$centreID = strtoupper($centreID);
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

$sql = "UPDATE test_centre SET centreID = '$centreID',centreName = '$cName' WHERE ". 'centreID = \'' .$oldCentreID .'\'';
if ($conn->query($sql) === TRUE) {//update test centre name successfully
  echo "Record updated successfully";
  $_SESSION['centreID'] = $centreID;//replace the session centreID with new centreID
  header("Location: http://localhost/ctis/testReport.php");
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>