// ✅ Global function (onclick ke liye)
function addToWishlist(productId) {

    // Safety check
    if (typeof BASE_URL === "undefined") {
        console.error("BASE_URL is not defined");
        alert("Configuration error. Please reload page.");
        return;
    }

    console.log("Adding to wishlist, product:", productId);

    fetch(BASE_URL + 'pages/add-to-wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.text())
    .then(msg => {
        console.log("Server response:", msg);
        alert(msg);
    })
    .catch(err => {
        console.error("Wishlist error:", err);
        alert("Something went wrong. Try again.");
    });
}

function removeFromWishlist(productId, btn) {

    if (typeof BASE_URL === "undefined") {
        console.error("BASE_URL is not defined");
        alert("Configuration error. Please reload page.");
        return;
    }

    fetch(BASE_URL + 'pages/remove-from-wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(res => res.text())
    .then(msg => {
        console.log(msg);

        // ✅ Remove card smoothly
        const card = btn.closest('.wishlist-card');
        card.style.transition = "0.3s";
        card.style.opacity = "0";
        setTimeout(() => {
            card.remove();

            // ✅ If no items left → show empty message
            if (document.querySelectorAll('.wishlist-card').length === 0) {
                document.querySelector('.wishlist-container').innerHTML = `
                    <div class="empty-wishlist">
                        <p>Your wishlist is empty 😔</p>
                        <a href="shop.php" class="btn">Continue Shopping</a>
                    </div>
                `;
            }

        }, 300);
    })
    .catch(err => {
        console.error("Remove error:", err);
        alert("Something went wrong!");
    });
}
