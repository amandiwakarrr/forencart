<?php
include("../config/config.php");
include("../includes/db.php");

$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';

$query = "
SELECT p.*, o.type, o.value
FROM products p
LEFT JOIN offers o 
ON p.category_id = o.category_id
AND o.status = 1
AND NOW() BETWEEN o.start_date AND o.end_date
WHERE 1
";

/* FILTERS */
if (!empty($category)) {
    $query .= " AND p.category_id = $category";
}

if (!empty($search)) {
    $query .= " AND p.name LIKE '%$search%'";
}

if (!empty($min)) {
    $query .= " AND p.price >= $min";
}

if (!empty($max)) {
    $query .= " AND p.price <= $max";
}

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {

    $price = $row['price'];

    if ($row['type'] == 'percentage') {
        $discount = $price * $row['value'] / 100;
    } elseif ($row['type'] == 'fixed') {
        $discount = $row['value'];
    } else {
        $discount = 0;
    }

    $final = max(0, $price - $discount);
?>

<div class="product-card">

    <?php if($discount > 0) { ?>
        <span class="badge">
            <?php echo $row['value']; ?>
            <?php echo $row['type']=='percentage' ? '%' : '₹'; ?> OFF
        </span>
    <?php } ?>

    <img src="<?php echo $base_url; ?>assets/images/products/<?php echo $row['image']; ?>">

    <h3><?php echo $row['name']; ?></h3>

    <p>
        <?php if($discount > 0) { ?>
            <del>₹<?php echo $price; ?></del>
            <span class="new-price">₹<?php echo $final; ?></span>
        <?php } else { ?>
            ₹<?php echo $price; ?>
        <?php } ?>
    </p>

    <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $row['id']; ?>">
        View Product
    </a>

</div>

<?php } ?>