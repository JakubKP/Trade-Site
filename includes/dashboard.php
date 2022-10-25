<div class="dashboard">
    <div class="chart">
        <div class="info">
            <div>
                Your crypto:
            </div>
            <div>
                <div><img src="images/bitcoin.png"></div>
                <div><?php echo $user["btc"]; ?> - BTC</div>
            </div>
            <div>
                <div><img src="images/ethereum.png"></div>
                <div><?php echo $user["eth"]; ?> - ETH</div>
            </div>
            <div>
                <div><img src="images/hex.png"></div>
                <div><?php echo $user["hex"]; ?> - HEX</div>
            </div>
            <div>
                <div><img src="images/usdc.png"></div>
                <div><?php echo $user["usdc"]; ?> - USDC</div>
            </div>
        </div>
        <div class="percentinfo">
            <div>
                Value in %
            </div>
            <div>
                <div class="box"></div>
                <div id="btcp">20%</div>
            </div>
            <div>
                <div class="box"></div>
                <div id="ethp">10%</div>
            </div>
            <div>
                <div class="box"></div>
                <div id="hexp">55%</div>
            </div>
            <div>
                <div class="box"></div>
                <div id="usdcp">15%</div>
            </div>
        </div>
        <div id="cryptovalue">Your total crypto value: <div id="cryptovaluenumber"></div>
        </div>
    </div>
</div>