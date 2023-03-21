<?php

if (empty($_POST["first_name"])) {
    die("First name is required.");
}

if (empty($_POST["last_name"])) {
    die("First name is required.");
}

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
$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


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
$sql = "INSERT INTO user (email, password_hash, first_name, last_name)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die ("SQL Error: " . $mysqli->error);
}

$stmt->bind_param("ssss", $_POST['email'], $hash, $_POST['first_name'], $_POST['last_name']);

if ($stmt->execute()) {
    header("Location: ../html/home.html");
} else {
    if ($mysqli->errno == 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
