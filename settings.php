<?php
session_start();

if (isset($_SESSION["user_id"])) {
    include 'includes/headerlogged.php';
} else {
    include 'includes/header.php';
}
?>
<div class="settings">
    <?php if (isset($_SESSION["user_id"])) : ?>
        <div>Your current avatar:</div>
        <div class="currentavatar"><img src='avatars/<?php echo $user["image"]; ?>'></div>
        <div>Change avatar:</div>
        <form action="requests/upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="my_image">
            <input type="submit" name="submit" value="Upload">
        </form>
    <?php else : ?>
        <div>Please log in</div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>