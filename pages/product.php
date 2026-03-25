
<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';

/* VALIDATE PRODUCT ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product");
}

$product_id = (int) $_GET['id'];

/* FETCH PRODUCT */
$productQuery = mysqli_query($conn, "
    SELECT products.*, categories.name AS category_name, categories.id AS category_id
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
    WHERE products.id = $product_id
    LIMIT 1
");

if (mysqli_num_rows($productQuery) === 0) {
    die("Product not found");
}

$product = mysqli_fetch_assoc($productQuery);

/* FETCH RELATED PRODUCTS */
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
            <!-- BREADCRUMB -->
        <div class="breadcrumb">
            <a href="<?php echo $base_url; ?>">Home</a> /
            <a href="<?php echo $base_url; ?>pages/category.php?id=<?php echo $product['category_id']; ?>">
                <?php echo htmlspecialchars($product['category_name']); ?>
            </a> /
            <span><?php echo htmlspecialchars($product['name']); ?></span>
        </div>

    <div class="product-layout">

    <!-- LEFT SIDE -->
    <div class="product-gallery">

        <!-- Discount Badge -->
        <div class="discount-badge">-20%</div>

        <div class="main-image">
            <img id="mainProductImage"
                src="<?php echo $base_url; ?>assets/images/products/<?php echo $product['image']; ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>

        <div class="thumbnail-container">
            <?php
            $images = explode(',', $product['image']);
            foreach($images as $img) {
            ?>
                <img src="<?php echo $base_url; ?>assets/images/products/<?php echo trim($img); ?>"
                    onclick="changeImage(this)"
                    class="thumbnail">
            <?php } ?>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="product-details">

        <h1><?php echo htmlspecialchars($product['name']); ?></h1>

        <div class="rating-display">
            ★★★★☆ <span>(4.2)</span>
        </div>

        <div class="price">
            ₹<?php echo number_format($product['price'],2); ?>
            <span class="old-price">₹999</span>
        </div>

        <!-- Stock Badge -->
        <div class="stock in-stock">In Stock</div>

        <!-- Delivery -->
        <div class="delivery">
            Get it by <strong>3–5 days</strong>
        </div>

        <div class="buttons">
        <form action="<?php echo $base_url; ?>pages/add-to-cart.php" method="POST">
        
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="quantity">
                <button type="button" onclick="changeQty(-1)">−</button>
                <input type="number" name="qty" id="qty" value="1" min="1">
                <button type="button" onclick="changeQty(1)">+</button>
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


        <!-- REVIEWS PRODUCTS -->
        <section class="review-section">

        <h2>Customer Reviews</h2>

        <!-- Review Form -->
        <?php if(isset($_SESSION['user_id'])) { ?>
        <form action="submit-review.php" method="POST" enctype="multipart/form-data" class="review-form">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

            <label>Rating</label>
            <select name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Bad</option>
            </select>

            <textarea name="review" placeholder="Write your review..." required></textarea>

            <input type="file" name="review_image">

            <button type="submit">Submit Review</button>
        </form>
        <?php } ?>

        <!-- Show Reviews -->
        <div class="review-list">
            <?php
            $reviews = mysqli_query($conn, "SELECT * FROM reviews WHERE product_id=".$product['id']." ORDER BY created_at DESC");
            while($r = mysqli_fetch_assoc($reviews)) {
            ?>
                <div class="review-card">
                    <strong>Rating: <?php echo $r['rating']; ?>/5</strong>
                    <p><?php echo htmlspecialchars($r['review']); ?></p>

                    <?php if($r['review_image']) { ?>
                        <img src="<?php echo $base_url; ?>uploads/reviews/<?php echo $r['review_image']; ?>" class="review-img">
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

    </section>


    <!-- RELATED PRODUCTS -->
    <?php if (mysqli_num_rows($relatedProducts) > 0) { ?>
        <section class="related-products">

            <h2>Related Products</h2>

            <div class="related-grid">
                <?php while ($rel = mysqli_fetch_assoc($relatedProducts)) { ?>
                    <div class="related-card">
                        <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $rel['id']; ?>">
                            <img 
                                src="<?php echo $base_url; ?>assets/images/products/<?php echo $rel['image'] ?: 'placeholder.png'; ?>"
                                alt="<?php echo htmlspecialchars($rel['name']); ?>"
                            >
                            <h4><?php echo htmlspecialchars($rel['name']); ?></h4>
                            <p>₹<?php echo number_format($rel['price'], 2); ?></p>
                        </a>
                    </div>
                <?php } ?>
            </div>

        </section>
    <?php } ?>

    <div id="lightbox" class="lightbox">
    <img id="lightbox-img">
</div>

<script src="<?php echo $base_url; ?>assets/js/product.js"></script>

</main>
<?php include_once '../includes/footer.php'; ?>
