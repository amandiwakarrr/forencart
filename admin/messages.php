<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/includes/admin-header.php";

$messages = mysqli_query($conn, "
    SELECT * FROM contacts
    ORDER BY id DESC
");
?>

<main class="admin-content">

    <h1>📩 Contact Messages</h1>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php if (mysqli_num_rows($messages) > 0) { ?>
            <?php while ($m = mysqli_fetch_assoc($messages)) { ?>
            <tr>
                <td>#<?php echo $m['id']; ?></td>
                <td><?php echo $m['name']; ?></td>
                <td><?php echo $m['email']; ?></td>
                <td><?php echo substr($m['message'], 0, 50); ?>...</td>

                <td>
                    <span class="status <?php echo $m['status']; ?>">
                        <?php echo ucfirst($m['status']); ?>
                    </span>
                </td>

                <td>
                    <a class="btn btn-read"
                       href="<?php echo $base_url; ?>admin/mark_read.php?id=<?php echo $m['id']; ?>">
                        Read
                    </a>

                    <a class="btn btn-reply"
                       href="<?php echo $base_url; ?>admin/reply.php?id=<?php echo $m['id']; ?>">
                        Reply
                    </a>

                    <a class="btn btn-delete"
                       href="<?php echo $base_url; ?>admin/delete_message.php?id=<?php echo $m['id']; ?>"
                       onclick="return confirm('Delete this message?')">
                        Delete
                    </a>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">No messages found.</td>
            </tr>
        <?php } ?>

    </table>

</main>

</body>
</html>