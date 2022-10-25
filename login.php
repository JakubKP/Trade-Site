<?php
session_start();
if (isset($_SESSION["user_id"])) {
    include 'includes/headerlogged.php';
} else {
    include 'includes/header.php';
}
$is_invalid = false;
if (!isset($_SESSION["user_id"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mysqli = require __DIR__ . "/requests/database.php";

        $sql = sprintf("SELECT * FROM users WHERE name = '%s'", $mysqli->real_escape_string($_POST["name"]));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($_POST["password"], $user["password_hash"])) {

                session_start();

                session_regenerate_id();

                $_SESSION["user_id"] = $user["id"];

                header("Location: index.php");
                exit;
            }
        }
        $is_invalid = true;
    }
}
?>
<div class="loginform">
    <?php if (!isset($_SESSION["user_id"])) : ?>
        <form method="POST">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST["name"] ?? "") ?>">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <?php if ($is_invalid) : ?>
                <em>Invalid login</em>
            <?php endif; ?>
            <button>Login</button>
        </form>
    <?php else : ?>
        <div class="alreadylogged">Your logged</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>