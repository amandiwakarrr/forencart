<?php
include_once '../includes/header.php';

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM offers WHERE id=$id");
$offer = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    mysqli_query($conn, "
        UPDATE offers 
        SET title='$title', type='$type', value=$value, start_date='$start', end_date='$end'
        WHERE id=$id
    ");

    header("Location: manage-offers.php");
    exit;
}
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/manage-offers.css">
<div class="form-container">
    <h2>Edit Offer</h2>

    <form method="POST">

        <div class="form-group">
            <label>Title</label>
            <input class="form-control" name="title" value="<?php echo $offer['title']; ?>" required>
        </div>

        <div class="form-group">
            <label>Type</label>
            <select class="form-control" name="type">
                <option value="percentage" <?php if($offer['type']=='percentage') echo 'selected'; ?>>Percentage</option>
                <option value="fixed" <?php if($offer['type']=='fixed') echo 'selected'; ?>>Fixed</option>
            </select>
        </div>

        <div class="form-group">
            <label>Value</label>
            <input class="form-control" type="number" name="value" value="<?php echo $offer['value']; ?>" required>
        </div>

        <div class="form-group">
            <label>Start Date</label>
            <input class="form-control" type="datetime-local" name="start_date"
                value="<?php echo date('Y-m-d\TH:i', strtotime($offer['start_date'])); ?>">
        </div>

        <div class="form-group">
            <label>End Date</label>
            <input class="form-control" type="datetime-local" name="end_date"
                value="<?php echo date('Y-m-d\TH:i', strtotime($offer['end_date'])); ?>">
        </div>

        <button class="btn-submit" type="submit">Update Offer</button>

    </form>
</div>