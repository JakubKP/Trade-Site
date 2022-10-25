<?php
session_start();
if (!(isset($_SESSION["user_id"]))) {
    die("Please log in");
};

if ($_POST["amountvalue"] <= 0) {
    die("Type amount");
};

if (preg_match("/[a-z]/i", $_POST["amountvalue"])) {
    die("Type only numbers");
};

if (!($_POST["amountvalue"][0] !== ".") && ($_POST["amountvalue"][0] !== ",")) {
    die("Invalid amount, start with 0.-");
};

$mysqli = require __DIR__ . "/database.php";
$sqln = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sqln);
$user = $result->fetch_assoc();

$fromcoinname = $_POST["fromselect"];
$tocoinname = $_POST["toselect"];
if ($fromcoinname == "bitcoin") {
    $fromcoinname = "btc";
} else if ($fromcoinname == "ethereum") {
    $fromcoinname = "eth";
};
if ($tocoinname == "bitcoin") {
    $tocoinname = "btc";
} else if ($tocoinname == "ethereum") {
    $tocoinname = "eth";
};
if ($fromcoinname == $tocoinname) {
    die("You cant trade that");
}
if ($user[$fromcoinname] < ((float)$_POST["amountvalue"])) {
    die("You dont have that much");
};

$fromcoinvalueafter = round($user[$fromcoinname] - (float)$_POST["amountvalue"], strlen($_POST["amountvalue"] - 2));

$tocoinvalueafter = $user[$tocoinname] + ($_POST["amountvalue"] * $_POST["fromcoinprice"] / $_POST["tocoinprice"]);

$sql = "UPDATE users SET $fromcoinname=$fromcoinvalueafter, $tocoinname=$tocoinvalueafter WHERE id = {$_SESSION["user_id"]}";
mysqli_query($mysqli, $sql);
