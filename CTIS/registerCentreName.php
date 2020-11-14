<?php
session_start();
$oldCentreID = $_SESSION['centreID'];

//generate new centreID to replace the old temparory centreID
$cName = $_POST['cName'];
$centreID = substr($cName,0,3);
$centreID = $centreID.substr($cName,-1);
for($i=0;$i<4;$i++){
    $centreID = $centreID . rand(0,9);
}
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
if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
  $_SESSION['centreID'] = $oldCentreID;//replace the old centreID with new centreID
  echo '<script>alert("The test centre is updated\nName:'.$cName.'\nTestCentreID:'.$centreID.'");</script>';
  echo '<script>window.location.href="testReport.php";</script>';
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>