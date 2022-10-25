<?php
session_start();

if (isset($_SESSION["user_id"])) {
    include 'includes/headerlogged.php';
} else {
    include 'includes/header.php';
}
?>
<div class="exchangepanel">
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
    <div class="exchangemenu">
        <div class="chartexchange">
            <div class="info">
                <div>
                    Your crypto:
                </div>
                <div>
                    <div><img src="images/bitcoin.png"></div>
                    <div id="bitcoin"><?php echo $user["btc"]; ?> - BTC</div>
                </div>
                <div>
                    <div><img src="images/ethereum.png"></div>
                    <div id="ethereum"><?php echo $user["eth"]; ?> - ETH</div>
                </div>
                <div>
                    <div><img src="images/hex.png"></div>
                    <div id="hex"><?php echo $user["hex"]; ?> - HEX</div>
                </div>
                <div>
                    <div><img src="images/usdc.png"></div>
                    <div id="usdc"><?php echo $user["usdc"]; ?> - USDC</div>
                </div>
            </div>
            <form id="tradeform">
                <div class="amount">
                    <p>Enter amonut:</p>
                    <input id="amountnumber" type="number" value="0" step="any" name="amountvalue" min="0">
                    <button id="max">MAX</button>
                </div>
                <div id="buginfo"></div>
                <div class="drop-list">
                    <div class="from">
                        <p>Send</p>
                        <div class="select-box">
                            <img id="fromimg" src="images/bitcoin.png">
                            <select id="fromlist" onchange="changeImage()" name="fromselect">
                                <option selected value="bitcoin">BTC</option>
                                <option value="ethereum">ETH</option>
                                <option value="hex">HEX</option>
                                <option value="usdc">USDC</option>
                            </select>
                        </div>
                    </div>
                    <i id="exchangebutton" class="fa-solid fa-arrow-right-arrow-left"></i>
                    <div class="to">
                        <p>Receive</p>
                        <div class="select-box">
                            <img id="toimg" src="images/usdc.png">
                            <select id="tolist" onchange="changeImage()" name="toselect">
                                <option value="bitcoin">BTC</option>
                                <option value="ethereum">ETH</option>
                                <option value="hex">HEX</option>
                                <option selected value="usdc">USDC</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="exchangerate" class="exchange-rate">1btc = 20,000$</div>
                <button id="calculatebutton">Calculate</button>
                <button id="tradebutton">Trade</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>