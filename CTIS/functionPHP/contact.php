<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ctis";

$name = $_GET['name'];
$email = $_GET['email'];
$message = $_GET['message'];
date_default_timezone_set("Asia/Kuala_Lumpur");//Set to malaysia time zone
$contactDate = date("Y-m-d H:i:s");

//simple validation of the passed variables
if(str_replace(' ', '', $name) == "" || str_replace(' ', '', $email) == "" || str_replace(' ', '', $message) == "" ){
    //empty variables passed
    echo'<script>alert("There is an empty variable!")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO contact (email, name, message,msgDate) VALUES ('$email', '$name', '$message', '$contactDate')";

if ($conn->query($sql) === TRUE) {
    echo'<script>alert("The message is sent")</script>';
    echo'<script>location.replace("http://localhost/ctis/");</script>';
} else {
    echo'<script>alert("'."Error: " . $sql . "<br>" . $conn->error.'")</script>';
    echo'<script>history.go(-1)</script>';exit();
}

$conn->close();
?>