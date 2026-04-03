document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".quantity-control").forEach(container => {

        const input = container.querySelector(".qty-input");
        const plus = container.querySelector(".plus");
        const minus = container.querySelector(".minus");
        const productId = container.dataset.productId;
        const isCart = container.classList.contains("cart-mode");

        // ➕ Increase
        plus.addEventListener("click", () => {
            let qty = parseInt(input.value) || 0;
            qty++;
            input.value = qty;

            if (isCart) {
                updateCart(productId, qty, container);
            }
        });

        // ➖ Decrease (ALLOW 0)
        minus.addEventListener("click", () => {
            let qty = parseInt(input.value) || 0;

            qty--; // allow 0
            if (qty < 0) qty = 0;

            input.value = qty;

            if (isCart) {
                updateCart(productId, qty, container);
            }
        });

        // 🔄 Manual input change
        input.addEventListener("change", () => {
            let qty = parseInt(input.value) || 0;

            if (qty < 0) qty = 0;
            input.value = qty;

            if (isCart) {
                updateCart(productId, qty, container);
            }
        });

    });

    // 🔥 AJAX update function
    function updateCart(id, qty, container) {

        // ✅ If quantity is 0 → remove item
        if (qty <= 0) {

            fetch("remove-from-cart.php?id=" + id)
            .then(() => {

                // Remove item from UI
                const cartItem = container.closest(".cart-item");
                cartItem.remove();

                // 🔥 Update grand total manually (better UX)
                updateGrandTotal();

                // 🔥 If cart becomes empty
                if (document.querySelectorAll(".cart-item").length === 0) {
                    document.querySelector(".cart-container").innerHTML = "<p>Your cart is empty.</p>";
                }

            });

            return;
        }

        // ✅ Otherwise update quantity
        fetch("update-cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&qty=${qty}`
        })
        .then(res => res.json())
        .then(data => {

            // Update item total
            const itemTotal = container.closest(".cart-item").querySelector(".cart-total");
            itemTotal.innerText = "₹" + data.itemTotal;

            // Update grand total
            document.querySelector(".grand-total").innerText = "₹" + data.grandTotal;

        });
    }

    // 🔥 Recalculate total from UI (no reload needed)
    function updateGrandTotal() {

        let total = 0;

        document.querySelectorAll(".cart-total").forEach(item => {
            let value = item.innerText.replace("₹", "").replace(",", "").trim();
            total += parseFloat(value) || 0;
        });

        document.querySelector(".grand-total").innerText = "₹" + total.toFixed(2);
    }

});