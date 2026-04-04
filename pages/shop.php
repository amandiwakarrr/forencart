<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';

/* URL se category & search */
$initialCategory = $_GET['category'] ?? '';
$search = $_GET['q'] ?? '';

/* FETCH CATEGORIES (SIDEBAR KE LIYE) */
$categories = mysqli_query(
    $conn,
    "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC"
);
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/shop.css">

<main class="shop-page">

    <h1 class="shop-title">Shop Products</h1>

    <?php if (!empty($search)) { ?>
        <p class="search-result">
            Showing results for "<strong><?php echo htmlspecialchars($search); ?></strong>"
        </p>
    <?php } ?>

    <div class="shop-layout">
        <!-- Products filter usign ajax without reloading page -->
        <div class="shop-filter-top">

            <h3>Filters</h3>

            <!-- CATEGORY -->
            <div class="filter-box">
                <h4>Categories</h4>
                <ul id="categoryList">
                    <li><a href="#" data-category="" class="active">All</a></li>

                    <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                        <li>
                            <a href="#" data-category="<?php echo $cat['slug']; ?>">
                                <?php echo $cat['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <!-- PRICE -->
            <div class="filter-box">
                <h4>Price</h4>
                <input style="margin:0px 4px 0px 0px; width:50px;" type="number" id="minPrice" placeholder="Min ₹">
                <input style="margin:0px 4px 0px 0px; width:50px;" type="number" id="maxPrice" placeholder="Max ₹">
                <button style="padding:0px 5px; background:#fff; border:1px solid black; border-radius:4px;" id="applyPrice">Apply</button>
            </div>

        </div>
        <!-- PRODUCTS -->
        <section class="shop-products" id="shopProducts">
            <!-- Products AJAX se load honge -->
        </section>

    </div>

</main>

<!-- PHP se JS ko data pass -->
<script>
    window.SHOP_INITIAL_CATEGORY = "<?php echo htmlspecialchars($initialCategory); ?>";
    window.SHOP_INITIAL_SEARCH = "<?php echo htmlspecialchars($search); ?>";
</script>

<!-- SHOP JS -->
<script src="<?php echo $base_url; ?>assets/js/shop.js"></script>

<?php include_once '../includes/footer.php'; ?>
