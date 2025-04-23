<?php
require_once("admin-auth.php");
require_once("connect-db.php");

// get contact messages
$sql = "SELECT name, email, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC";
$statement = $db->prepare($sql);
$statement->execute();
$contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-md-12">
                <?php include "header.php"; ?>
            </div>
        </div>

        <!-- Contact Messages Section -->
        <div class="row mt-4 mb-4">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>Customer Contact Messages</h3>
                <?php if (count($contacts) > 0): ?>
                    <?php foreach ($contacts as $c): ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <strong><?php echo htmlspecialchars($c['name']); ?></strong> (<?php echo htmlspecialchars($c['email']); ?>)
                                <span class="float-end"><?php echo $c['submitted_at']; ?></span>
                            </div>
                            <div class="card-body">
                                <p><?php echo nl2br(htmlspecialchars($c['message'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No contact messages yet.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-2"></div>
        </div>

        <!-- Footer -->
        <div class="row">
            <div class="col-md-12">
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
