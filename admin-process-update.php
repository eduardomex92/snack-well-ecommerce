<?php
require_once("admin-auth.php");
require_once("connect-db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["product_id"]) && is_numeric($_POST["product_id"]) &&
        isset($_POST["description"]) &&
        isset($_POST["price"]) &&
        isset($_POST["stock_quantity"])
    ) {
        $productId = intval($_POST["product_id"]);
        $description = trim($_POST["description"]);
        $price = floatval($_POST["price"]);
        $stock = intval($_POST["stock_quantity"]);

        $sql = "UPDATE products 
                SET description = :description, price = :price, stock_quantity = :stock_quantity 
                WHERE product_id = :product_id";

        $statement = $db->prepare($sql);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':stock_quantity', $stock);
        $statement->bindValue(':product_id', $productId, PDO::PARAM_INT);

        if ($statement->execute()) {
            header("Location: admin-product-confirmation.php?status=updated");
            exit();
        } else {
            header("Location: admin-product-confirmation.php?status=error");
            exit();
        }
    } else {
        header("Location: admin-product-confirmation.php?status=error");
        exit();
    }
} else {
    // Invalid request
    header("Location: admin-product-confirmation.php?status=error");
    exit();
}
