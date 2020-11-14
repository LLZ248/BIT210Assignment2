<?php
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

$user = $_POST['userName'];
$password = $_POST['userPwsd'];
$userType = $_POST['user'];
//manger
if($userType == "Manager"){
    $sql = "SELECT officerID,officerPwsd,centreID FROM centre_officer WHERE officerID='$user' AND position=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            if ($password == $row["officerPwsd"]){
                session_start();
                $_SESSION['userType'] = 'Manager';
                $_SESSION['userID'] = $row['officerID'];
                $_SESSION['centreID'] = $row['centreID'];
                $sql2 = "SELECT centreName FROM test_centre WHERE centreID = ".'\''. $_SESSION['centreID'].'\'' ;
               
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                    echo "got result";
                    while($row2 = $result2->fetch_assoc()){
                      if($row2['centreName'] == NULL){//no centre name yet
                        header("Location: http://localhost/CTIS/registerCentre.php");break;
                      }
                      else{
                        header("Location: http://localhost/CTIS/testReport.php");
                      break;
                      }
                    }
                  }
               
              }else{//wrong password
                echo '<script>alert("Wrong password");window.history.back();</script>';
              }
        }
    } else {
        echo '<script>alert("Invalid User");window.history.back();</script>';
    }
}
//tester
if($userType == "Tester"){
    $sql = "SELECT officerID,officerPwsd,centreID FROM centre_officer WHERE officerID='$user' AND position=0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            if ($password == $row["officerPwsd"]){
                session_start();
                $_SESSION['userType'] = 'Tester';
                $_SESSION['userID'] = $row['officerID'];
                $_SESSION['centreID'] = $row['centreID'];
                header("Location: http://localhost/CTIS/testReport.php");
              }else{//wrong password
                echo '<script>alert("Wrong password");window.history.back();</script>'; 
              }
        }
    } else {
        
        echo '<script>alert("Invalid User");window.history.back();</script>';
        
    }
}
//patient
if($userType == "Patient"){
    $sql = "SELECT patUsername,patPwsd FROM patient WHERE patUsername='$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            if ($password == $row["patPwsd"]){
                session_start();
                $_SESSION['userType'] = 'Patient';
                $_SESSION['userID'] = $row['patUsername'];
                header("Location: http://localhost/CTIS/testHistory.php");
              }else{//wrong password
                echo '<script>alert("Wrong password");window.history.back();</script>'; 
              }
        }
    } else {
        echo '<script>alert("Invalid User");window.history.back();</script>';
        
    }
}

$conn->close();
exit;
?>