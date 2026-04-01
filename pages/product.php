<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product");
}

$product_id = (int) $_GET['id'];

/* 🔥 FIXED QUERY (CATEGORY-BASED OFFER) */
$productQuery = mysqli_query($conn, "
SELECT p.*, c.name AS category_name, c.id AS category_id, o.type, o.value
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
LEFT JOIN offers o 
    ON p.category_id = o.category_id
    AND o.status = 1
    AND NOW() BETWEEN o.start_date AND o.end_date
WHERE p.id = $product_id
LIMIT 1
");

if (mysqli_num_rows($productQuery) === 0) {
    die("Product not found");
}

$product = mysqli_fetch_assoc($productQuery);

/* 🔥 PRICE CALCULATION */
$price = $product['price'];
$finalPrice = $price;

if (!empty($product['type'])) {
    if ($product['type'] == 'percentage') {
        $finalPrice = $price - ($price * $product['value'] / 100);
    } else {
        $finalPrice = $price - $product['value'];
    }
}

/* Prevent negative */
$finalPrice = max(0, $finalPrice);

/* RELATED PRODUCTS */
$relatedProducts = mysqli_query($conn, "
    SELECT id, name, price, image
    FROM products
    WHERE category_id = {$product['category_id']} 
      AND id != $product_id
    LIMIT 4
");
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/product.css">


<main class="product-page">

<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="<?php echo $base_url; ?>">Home</a> /
    <a href="<?php echo $base_url; ?>pages/category.php?id=<?php echo $product['category_id']; ?>">
        <?php echo htmlspecialchars($product['category_name']); ?>
    </a> /
    <span><?php echo htmlspecialchars($product['name']); ?></span>
</div>

<div class="product-layout">

<!-- LEFT -->
<div class="product-gallery">

    <!-- 🔥 DISCOUNT BADGE -->
    <?php if (!empty($product['type'])) { ?>
        <div class="discount-badge">
            <?php echo $product['value']; ?>
            <?php echo $product['type'] == 'percentage' ? '%' : '₹'; ?> OFF
        </div>
    <?php } ?>

    <div class="main-image">
        <img id="mainProductImage"
            src="<?php echo $base_url; ?>assets/images/products/<?php echo $product['image']; ?>">
    </div>

    <div class="thumbnail-container">
        <?php
        $images = explode(',', $product['image']);
        foreach($images as $img) {
        ?>
            <img src="<?php echo $base_url; ?>assets/images/products/<?php echo trim($img); ?>"
                onclick="changeImage(this)" class="thumbnail">
        <?php } ?>
    </div>

</div>

<!-- RIGHT -->
<div class="product-details">

    <h1><?php echo htmlspecialchars($product['name']); ?></h1>

    <div class="rating-display">
        ★★★★☆ <span>(4.2)</span>
    </div>

    <!-- 🔥 PRICE SECTION -->
    <div class="price">

        <?php if (!empty($product['type'])) { ?>

            <span class="new-price">
                ₹<?php echo number_format($finalPrice,2); ?>
            </span>

            <span class="old-price">
                ₹<?php echo number_format($price,2); ?>
            </span>

        <?php } else { ?>

            ₹<?php echo number_format($price,2); ?>

        <?php } ?>

    </div>

    <div class="stock in-stock">In Stock</div>

    <div class="delivery">
        Get it by <strong>3–5 days</strong>
    </div>

    <div class="buttons">
        <form action="<?php echo $base_url; ?>pages/add-to-cart.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                <div class="quantity-control" data-product-id="<?php echo $product['id']; ?>">
                    <button type="button" class="qty-btn minus">−</button>
                    <input type="number" name="qty" class="qty-input" value="1" min="1">
                    <button type="button" class="qty-btn plus">+</button>
                </div>

            <button type="submit" class="btn-cart">Add to Cart</button>
        </form>

        <a href="javascript:void(0)"
            onclick="addToWishlist(<?php echo $product['id']; ?>)"
        class="btn-wishlist">Wishlist</a>
    </div>

    <p class="description">
        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
    </p>

</div>

</div>

<!-- RELATED PRODUCTS -->
<?php if (mysqli_num_rows($relatedProducts) > 0) { ?>
<section class="related-products">
    <h2>Related Products</h2>

    <div class="related-grid">
        <?php while ($rel = mysqli_fetch_assoc($relatedProducts)) { ?>
            <div class="related-card">
                <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $rel['id']; ?>">
                    <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $rel['image']; ?>">
                    <h4><?php echo htmlspecialchars($rel['name']); ?></h4>
                    <p>₹<?php echo number_format($rel['price'], 2); ?></p>
                </a>
                <div class="product-actions">

                    <a href="javascript:void(0)"
                        onclick="addToWishlist(<?php echo $product['id']; ?>)"
                    class="btn-wishlist"> Wishlist</a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<?php } ?>
<script src="<?php echo $base_url; ?>assets/js/quantity.js"></script>
<script src="<?php echo $base_url; ?>assets/js/product.js"></script>
<script src="<?php echo $base_url; ?>assets/js/wishlist.js"></script>

</main>

<?php include_once '../includes/footer.php'; ?>