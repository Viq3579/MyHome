<?php

// Email Check
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required.");
}

// Password Check and Hash
if (empty($_POST["password"])) {
    die("Password is required.");
}
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters.");
}
if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain a lowercase letter.");
}
if (!preg_match("/[0-9]/i", $_POST["password"])) {
    die("Password must contain a number.");
}
if($_POST["password"] != $_POST["password_confirmation"]) {
    die("Passwords must match.");
}
$captcha;
if(isset($_POST['g-recaptcha-response'])){
     $captcha=$_POST['g-recaptcha-response'];
   }
if(!$captcha){
    die("Check recaptcha");
 }

// Client or Vendor Check
if (isset($_POST["type"])&& $_POST["type"] == 'Yes') {
    $user_type = "Vendor";
} else {
    $user_type = "Client";
}


// Connect to mySQL
$mysqli = require __DIR__ . "/database.php";


// Varify Email is Unique
$sql = sprintf("SELECT *
                FROM user
                WHERE email = '%s'",
            $mysqli->real_escape_string($_POST["email"]));

$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

if ($user) {
    die("Email is already taken.");
}


// Add Account to Database
$sql = "INSERT INTO user (email, password_hash, user_type)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die ("SQL Error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST['email'], $hash, $user_type);

if ($stmt->execute()) {
    session_start();
    $_SESSION['email'] = $_POST['email'];
    if ($user_type == 'Client') {
        header("Location: ../html/editprofilep2.php");
    } else if ($user_type == 'Vendor') {
        header("Location: ../html/editprofile3.php");
    }

} else {
    if ($mysqli->errno == 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
