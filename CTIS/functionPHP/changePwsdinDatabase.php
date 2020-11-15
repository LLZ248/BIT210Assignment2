<?php
session_start();
if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
    // no username and usertype
    header("Location: http://localhost/CTIS");//back to login page
  }
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ctis";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if($_SESSION['userType'] == 'Patient'){
    $sql = "SELECT patPwsd FROM patient WHERE patUsername ="."'".$_SESSION['userID']."'";
    $type = "patPwsd";
}else{
    $sql = "SELECT officerPwsd FROM centre_officer WHERE officerID ="."'".$_SESSION['userID']."'";
    $type = "officerPwsd";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    if($row[$type] == $_POST['OldPwsd']){
        echo "correct password";break;
    }else{
        echo '<script>alert("Wrong Password");window.history.back();</script>';exit();
    }
  }
} else {
    echo '<script>alert("Invalid User");window.history.back();</script>';exit();
}
$newPwsd = $_POST['NewPwsd'];
if($_SESSION['userType'] == 'Patient'){
    $sql = "UPDATE patient SET patPwsd='$newPwsd' WHERE patUsername ="."'".$_SESSION['userID']."'";
}else{
    $sql = "UPDATE centre_officer SET officerPwsd='$newPwsd' WHERE officerID ="."'".$_SESSION['userID']."'";
}

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Password Updated.");location.replace("http://localhost/ctis/");</script>';exit();
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>