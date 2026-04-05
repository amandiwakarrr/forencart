// =====================
// GLOBAL TIMER
// =====================
let countdown;
let timeLeft = 30;


// =====================
// CHECK EMAIL + PASSWORD
// =====================
function checkUser() {
    let email = document.querySelector('[name="email"]').value;
    let password = document.querySelector('[name="password"]').value;

    if (!email || !password) {
        document.getElementById("msg").innerText = "Enter email & password";
        return;
    }

    showLoader(true);
    document.getElementById("msg").innerText = "Checking...";

    fetch('/forencart/auth/check_user.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {
        showLoader(false);

        if (data.status === "success") {
            document.getElementById("msg").innerText = "✅ Verified";

            // ✅ FIXED HERE
            document.getElementById("sendOtpBtn").style.display = "block";
            document.getElementById("checkBtn").style.display = "none";

        } else {
            document.getElementById("msg").innerText = data.msg;
        }
    });
}

// =====================
// SEND OTP
// =====================
function sendOTP(){
    let email = document.querySelector('[name="email"]').value;

    if(!email){
        document.getElementById("msg").innerText = "Enter email";
        return;
    }

    showLoader(true);
    document.getElementById("msg").innerText = "Sending OTP...";

    fetch('/forencart/auth/send_otp.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'email='+encodeURIComponent(email)
    })
    .then(res=>res.json())
    .then(data=>{
        showLoader(false);

        document.getElementById("msg").innerText = data.msg;

        if(data.status==="success"){
            document.getElementById("otpBox").style.display = "block";
            document.getElementById("loginBtn").style.display = "block";

            // 🔥 Start timer
            document.getElementById("resendText").style.display = "block";
            startTimer();
        }
    });
}


// =====================
// VERIFY OTP
// =====================
function verifyOTP(){
    let email = document.querySelector('[name="email"]').value;
    let otp = document.querySelector('[name="otp"]').value;

    if(!otp){
        document.getElementById("msg").innerText = "Enter OTP";
        return;
    }

    showLoader(true);
    document.getElementById("msg").innerText = "Verifying...";

    fetch('/forencart/auth/verify_otp.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`email=${encodeURIComponent(email)}&otp=${encodeURIComponent(otp)}`
    })
    .then(res=>res.json())
    .then(data=>{
        showLoader(false);

        if(data.status==="success"){
            window.location.replace("/forencart/pages/account.php");
        } else {
            document.getElementById("msg").innerText = data.msg;
        }
    });
}


// =====================
// TIMER (Flipkart Style)
// =====================
function startTimer() {
    timeLeft = 30;

    document.getElementById("timer").innerText = timeLeft;

    countdown = setInterval(() => {
        timeLeft--;
        document.getElementById("timer").innerText = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);

            document.getElementById("resendText").innerHTML =
                `<a href="#" onclick="sendOTP()">Resend OTP</a>`;
        }
    }, 1000);
}


// =====================
// LOADER
// =====================
function showLoader(show) {
    document.getElementById("loader").style.display = show ? "block" : "none";
}