<?php
session_start();
unset($_SESSION['userType']);
unset($_SESSION['userID']);
header("Location: http://localhost/CTIS");
?>