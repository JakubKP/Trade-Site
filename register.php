<?php
session_start();
if (isset($_SESSION["user_id"])) {
    include 'includes/headerlogged.php';
} else {
    include 'includes/header.php';
}
?>
<div class="registerform">
    <?php if (!isset($_SESSION["user_id"])) : ?>
        <form action="requests/process-signup.php" method="POST" id="signup" novalidate>
            <div>
                <label for="name">Name</label>
                <input type="text" spellcheck="false" id="name" name="name" maxlength="12">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" maxlength="20">
            </div>
            <div>
                <label for="password_confirmation">Repeat password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" maxlength="20">
            </div>
            <button>Register</button>
        </form>
    <?php else : ?>
        <div class="alreadylogged">Your logged</div>
    <?php endif; ?>
</div>
</main>
<script src="scripts/scripts.js"></script>
</body>

</html>