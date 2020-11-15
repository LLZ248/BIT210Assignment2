<?php
session_start();
if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
    // no username and usertype
    header("Location: http://localhost/CTIS");//back to login page
    exit();
  }
  if(!($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
    header("Location: http://localhost/CTIS");exit();
  }
$result = intval($_GET['patResultRadio']);
$targetID = $_GET['testID'];
date_default_timezone_set("Asia/Kuala_Lumpur");//Set to malaysia time zone
$resultDate = date("Y-m-d H:i:s");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ctis";

if(!($result == 0 || $result == 1)){//result is neither 1 nor 0
    echo'<script>alert("Invalid Result");window.history.back();</script>';exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// the test must be pending and same centre ID as user's
$sql = "UPDATE test SET status = 1 , result = $result, resultDate ='$resultDate' WHERE testID='$targetID' AND status = 0 AND centreID = '".$_SESSION['centreID']."';";
echo $sql;
if ($conn->query($sql) === TRUE) {
  echo '<script>alert("Record updated successfully")</script>';
  echo '<script>location.replace("http://localhost/ctis/updateTest.php");</script>';
} else {//unlikely to happend unless user manually edit the page
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>