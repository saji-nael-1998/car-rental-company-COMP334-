<?php



session_start();
session_destroy();

if (isset($_COOKIE["user"]) && isset($_COOKIE["customerID"]) && isset($_COOKIE["pass"])) {
    setcookie("user", '', time() - (3600));
    setcookie("customerID", '', time() - (3600));
    setcookie("pass", '', time() - (3600));
}

header('location:login.php');
exit;
?>
//header("location: login.php");