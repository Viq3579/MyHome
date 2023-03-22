<?php
    session_start();
    if(!isset($_SESSION["email"])) {
        header("Location: signup.html");
        exit();
    }
?>

