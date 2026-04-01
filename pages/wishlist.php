<?php

// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../auth/login.php");
//     exit;
// }

require_once '../includes/header.php';
require_once '../includes/navbar.php'; 


$user_id = $_SESSION['user_id'];

$items = mysqli_query($conn, "
    SELECT p.* FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = $user_id
");
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/wishlist.css">

<div class="wishlist-container">

    <h2>❤️ My Wishlist</h2>

    <?php if (mysqli_num_rows($items) == 0) { ?>
        <div class="empty-wishlist">
            <p>Your wishlist is empty 😔</p>
            <a href="shop.php" class="btn">Continue Shopping</a>
        </div>
    <?php } else { ?>

    <div class="wishlist-grid">
        <?php while ($p = mysqli_fetch_assoc($items)) { ?>
            <div class="wishlist-card">

                <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $p['image']; ?>">

                <h4><?php echo htmlspecialchars($p['name']); ?></h4>
                <p class="price">₹<?php echo number_format($p['price'], 2); ?></p>

                <div class="wishlist-actions">
                    <a href="product.php?id=<?php echo $p['id']; ?>" class="btn-outline">
                        View
                    </a>

                    <button onclick="removeFromWishlist(<?php echo $p['id']; ?>, this)" class="btn-danger">
                        Remove
                    </button>
                </div>

            </div>
        <?php } ?>
    </div>

    <div class="wishlist-footer">
        <a href="cart.php" class="btn">Go to Cart</a>
        <a href="checkout.php" class="btn primary">Checkout</a>
    </div>

    <?php } ?>
</div>

<script src="<?php echo $base_url; ?>assets/js/wishlist.js"></script>

<?php include '../includes/footer.php'; ?>
