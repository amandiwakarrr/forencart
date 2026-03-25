<?php
require_once "../config/config.php";
require_once "../includes/db.php";
require_once "includes/admin-header.php";

$categories = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $category_id = $_POST['category_id'];

    mysqli_query($conn, "
        INSERT INTO offers (title, type, value, start_date, end_date, status, category_id)
        VALUES ('$title', '$type', $value, '$start', '$end', 1, $category_id)
    ");

    header("Location: manage-offers.php");
    exit;
}
?>

<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/add-offer.css">

<div class="form-container">
    <h2>Add Offer</h2>

    <form method="POST">

        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title" required>
        </div>

        <div class="form-group">
            <label>Type</label>
            <select class="form-control" name="type">
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed</option>
            </select>
        </div>

        <div class="form-group">
            <label>Value</label>
            <input class="form-control" type="number" name="value" required>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category_id" required>
                <option value="">Select Category</option>
                <?php while($c = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?php echo $c['id']; ?>">
                        <?php echo $c['name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Start Date</label>
            <input class="form-control" type="datetime-local" name="start_date">
        </div>

        <div class="form-group">
            <label>End Date</label>
            <input class="form-control" type="datetime-local" name="end_date">
        </div>

        <button class="btn-submit">Add Offer</button>

    </form>
</div>