<?php
session_start();
if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
  // no username and usertype
  header("Location: http://localhost/CTIS");//back to login page
}
if(!($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
  echo '<script>alert("You don\'t have permission to access this page");</script>';
  header("Location: http://localhost/ctis");
}


$targetPatName = $_GET['inputpatname'];
$targetPatUname = strtoupper($_GET['inputpatuname']);
$targetPatPwsd = $_GET['inputpatpwsd'];
$targetPatType = $_GET['selectpattype'];
$targetPatSymptoms = $_GET['inputsymptoms'];
date_default_timezone_set("Asia/Kuala_Lumpur");//Set to malaysia time zone
$testDate = date("Y-m-d H:i:s");

echo $targetPatUname.'<br>';
echo $targetPatPwsd.'<br>';
echo $targetPatName.'<br>';
echo $targetPatType.'<br>';
echo $targetPatSymptoms.'<br>';
echo $testDate.'<br>';



if(str_replace(' ', '', $targetPatUname) == "" || str_replace(' ', '', $targetPatPwsd) == "" || str_replace(' ', '', $targetPatName) == "" || str_replace(' ', '', $targetPatType) == "" || str_replace(' ', '', $targetPatSymptoms) == ""){
    //empty variables passed
    echo'<script>alert("There is an empty variable!")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

//validate the patient Username
$targetPatUname = preg_replace('/\s/', '', $targetPatUname);//remoce spaces
if(!preg_match('/^[a-zA-Z0-9]{8}$/',$targetPatUname)){
    echo'<script>alert("Patient Username should be only alpahbets and numbers, excatly 8 letters!")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

//validate the patient Password
$targetPatPwsd = preg_replace('/\s/', '', $targetPatPwsd);//remoce spaces
if(!preg_match('/^\S{6,25}$/',$targetPatPwsd)){
    echo'<script>alert("Patient Password should be only 6-25 letters!")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

//Validate the patient name
$targetPatName = preg_replace('/\s+/', ' ', $targetPatName);//remoce multiple spaces and replace with only one space
if(!preg_match('/^[a-zA-Z\s]{5,50}$/',$targetPatName)){
    echo'<script>alert("Patient Name should be only alpahbets, 5-50 letters, No number!")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

//Validate the patient type
$targetPatType = preg_replace('/\s/', '', $targetPatType);//remoce spaces
if(!preg_match('/^[1-5]$/',$targetPatType)){
    echo'<script>alert("Patient type should be 1 digit number")</script>';
    echo'<script>history.go(-1)</script>';exit();
}else{
    $targetPatType = intval($targetPatType);//change it to int type
}

//Validate the patient symptoms
$targetPatSymptoms = preg_replace('/\s+/', ' ', $targetPatSymptoms);//remoce multiple spaces and replace with only one space
if(strlen($targetPatSymptoms) > 100){
    echo'<script>alert("Word limit is 100 letters!")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

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
$sql = 'SELECT patName,patUsername,patPwsd FROM patient WHERE patUsername = "'.$targetPatUname.'";';
$result = $conn->query($sql);
if ($result->num_rows > 0) {//The patient is an existing patient in the system
    while($row = $result->fetch_assoc()){
        if ($targetPatName != $row['patName']){//mismatch name(maybe duplicate username)
            echo '<script>alert("Mismatched Patient Name!\nOr give another patient usename");</script>';echo'<script>history.go(-1)</script>';exit();
        }
        if($targetPatPwsd != $row['patPwsd']){//mismatch password
            echo '<script>alert("Mismatched Patient Password!");</script>';echo'<script>history.go(-1)</script>';exit();
        }
        //generate test ID
        // T + first and last two alphabets of the username + date
        //example, username: OACP5419, date = 2020/4/24
        // T + OA + 19 + 20 + 04 + 24
        //TOA19200424
        
        $testID = "T";
        $testID =  $testID . substr($targetPatUname,0,2);
        $testID =  $testID . substr($targetPatUname,-2,2);
        $testID =  $testID . substr($testDate,2,2);
        $testID =  $testID . substr($testDate,5,2);
        $testID =  $testID . substr($testDate,8,2);
        $sql = "INSERT INTO test (testID, testDate, patType,symptoms,status,patUsername,centreID)
        VALUES ('$testID', '$testDate', '$targetPatType','$targetPatSymptoms',0,'$targetPatUname'," ."'". $_SESSION['centreID'] .  "');";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("New record created successfully")</script>';
            header("Location: http://localhost/ctis/testReport.php");
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}else{//The patient is a new patient
    //generate test ID
    // T + first and last two alphabets of the username + date
    //example, username: OACP5419, date = 2020/4/24
    // T + OA + 19 + 20 + 04 + 24
    //TOA19200424
    
    $testID = "T";
    $testID =  $testID . substr($targetPatUname,0,2);
    $testID =  $testID . substr($targetPatUname,-2,2);
    $testID =  $testID . substr($testDate,2,2);
    $testID =  $testID . substr($testDate,5,2);
    $testID =  $testID . substr($testDate,8,2);
    $sql = "INSERT INTO patient(patName,patUsername,patPwsd) VALUES ('$targetPatName','$targetPatUname','$targetPatPwsd');";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully<br>";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql = "INSERT INTO test (testID, testDate, patType,symptoms,status,patUsername,centreID)
    VALUES ('$testID', '$testDate', '$targetPatType','$targetPatSymptoms',0,'$targetPatUname'," ."'". $_SESSION['centreID'] .  "');";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("New record created successfully")</script>';
        header("Location: http://localhost/ctis/testReport.php");
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>