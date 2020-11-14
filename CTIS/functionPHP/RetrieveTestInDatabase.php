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
$targetID = $_GET['targetID'];
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

$sql = "SELECT testID,testDate,test.patUsername,patPwsd,patName,patType,symptoms,resultDate,result,status FROM test,patient WHERE centreID = '".$_SESSION['centreID']."' AND test.patUsername = patient.patUsername AND testID ='$targetID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $testID = $row['testID'];
      $testDate = $row['testDate'];
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
      if ($patResult === null) $patResult = 'null';
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
          echo 'completed';exit();//the test is already completed, return completed as error code 
      }
      echo "$testID|$testDate|$patUsername|$patPwsd|$patName|$patType|$symptoms|$resultDate|$patResult|$status";
  }
} else {//no such test
  echo "";
}
$conn->close();
?>