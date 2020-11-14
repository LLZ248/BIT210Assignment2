<?php
session_start();
if(!isset($_SESSION['userType']) || !isset($_SESSION['userID'])) {
  // no username and usertype
  header("Location: http://localhost/CTIS");//back to login page
}
if(!($_SESSION['userType'] == 'Manager' || $_SESSION['userType'] == 'Tester')){
  echo '<script>alert("You don\'t have permission to access this page");window.location.href="index.html";</script>';
}


$targetPatName = $_GET['inputpatname'];
$targetPatUname = $_GET['inputpatuname'];
$targetPatPwsd = $_GET['inputpatpwsd'];
$targetPatType = $_GET['selectpattype'];
$targetPatSymptoms = $_GET['inputsymptoms'];

echo $targetPatUname.'<br>';
echo $targetPatPwsd.'<br>';
echo $targetPatName.'<br>';
echo $targetPatType.'<br>';
echo $targetPatSymptoms.'<br>';

if(str_replace(' ', '', $targetPatUname) == "" || str_replace(' ', '', $targetPatPwsd) == "" || str_replace(' ', '', $targetPatName) == "" || str_replace(' ', '', $targetPatType) == "" || str_replace(' ', '', $targetPatSymptoms) == ""){
    //empty variables passed
    echo'<script>alert("There is an empty variable!")</script>';
    echo'<script>history.go(-1)</script>';
}

//Validate the patient name
$targetPatName = preg_replace('/\s+/', ' ', $targetPatName);//remoce multiple spaces and replace with only one space
if(!preg_match('/^[a-zA-Z\s]{5,50}$/',$targetPatName)){
    echo'<script>alert("Patient Name should be only alpahbets, 5-50 letters only, No number!")</script>';
    echo'<script>history.go(-1)</script>';
}

?>