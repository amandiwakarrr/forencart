document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".quantity-control").forEach(container => {

        const input = container.querySelector(".qty-input");
        const plus = container.querySelector(".plus");
        const minus = container.querySelector(".minus");
        const productId = container.dataset.productId;
        const isCart = container.classList.contains("cart-mode");

        // ➕ Increase
        plus.addEventListener("click", () => {
            let qty = parseInt(input.value) || 1;
            qty++;
            input.value = qty;

            if (isCart) {
                updateCart(productId, qty, container);
            }
        });

        // ➖ Decrease
        minus.addEventListener("click", () => {
            let qty = parseInt(input.value) || 1;

            if (qty > 1) {
                qty--;
                input.value = qty;

                if (isCart) {
                    updateCart(productId, qty, container);
                }
            }
        });

    });

    // 🔥 AJAX update
    function updateCart(id, qty, container) {

        fetch("update-cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&qty=${qty}`
        })
        .then(res => res.json())
        .then(data => {

            // ✅ Update item total dynamically
            const itemTotal = container.closest(".cart-item").querySelector(".cart-total");
            itemTotal.innerText = "₹" + data.itemTotal;

            // ✅ Update grand total
            document.querySelector(".grand-total").innerText = "₹" + data.grandTotal;

        });
    }

});