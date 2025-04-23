<?php
session_start();
require_once("connect-db.php");

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($productId > 0 && $quantity > 0) {
        // Get the products data from the DB
        $sql = "SELECT * FROM products WHERE product_id = :product_id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':product_id', $productId);
        $statement->execute();
        $product = $statement->fetch();
        $statement->closeCursor();

        if ($product) {
            $item = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'quantity' => $quantity
            ];

            if (isset($_SESSION['customer_id'])) {
                // SESSION cart
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = $item;
                }

            } else {
                // COOKIE cart
                $guestCart = [];

                if (isset($_COOKIE['guest_cart'])) {
                    $guestCart = json_decode($_COOKIE['guest_cart'], true);
                }

                if (isset($guestCart[$productId])) {
                    $guestCart[$productId]['quantity'] += $quantity;
                } else {
                    $guestCart[$productId] = $item;
                }

                // Save guest cart for 7 days
                setcookie('guest_cart', json_encode($guestCart), time() + (7 * 24 * 60 * 60), "/");
            }
        }
    }
}

header("Location: cart.php");
exit();
?>
