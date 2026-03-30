<?php
require_once '../includes/header.php';

// session check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}
require_once '../config/config.php';
require_once '../includes/navbar.php';

$userName  = $_SESSION['user_name'];
$userEmail = isset($_SESSION['user_email']) 
    ? $_SESSION['user_email'] 
    : 'Not available';
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/account.css">

<div class="account-container">

    <!-- SIDEBAR -->
    <!-- <aside class="account-sidebar">
        <h3>My Account</h3>
        <ul>
            <li class="active">Dashboard</li>
            <li><a href="<?php echo $base_url; ?>pages/orders.php">My Orders</a></li>
            <li><a href="<?php echo $base_url; ?>pages/wishlist.php">Wishlist</a></li>
            <li>Settings</li>
            <li>
                <a href="<?php echo $base_url; ?>auth/logout.php" class="logout">Logout</a>
            </li>
        </ul>
    </aside> -->

    <!-- MAIN CONTENT -->
    <section class="account-content">

        <div class="welcome-card">
            <h2>Welcome, <?php echo htmlspecialchars($userName); ?> 👋</h2>
            <p><?php echo htmlspecialchars($userEmail); ?></p>
        </div>

        <div class="account-cards">

            <div class="card">
                <h4>My Orders</h4>
                <p>View your recent orders</p>
                <a href="orders.php">View Orders →</a>
            </div>

            <div class="card">
                <h4>Wishlist</h4>
                <p>Your saved products</p>
                <a href="wishlist.php">View Wishlist →</a>
            </div>

            <div class="card">
                <h4>Account Settings</h4>
                <p>Update your profile</p>
                <a href="settings.php">Edit Profile →</a>
            </div>

            <div class="card">
                <a href="<?php echo $base_url; ?>auth/logout.php" class="logout">Logout</a>
            </div>

        </div>

    </section>
</div>

<?php include '../includes/footer.php'; ?>
