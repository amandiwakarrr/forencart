document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("contactForm");
    const btn = document.getElementById("submitBtn");
    const toast = document.getElementById("toast");

    if (!form || !btn || !toast) return; // safety check

    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        // Button loading
        btn.classList.add("loading");
        btn.innerText = "Sending...";

        fetch("contact_process.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            showToast(data.message, data.status);

            if (data.status === "success") {
                form.reset();
            }

            btn.classList.remove("loading");
            btn.innerText = "Send Message";
        })
        .catch(() => {
            showToast("Something went wrong!", "error");

            btn.classList.remove("loading");
            btn.innerText = "Send Message";
        });
    });

    function showToast(message, type) {
        toast.innerText = message;
        toast.className = "";
        toast.classList.add("show", type);

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }

});