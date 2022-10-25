</main>
<script type="text/javascript">
    $(document).ready(function() {
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            let time = new Date();
            let timeNow = ("0" + time.getHours()).slice(-2) + ":" + ("0" + time.getMinutes()).slice(-2) + ":" + ("0" + time.getSeconds()).slice(-2);
            let data = JSON.parse(e.data);
            let html_data = "<div class='livecontent'><div class='avatar'><img src='/php-site/roulette/avatars/" + data.image +
                "'></div><div class='livemessage'><div class='namehour'><div>" + data.userName + "</div><div>" + timeNow + "</div></div><div>" + data.msg + "</div></div></div>";

            $("#chatbox").append(html_data);

            const messages = document.getElementById('chatbox');

            shouldScroll = messages.scrollTop + messages.clientHeight === messages.scrollHeight;

            if (!shouldScroll) {
                messages.scrollTop = messages.scrollHeight;
            };
        }
        let m = 0;
        $("#submitmsg").click((e) => {
            e.preventDefault();
            if ((Date.now() - m) > 3000) {
                <?php if (isset($_SESSION["user_id"])) : ?>
                    let userName = "<?php echo $user["name"]; ?>";
                    let image = "<?php echo $user["image"]; ?>"
                <?php endif; ?>
                let message = $("#usermsg").val();
                let data = {
                    userName: userName,
                    msg: message,
                    image: image
                };
                let time = new Date();
                let timeNow = ("0" + time.getHours()).slice(-2) + ":" + ("0" + time.getMinutes()).slice(-2) + ":" + ("0" + time.getSeconds()).slice(-2);
                if (message != '' && message.length < 76) {
                    conn.send(JSON.stringify(data));
                    $.ajax({
                        type: 'post',
                        url: '/php-site/roulette/requests/sendmessage.php',
                        data: {
                            'message': message,
                            'date': timeNow

                        }
                    })
                }
                document.getElementById("usermsg").value = '';
                m = Date.now();
            }
        })
        $("#usermsg").keypress(function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                if ((Date.now() - m) > 3000) {
                    e.preventDefault();
                    <?php if (isset($_SESSION["user_id"])) : ?>
                        let userName = "<?php echo $user["name"]; ?>";
                        let message = $("#usermsg").val();
                        let image = "<?php echo $user["image"]; ?>"
                    <?php endif; ?>
                    let data = {
                        userName: userName,
                        msg: message,
                        image: image
                    };
                    let time = new Date();
                    let timeNow = ("0" + time.getHours()).slice(-2) + ":" + ("0" + time.getMinutes()).slice(-2) + ":" + ("0" + time.getSeconds()).slice(-2);
                    if (message != '' && message.length < 76) {
                        conn.send(JSON.stringify(data));
                        $.ajax({
                            type: 'post',
                            url: '/php-site/roulette/requests/sendmessage.php',
                            data: {
                                'message': message,
                                'date': timeNow

                            }
                        })
                    }
                    document.getElementById("usermsg").value = '';
                    m = Date.now();
                }
            }
        });
        document.getElementById('chatbox').scrollTop = document.getElementById('chatbox').scrollHeight;
        fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cethereum%2Chex&vs_currencies=usd&include_market_cap=false&include_24hr_vol=false&include_24hr_change=false&include_last_updated_at=false").then(res => res.json()).then(data => {
            if (document.getElementById("pricebtc") !== null) {
                document.getElementById("pricebtc").textContent = `${data.bitcoin.usd.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')} $`;
                document.getElementById("priceeth").textContent = `${data.ethereum.usd} $`;
                document.getElementById("pricehex").textContent = `${data.hex.usd.toFixed(4)} $`;
            }
            <?php if (isset($_SESSION["user_id"])) : ?>
                let usdc = <?php echo $user["usdc"]; ?>;
                let btcown = <?php echo $user["btc"]; ?> * data.bitcoin.usd;
                let ethown = <?php echo $user["eth"]; ?> * data.ethereum.usd;
                let hexown = <?php echo $user["hex"]; ?> * data.hex.usd;
                let btcpercent = ((btcown / (btcown + ethown + hexown + usdc)) * 100).toFixed(2);
                let ethpercent = ((ethown / (btcown + ethown + hexown + usdc)) * 100).toFixed(2);
                let hexpercent = ((hexown / (btcown + ethown + hexown + usdc)) * 100).toFixed(2);
                let usdcpercent = ((usdc / (btcown + ethown + hexown + usdc)) * 100).toFixed(2);
                if (document.getElementById("btcp") !== null) {
                    document.getElementById("btcp").textContent = `${btcpercent}%`;
                    document.getElementById("ethp").textContent = `${ethpercent}%`;
                    document.getElementById("hexp").textContent = `${hexpercent}%`;
                    document.getElementById("usdcp").textContent = `${usdcpercent}%`;
                    document.getElementById("cryptovaluenumber").textContent = `${(btcown+ethown+hexown+usdc).toFixed(2)} $`;
                    updateChart(btcown, ethown, hexown, usdc);
                }
                if (document.getElementById("exchangerate") !== null) {
                    document.getElementById("exchangerate").textContent = `1 ${document.getElementById("fromlist").value.toUpperCase()} = ${data.bitcoin.usd} USDC`;
                    document.getElementById("max").addEventListener("click", (e) => {
                        e.preventDefault();
                        let amountField = document.getElementById("amountnumber");
                        let crypto = document.getElementById("fromlist").value;
                        if (crypto == "bitcoin") {
                            amountField.value = <?php echo $user["btc"]; ?>;
                        } else if (crypto == "ethereum") {
                            amountField.value = <?php echo $user["eth"]; ?>;
                        } else if (crypto == "hex") {
                            amountField.value = <?php echo $user["hex"]; ?>;
                        } else if (crypto == "usdc") {
                            amountField.value = <?php echo $user["usdc"]; ?>;
                        }
                    });
                }

            <?php endif; ?>
        });
        $("#tradebutton").click((e) => {
            e.preventDefault();
            let amountvalue = $("#amountnumber").val();
            let fromselect = $("#fromlist").val();
            let toselect = $("#tolist").val();
            console.log("XD")
            if (document.getElementById("amountnumber").value <= 0) {
                document.getElementById("buginfo").textContent = "Type amount";
                return;
            }
            if (!(document.getElementById("amountnumber").value[0] !== "." && document.getElementById("amountnumber").value[0] !== ",")) {
                document.getElementById("buginfo").textContent = "Invalid amount type number before digit";
                return;
            }
            fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cethereum%2Chex&vs_currencies=usd&include_market_cap=false&include_24hr_vol=false&include_24hr_change=false&include_last_updated_at=false").then(res => res.json()).then(data => {

                $.ajax({
                    type: 'post',
                    url: 'requests/trade.php',
                    data: {
                        'amountvalue': amountvalue,
                        'fromselect': fromselect,
                        'toselect': toselect,
                        'fromcoinprice': (fromselect == "usdc" ? 1 : data[fromselect].usd),
                        'tocoinprice': (toselect == "usdc" ? 1 : data[toselect].usd)
                    }
                });
            }).catch(e => console.log(e));
            document.getElementById("exchangerate").textContent = "Trading in process...";
            setTimeout(() => {
                location.href = "exchange.php";
            }, 3000);
        });
        if (!(document.getElementById("spinner") == null)) {
            const timerElement = document.getElementById('spinnertimer');
            const TIMER_DURATION = 30;

            function step() {
                const timestamp = Date.now() / 1000;
                const timeLeft = (TIMER_DURATION - 1) - Math.round(timestamp) % TIMER_DURATION;
                timerElement.innerText = timeLeft;

                const timeCorrection = Math.round(timestamp) - timestamp;
                setTimeout(step, timeCorrection * 1000 + 1000);
            };
            step();
        }
    });
</script>
</body>

</html>