<?php

if (empty($_POST["name"])) {
    die("Name is required");
}
if (strlen($_POST["name"]) < 3) {
    die("minimum 3 letters");
    print_r($_POST['name']);
}
if (strlen($_POST["name"]) > 12) {
    die("max 12 letters");
}
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}
if (strlen($_POST["password"]) > 20) {
    die("Password max symbols 20");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}


$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$image = "blank.png";
$number = 0;
$usdc = 100000;
$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO users (name, password_hash, image, btc, eth, hex, usdc) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
};

$stmt->bind_param(
    "sssdddd",
    $_POST["name"],
    $password_hash,
    $image,
    $number,
    $number,
    $number,
    $usdc
);

try {
    $stmt->execute();
    header("Location: /php-site/roulette/login.php");
    exit;
} catch (Exception $e) {
    die("Name already taken");
};
