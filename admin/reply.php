<?php
session_start();
include_once '../includes/db.php';
include_once '../config/config.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM contacts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Reply</title>

<style>
body { font-family:Arial; background:#f9fafb; padding:20px; }

.box {
    background:#fff;
    padding:20px;
    border-radius:10px;
    max-width:600px;
    margin:auto;
}

textarea {
    width:100%;
    height:120px;
    padding:10px;
    margin-top:10px;
}

button {
    margin-top:10px;
    padding:10px 20px;
    background:#16a34a;
    color:#fff;
    border:none;
}
</style>
</head>

<body>

<div class="box">
<h3>Reply to <?php echo $data['name']; ?></h3>

<p><b>Email:</b> <?php echo $data['email']; ?></p>
<p><b>Message:</b><br><?php echo $data['message']; ?></p>

<form method="POST" action="<?php echo $base_url; ?>admin/send_reply.php">
<input type="hidden" name="email" value="<?php echo $data['email']; ?>">
<input type="hidden" name="id" value="<?php echo $data['id']; ?>">

<textarea name="reply" placeholder="Type reply..." required></textarea>

<button type="submit">Send Reply</button>
</form>
</div>

</body>
</html>