// =====================
// SEND OTP
// =====================
function sendOTP(){
    let email = document.querySelector('[name="email"]').value;

    if(!email){
        document.getElementById("msg").innerText = "Enter email";
        return;
    }

    document.getElementById("msg").innerText = "Sending OTP...";

    fetch('send_otp.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'email='+encodeURIComponent(email)
    })
    .then(res=>res.json())
    .then(data=>{
        document.getElementById("msg").innerText = data.msg;

        if(data.status==="success"){
            document.getElementById("otpBox").style.display = "block";
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

    document.getElementById("msg").innerText = "Verifying...";

    fetch('verify_otp.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`email=${encodeURIComponent(email)}&otp=${encodeURIComponent(otp)}`
    })
    .then(res=>res.json())
    .then(data=>{
        console.log(data);

        if(data.status==="success"){
            // 🔥 FINAL FIX
            window.location.replace("/forencart/pages/account.php");
        } else {
            document.getElementById("msg").innerText = data.msg;
        }
    });
}