<?php
//log out and unset all sessions
session_start();
unset($_SESSION['userType']);
unset($_SESSION['userID']);
unset($_SESSION['centreID']);
header("Location: http://localhost/CTIS");
?>