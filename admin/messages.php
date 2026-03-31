<?php
session_start();
include_once '../includes/db.php';
include_once '../config/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: " . $base_url . "admin/login.php");
    exit;
}

$result = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Messages</title>

<style>
body { font-family: Arial; background:#f9fafb; padding:20px; }
h2 { margin-bottom:20px; }

.table-box {
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

table { width:100%; border-collapse:collapse; }

th, td { padding:14px; text-align:left; }

th { background:#111827; color:#fff; }

tr { border-bottom:1px solid #eee; }

tr:hover { background:#f3f4f6; }

.status {
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.unread { background:#fee2e2; color:#dc2626; }
.read { background:#dbeafe; color:#2563eb; }
.replied { background:#dcfce7; color:#16a34a; }

.btn {
    text-decoration:none;
    padding:6px 10px;
    border-radius:6px;
    font-size:12px;
    margin-right:5px;
}

.btn-read { background:#2563eb; color:#fff; }
.btn-reply { background:#16a34a; color:#fff; }
.btn-delete { background:#dc2626; color:#fff; }

</style>
</head>

<body>

<h2>📩 Contact Messages</h2>

<div class="table-box">
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo substr($row['message'],0,50); ?>...</td>

<td>
<span class="status <?php echo $row['status']; ?>">
<?php echo $row['status']; ?>
</span>
</td>

<td>
<a class="btn btn-read"
href="<?php echo $base_url; ?>admin/mark_read.php?id=<?php echo $row['id']; ?>">
Read</a>

<a class="btn btn-reply"
href="<?php echo $base_url; ?>admin/reply.php?id=<?php echo $row['id']; ?>">
Reply</a>

<a class="btn btn-delete"
href="<?php echo $base_url; ?>admin/delete_message.php?id=<?php echo $row['id']; ?>">
Delete</a>
</td>
</tr>
<?php } ?>

</table>
</div>

</body>
</html>