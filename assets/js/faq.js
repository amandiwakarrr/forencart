// ACCORDION + ICON TOGGLE
document.querySelectorAll(".faq-question").forEach(btn => {
    btn.addEventListener("click", () => {

        let item = btn.parentElement;
        let answer = btn.nextElementSibling;

        // Close others
        document.querySelectorAll(".faq-item").forEach(el => {
            if (el !== item) {
                el.classList.remove("active");
                el.querySelector(".faq-answer").style.maxHeight = null;
            }
        });

        // Toggle current
        item.classList.toggle("active");

        if (answer.style.maxHeight) {
            answer.style.maxHeight = null;
        } else {
            answer.style.maxHeight = answer.scrollHeight + "px";
        }
    });
});


// SEARCH FUNCTION
document.getElementById("faqSearch").addEventListener("keyup", function () {
    let value = this.value.toLowerCase();

    document.querySelectorAll(".faq-item").forEach(item => {
        let text = item.innerText.toLowerCase();

        item.style.display = text.includes(value) ? "block" : "none";
    });
});