<?php
session_start();

if (isset($_SESSION["user_id"])) {
    include 'includes/headerlogged.php';
} else {
    include 'includes/header.php';
};
?>
<div class="roulette">
    <div class="roulettewheel">
        <div id="spinner"></div>
        <div id="spinnermask">
            <div class="timer">Next roll starts in <span id="spinnertimer">20</span> seconds...</div>
        </div>
        <div id="roulettepointer"></div>
    </div>
    <div class="roulettehistory"></div>
    <div class="placebet">
        <input type="number" placeholder="bet amount">
        <button>Clear</button>
        <button>+10</button>
        <button>+100</button>
        <button>+1000</button>
        <button>+10000</button>
        <button>X2</button>
        <button>1/2</button>
        <button>MAX</button>
    </div>
    <div class="roulettebets">
        <div class="redbet">
            <button class="betbutton">BET</button>
            <div class="usertotalbet">
                <div>Your total bet:<span>0</span><img src="images/usdc.png"></div>
            </div>
            <div class="usersbets"></div>
        </div>
        <div class="greenbet">
            <button class="betbutton">BET</button>
            <div class="usertotalbet">
                <div>Your total bet:<span>0</span><img src="images/usdc.png"></div>
            </div>
            <div class="usersbets"></div>
        </div>
        <div class="blackbet">
            <button class="betbutton">BET</button>
            <div class="usertotalbet">
                <div>Your total bet:<span>0</span><img src="images/usdc.png"></div>
            </div>
            <div class="usersbets">
                <div id="livebets"></div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>