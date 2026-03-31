<?php
require_once __DIR__ . "/../config/config.php";
include "../includes/header.php";

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_role']) ||
    $_SESSION['user_role'] !== 'admin'
) {
    header("Location: " . $base_url . "auth/login.php");
    exit;
}

require_once __DIR__ . "/includes/admin-header.php";
$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 10");
?>

<main class="admin-content">

    <h1>Dashboard</h1>
    <p class="subtitle">Welcome to ForenCart Admin Panel</p>

    <div class="dashboard-cards">

        <div class="dash-card">
            <h3>Banners</h3>
            <p>Manage homepage sliders</p>
            <a href="<?php echo $base_url; ?>admin/banners.php">Manage</a>
        </div>

        <div class="dash-card">
            <h3>Products</h3>
            <p>Add & manage products</p>
            <a href="<?php echo $base_url; ?>admin/products.php">Manage</a>
        </div>

        <div class="dash-card">
            <h3>Orders</h3>
            <p>Track customer orders</p>
            <a href="<?php echo $base_url; ?>admin/orders.php">Manage</a>
        </div>

        <div class="dash-card">
            <h3>Offers</h3>
            <p>Track customer Offers</p>
            <a href="<?php echo $base_url; ?>admin/manage-offers.php">Manage</a>
        </div>
        <div class="dash-card">
            <div class="dash-card">
                <div class="messages-card">

        <h3 class="messages-title">📩 Recent Messages</h3>

        <table class="messages-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            
            <td><?php echo $row['name']; ?></td>
            
            <td><?php echo $row['email']; ?></td>
            
            <td><?php echo substr($row['message'],0,40); ?>...</td>

            <td>
                <span class="status-badge 
                    <?php 
                        if($row['status']=='unread') echo 'status-unread';
                        elseif($row['status']=='read') echo 'status-read';
                        else echo 'status-replied';
                    ?>">
                    <?php echo $row['status']; ?>
                </span>
            </td>

            <td>
                <a class="action-link action-read"
                href="<?php echo $base_url; ?>admin/mark_read.php?id=<?php echo $row['id']; ?>">
                Read
                </a>

                <a class="action-link action-reply"
                href="<?php echo $base_url; ?>admin/reply.php?id=<?php echo $row['id']; ?>">
                Reply
                </a>

                <a class="action-link action-delete"
                href="<?php echo $base_url; ?>admin/delete_message.php?id=<?php echo $row['id']; ?>">
                Delete
                </a>
            </td>

        </tr>
<?php } ?>
</tbody>

</table>

</div>
            </div>

        </div>

    </div>

</main>

</div> <!-- admin-wrapper -->
</body>
</html>
