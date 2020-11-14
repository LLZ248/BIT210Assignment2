<?php
session_start();
if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
  // no username and usertype
  header("Location: http://localhost/CTIS");//back to login page
}
if(!($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
  echo '<script>alert("You don\'t have permission to access this page");</script>';
  header("Location: http://localhost/CTIS");//back to login page
}
$targetUsername = $_GET['uname'];
//Connect to Database and append the test
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
//Check for the patient name and password if the patient is existing in the system
$sql = 'SELECT patName,patPwsd FROM patient WHERE patUsername = "'.$targetUsername.'";';
$result = $conn->query($sql);
if ($result->num_rows > 0) {//The patient is an existing patient in the system
    while($row = $result->fetch_assoc()){
        echo $row['patName'] .'|'.$row['patPwsd'];
    }
}
$conn->close();
?>