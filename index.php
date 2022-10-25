<?php
session_start();

if (isset($_SESSION["user_id"])) {
    include 'includes/headerlogged.php';
} else {
    include 'includes/header.php';
}
?>
<div class="login">
    <div class="prices">
        <div class="btc">
            <div><img src="images/bitcoin.png" alt="bitcoin"></div>
            <div id="pricebtc"></div>
        </div>
        <div class="eth">
            <div><img src="images/ethereum.png" alt="ethereum"></div>
            <div id="priceeth"></div>
        </div>
        <div class="hex">
            <div><img src="images/hex.png" alt="hex"></div>
            <div id="pricehex"></div>
        </div>
        <div class="usdc">
            <div><img src="images/usdc.png" alt="usdc"></div>
            <div class="price">1$</div>
        </div>
    </div>
    <?php if (isset($_SESSION["user_id"])) {
        include 'includes/dashboard.php';
    } else {
        echo '<div class="notlogged">Log in to view your balance</div>';
    }
    ?>
</div>

<?php include 'includes/footer.php'; ?>