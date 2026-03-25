<?php
require_once "../config/config.php";
require_once "../includes/db.php";
require_once "includes/admin-header.php";

$offers = mysqli_query($conn, "
    SELECT o.*, c.name AS category_name 
    FROM offers o
    LEFT JOIN categories c ON o.category_id = c.id
    ORDER BY o.id DESC
");
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>admin/assets/css/manage-offer.css">

<main class="admin-content">

<div style="display:flex; justify-content:space-between; align-items:center;">
    <h1>Offers</h1>
    <a href="add-offer.php" class="btn-add">+ Add Offer</a>
</div>

<table class="admin-table">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Type</th>
    <th>Value</th>
    <th>Category</th>
    <th>Products</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($o = mysqli_fetch_assoc($offers)) { ?>

<?php
// 🔥 Fetch products of this category
$products = mysqli_query($conn, "
    SELECT name FROM products 
    WHERE category_id = ".$o['category_id']."
");
?>

<tr>
    <td>#<?php echo $o['id']; ?></td>
    <td><?php echo $o['title']; ?></td>
    <td><?php echo ucfirst($o['type']); ?></td>
    <td>
        <?php 
        echo $o['type'] == 'percentage' 
            ? $o['value']."%" 
            : "₹".$o['value']; 
        ?>
    </td>

    <td><?php echo $o['category_name']; ?></td>

    <!-- 🔥 Show products -->
    <td class="product-list">
        <?php while($p = mysqli_fetch_assoc($products)) { ?>
            <div>• <?php echo $p['name']; ?></div>
        <?php } ?>
    </td>

    <!-- Status -->
    <td>
        <?php if($o['status']) { ?>
            <span class="status active">Active</span>
        <?php } else { ?>
            <span class="status inactive">Inactive</span>
        <?php } ?>
    </td>

    <!-- Actions -->
    <td>
        <a class="btn edit" href="edit-offer.php?id=<?php echo $o['id']; ?>">✏ Edit</a>

        <a class="btn delete" 
           href="delete-offer.php?id=<?php echo $o['id']; ?>"
           onclick="return confirm('Delete this offer?')">🗑 Delete</a>

        <a class="btn toggle" 
           href="toggle-offer.php?id=<?php echo $o['id']; ?>">
            <?php echo $o['status'] ? 'Deactivate' : 'Activate'; ?>
        </a>
    </td>
</tr>

<?php } ?>

</table>
</main>