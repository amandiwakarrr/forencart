<?php
$base_url = "http://localhost/forencart/";
include_once '../includes/header.php';
// header.php already starts session + db + base_url
require_once "../includes/header.php";

$category = $_POST['category'] ?? '';
$search   = $_POST['search'] ?? '';
$min      = $_POST['min'] ?? '';
$max      = $_POST['max'] ?? '';

$where = "WHERE products.status = 1";

/* CATEGORY FILTER */
if (!empty($category)) {
    $cat = mysqli_real_escape_string($conn, $category);
    $where .= " AND categories.slug = '$cat'";
}

/* SEARCH FILTER */
if (!empty($search)) {

    $search = trim($search);
    $keywords = explode(" ", $search);
    $conditions = [];

    foreach ($keywords as $word) {
        $word = mysqli_real_escape_string($conn, strtolower($word));

        $conditions[] = "
            (
                LOWER(products.name) LIKE '%$word%' 
                OR LOWER(products.description) LIKE '%$word%'
                OR LOWER(products.tags) LIKE '%$word%'
                OR LOWER(categories.name) LIKE '%$word%'
            )
        ";
    }

    $where .= " AND (" . implode(" OR ", $conditions) . ")";
}



/* PRICE FILTER */
if ($min !== '' && is_numeric($min)) {
    $where .= " AND products.price >= " . (float)$min;
}

if ($max !== '' && is_numeric($max)) {
    $where .= " AND products.price <= " . (float)$max;
}


/* ORDER LOGIC */
$orderBy = "ORDER BY products.id DESC";

// 🔥 Sirf ALL PRODUCTS ke liye mix
if (empty($category) && empty($search) && $min === '' && $max === '') {
    $orderBy = "ORDER BY RAND()";
}


/* FETCH PRODUCTS */
$query = mysqli_query($conn, "
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
    $where
    $orderBy
");

if (!$query || mysqli_num_rows($query) === 0) {
    echo "<p class='no-products'>No products found.</p>";
    exit;
}

/* OUTPUT PRODUCTS */

while ($p = mysqli_fetch_assoc($query)) {
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/shop-ajax-products.css">

    <div class="product-card">

        <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $p['id']; ?>">
            <img 
                src="<?php echo $base_url; ?>assets/images/products/<?php echo $p['image'] ?: 'placeholder.png'; ?>" 
                alt="<?php echo htmlspecialchars($p['name']); ?>"
            >
        </a>

        <div class="product-info"">
       
            <h4><?php echo htmlspecialchars($p['name']); ?></h4>

            <p class="price">
                ₹<?php echo number_format($p['price'], 2); ?>
            </p>
            <div class="product-actions">

    <a href="javascript:void(0)" onclick="addToWishlist(<?php echo $p['id']; ?>)">
        ❤️ Add to Wishlist
    </a>

    <a href="<?php echo $base_url; ?>pages/product.php?id=<?php echo $p['id']; ?>" class="view-btn" > View Product </a>

</div>
        </div>

    </div>
<?php } ?>
