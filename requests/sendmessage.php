<?php
session_start();

if (empty($_POST["message"])) {
    die("Type something");
}

if ((strlen($_POST["message"])) > 75) {
    die("75 words limit");
}

$mysqli = require __DIR__ . "/database.php";

$sqln = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sqln);
$user = $result->fetch_assoc();

$sql = "INSERT INTO messages (user_id, user_name, msg, msg_date, image) VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();


if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
};

$stmt->bind_param(
    "issss",
    $_SESSION["user_id"],
    htmlspecialchars($user["name"]),
    htmlspecialchars($_POST["message"]),
    htmlspecialchars($_POST["date"]),
    htmlspecialchars($user["image"])

);


$stmt->execute();
