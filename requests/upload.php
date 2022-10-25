<?php
session_start();
if (!(isset($_SESSION["user_id"]))) {
    die("Please log in");
}
if (isset($_POST["submit"]) && isset($_FILES['my_image'])) {
    $mysqli = require __DIR__ . "/database.php";
    $img_name = $_FILES["my_image"]['name'];
    $img_size = $_FILES["my_image"]['size'];
    $tmp_name = $_FILES["my_image"]['tmp_name'];
    $error = $_FILES["my_image"]['error'];

    if ($error === 0) {
        if ($img_size > 125000) {
            $em = "Sorry, your file is too large.";
            die($em);
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = realpath(dirname(getcwd())) . '/avatars/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                $sql = "UPDATE users SET image='$new_img_name' WHERE id = {$_SESSION["user_id"]}";
                mysqli_query($mysqli, $sql);
                header("Location: /php-site/roulette/settings.php");
            } else {
                $em = "You can't upload files of this type";
                die($em);
            }
        };
    } else {
        $em = "unknown error occured!";
        die($em);
    };
};
