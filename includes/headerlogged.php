<?php
if (isset($_SESSION["user_id"])) {
    $mysqli = require $_SERVER['DOCUMENT_ROOT'] . "/php-site/roulette/requests/database.php";
    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roulette</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/93927ce690.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script src="./scripts/scripts.js" defer></script>
</head>

<body>
    <header class="login">
        <?php if (isset($user)) : ?>
            <div class="username">You are logged as <?= htmlspecialchars($user["name"]) ?></div>
        <?php endif; ?>
        <section class="login">
            <div class="logo">
                <a href="/php-site/roulette/index.php"><img src="images/logo.png" alt="logo"></a>
            </div>
            <nav class="logged">
                <ul>
                    <li><a href="/php-site/roulette/roulette.php">Roulette</a></li>
                    <li><a href="/php-site/roulette/index.php">Portfolio</a></li>
                    <li><a href="/php-site/roulette/exchange.php">Exchange</a></li>
                    <li><a href="/php-site/roulette/settings.php">Settings</a></li>
                    <li><a href="/php-site/roulette/requests/logout.php">Logout</a></li>
                </ul>
            </nav>
        </section>
    </header>
    <main>
        <div class="chat">
            <div id="chatbox">
                <?php
                $query = "SELECT * FROM messages ORDER BY id DESC LIMIT 8";
                $result = mysqli_query($mysqli, $query);
                if (!(mysqli_num_rows($result) === 0)) {
                    while ($row = $result->fetch_array()) {
                        $the_rows[] = $row;
                    }
                    foreach (array_reverse($the_rows) as $row) {
                        echo "<div class='livecontent'><div class='avatar'><img src='/php-site/roulette/avatars/" . $row['image'] . "'></div><div class='livemessage'><div class='namehour'><div>" . $row["user_name"] . "</div><div>" . $row["msg_date"] . "</div></div><div>" . $row["msg"] . "</div></div></div>";
                    }
                }
                ?>
            </div>
            <form>
                <textarea name="usermsg" maxlength="75" spellcheck="false" id="usermsg"></textarea>
                <button name="submitmsg" type="submit" id="submitmsg">Send</button>
            </form>
        </div>
        <div class="chatbtn">
            <i class="fa-brands fa-rocketchat"></i>
        </div>