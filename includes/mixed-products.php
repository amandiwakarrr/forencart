<?php
// Fetch 24 random products (change LIMIT to 20 or 30 if needed)
$products = mysqli_query($conn, "
    SELECT id, name, price, image
    FROM products
    ORDER BY RAND()
    LIMIT 24
");
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/mixed-products.css">

<section class="mixed-products">

    <div class="container">

        <h2 class="section-title">Explore More Products</h2>

        <div class="products-grid">

            <?php if (mysqli_num_rows($products) > 0) { ?>
                <?php while ($product = mysqli_fetch_assoc($products)) { ?>

                    <div class="product-card">

                        <a 
                            href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $product['id']; ?>" 
                            class="product-image"
                        >
                            <img 
                                src="<?php echo $base_url; ?>assets/images/products/<?php echo $product['image'] ?: 'placeholder.png'; ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                            >
                        </a>

                        <div class="product-info">
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
                            <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $product['id']; ?>" class="btn">View Product</a>
                        </div>

                        

                    </div>

                <?php } ?>
            <?php } else { ?>
                <p>No products available.</p>
            <?php } ?>

        </div>

        <div class="view-more">
            <a href="<?php echo $base_url; ?>pages/shop.php">View All Products</a>
        </div>

    </div>

</section>
