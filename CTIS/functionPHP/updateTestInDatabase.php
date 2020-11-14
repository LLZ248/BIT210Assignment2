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

if(!($result == 0 || $result == 1)){
    echo'<script>alert("Invalid Result");window.history.back();</script>';exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE test SET status = 1 , result = $result, resultDate ='$resultDate' WHERE testID='$targetID'";

if ($conn->query($sql) === TRUE) {
  echo '<script>alert("Record updated successfully")</script>';
  echo '<script>location.replace("http://localhost/ctis/updateTest.php");</script>';
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>