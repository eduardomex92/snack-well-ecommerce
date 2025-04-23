<?php
require_once("admin-auth.php");
require_once("connect-db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    // Prepare and execute the DELETE statement
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':product_id', $productId, PDO::PARAM_INT);

    if ($statement->execute()) {
        // Redirect to confirmation page
        header("Location: admin-product-confirmation.php?status=deleted");
        exit();
    } else {
        header("Location: admin-product-confirmation.php?status=error");
        exit();
    }
} else {
    // Invalid request
    header("Location: admin-product-confirmation.php?status=error");
    exit();
}
