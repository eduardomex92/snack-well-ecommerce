<?php
require_once("admin-auth.php");
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
<div class="container my-5">
    <?php include "header.php"; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if ($status == "updated"): ?>
                <div class="alert alert-success">✅ Product updated successfully.</div>
            <?php elseif ($status == "deleted"): ?>
                <div class="alert alert-success">🗑️ Product deleted successfully.</div>
            <?php elseif ($status == "error"): ?>
                <div class="alert alert-danger">❌ Something went wrong. Please try again.</div>
            <?php else: ?>
                <div class="alert alert-warning">⚠️ Unknown status. No action was performed.</div>
            <?php endif; ?>

            <a href="admin-manage-products.php" class="btn btn-primary">Back to Manage Products</a>
        </div>
    </div>

    <?php include "footer.php"; ?>
</div>
</body>
</html>
