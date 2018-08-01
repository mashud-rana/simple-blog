<?php
ob_start();
session_start();
$_SESSION['name'] = "admin";
session_destroy(); 
header('location:login.php');
?>