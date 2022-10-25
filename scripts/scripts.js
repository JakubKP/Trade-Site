    document.querySelector("div.chatbtn").addEventListener("click", () => {
        let flag = document.querySelector("div.chat");
        if(getComputedStyle(flag).left == "0px") {
            document.querySelector("div.chat").style.left = "-400px";
            document.querySelector("div.chatbtn").style.left = "0px";
        }
        else {
            document.querySelector("div.chat").style.left = "0px";
            document.querySelector("div.chatbtn").style.left = "400px";
        }
    })
    if(document.getElementById("exchangebutton") !== null) {
        let fromImg = document.getElementById("fromimg");
        let toImg = document.getElementById("toimg");
        let fromList = document.getElementById("fromlist");
        let toList = document.getElementById("tolist")
        function changeImage() {
                fromImg.src = `images/${fromlist.value}.png`;
                toImg.src = `images/${toList.value}.png`;
                fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cethereum%2Chex&vs_currencies=usd&include_market_cap=false&include_24hr_vol=false&include_24hr_change=false&include_last_updated_at=false").then(res => res.json()).then(data => {
                    let send = fromList.value;
                    let receive = toList.value;
                    document.getElementById("exchangerate").textContent = `1 ${fromList.value.toUpperCase()} = ${(send === "usdc" ? 1 : data[send].usd)/(receive === "usdc" ? 1 : data[receive].usd) } ${toList.value.toUpperCase()}`
                });
                };
        document.getElementById("exchangebutton").addEventListener("click", () => {
            let temp = fromList.value;
            fromlist.value = toList.value;
            toList.value = temp;
            changeImage();
        });
        document.getElementById("calculatebutton").addEventListener("click", (e) => {
            e.preventDefault();
            let value = document.getElementById("amountnumber").value;
            let send = fromList.value;
            let receive = toList.value;
            let namesend = fromList.value;
            let namereceive = toList.value;
            if(send == "bitcoin") {
                namesend = "BTC";
            } else if (send == "ethereum") {
                namesend = "ETH";
            }
            if(receive == "bitcoin") {
                namereceive = "BTC";
            } else if (receive == "ethereum") {
                namereceive = "ETH";
            }
            fetch("https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cethereum%2Chex&vs_currencies=usd&include_market_cap=false&include_24hr_vol=false&include_24hr_change=false&include_last_updated_at=false").then(res => res.json()).then(data => {
                document.getElementById("exchangerate").textContent = `${value} ${namesend.toUpperCase()} = ${(send === "usdc" ? 1 : data[send].usd)*value/(receive === "usdc" ? 1 : data[receive].usd)} ${namereceive}`;
            });
           
        });
    };
if(!(document.querySelector(".chart") == null)) {
    const chartElement = document.querySelector(".chart");
    const canvas = document.createElement("canvas");
    
    canvas.width = 400;
    canvas.height = 400;
    
    chartElement.appendChild(canvas);
    const ctx = canvas.getContext("2d");
    
    ctx.lineWidth = 10;
    const R = 180;
    
    function drawCircle(color, start, ratio) {
        ctx.strokeStyle = color;
        ctx.beginPath();
        ctx.arc(canvas.width/2, canvas.height/2, R, start * 2 * Math.PI, ratio * 2 * Math.PI);
        ctx.stroke();
    }
    
    function updateChart(btc, eth, hex, usdc) {
        ctx.clearRect(0,0,canvas.width, canvas.height);
        let bitcoin = btc/(btc + eth + hex + usdc);
        let ethereum = eth/(btc + eth + hex + usdc);
        let hexx = hex/(btc + eth + hex + usdc);
        let usdcc = usdc/(btc + eth + hex + usdc);
        drawCircle("gold", 0, bitcoin);
        drawCircle("black", bitcoin, ethereum + bitcoin);
        drawCircle("pink", ethereum + bitcoin, hexx + ethereum + bitcoin);
        drawCircle("blue", hexx + ethereum + bitcoin, hexx + ethereum + bitcoin + usdcc);
    }
    
};

if (!(document.getElementById("signup") == null)) {
    const validation = new JustValidate("#signup");
    validation.addField("#name", [
    {
        rule: "required"
    },
    {
            validator: (value) => () => {
                return fetch("/php-site/roulette/requests/validate-email.php?name=" + encodeURIComponent(value))
                .then(function(response) {
                    return response.json();
                })
                .then(function(json) {
                    return json.available;
                })
            },
            errorMessage: "name already taken"
    },
    {
        validator: (value) => {
            return value.length >= 3;
        },
        errorMessage: "Minimum 3 letters"
    }
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#password_confirmation", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    })
};

if(!(document.getElementById("spinner") == null)) {
    const TIMER_DURATION = 30;
    function steptimer() {
        const timestamp = Date.now() / 1000;
        const timeLeft = (TIMER_DURATION - 1) - Math.round(timestamp) % TIMER_DURATION;
        if(timeLeft == 0) {
            let cases = [
                ["-8000px", "-8227px", "-8800px", "-9029px", "-9229px"],
                ["-8400px", "-8710px", "-8340px", "-8130px", "-8930px"],
                ["-8300px", "-8250px", "-8320px", "-8310px", "-8240px"]
            ];
            let position = null;
            let lottery = Math.floor(Math.random() * (100- 1 + 1)) + 1;
            if(lottery <= 48) {
                position = cases[0][Math.floor(Math.random() * (5 - 1 + 1)) + 1];
            } else if  (lottery == 49 || lottery == 50) {
                position = cases[2][Math.floor(Math.random() * (5 - 1 + 1)) + 1];
            } else if (lottery >= 51) {
                position = cases[1][Math.floor(Math.random() * (5 - 1 + 1)) + 1];
            }
            document.getElementById("spinnermask").style.display = "none";
            document.getElementById("roulettepointer").style.display = "block";
            document.getElementById("spinner").style.backgroundPosition = position;
        }
        if(timeLeft == 20) {
            document.getElementById("spinnermask").style.display = "block";
            document.getElementById("roulettepointer").style.display = "none";
            document.getElementById("spinner").style.backgroundPosition = "0px";
        }
        const timeCorrection = Math.round(timestamp) - timestamp;
        setTimeout(steptimer, timeCorrection * 1000 + 1000);
    };
    steptimer();
};