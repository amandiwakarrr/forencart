document.addEventListener("DOMContentLoaded", function () {

    const productsBox = document.getElementById("shopProducts");
    const categoryLinks = document.querySelectorAll("#categoryList a");
    const priceForm = document.getElementById("priceFilter");

    let currentCategory = window.SHOP_INITIAL_CATEGORY || "";
    let currentSearch = window.SHOP_INITIAL_SEARCH || "";
    let minPrice = "";
    let maxPrice = "";

    function loadProducts() {
        productsBox.innerHTML = "<p>Loading products...</p>";

        const formData = new FormData();
        formData.append("category", currentCategory);
        formData.append("search", currentSearch);
        formData.append("min", minPrice);
        formData.append("max", maxPrice);

        fetch("../pages/shop-filter.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            productsBox.innerHTML = html;
        });
    }

    /* CATEGORY CLICK */
    categoryLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            categoryLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");

            currentCategory = this.dataset.category;
            loadProducts();
        });
    });

    /* PRICE FILTER */
    priceForm.addEventListener("submit", function (e) {
        e.preventDefault();

        minPrice = document.getElementById("minPrice").value;
        maxPrice = document.getElementById("maxPrice").value;

        loadProducts();
    });

    /* INITIAL LOAD */
    loadProducts();
});