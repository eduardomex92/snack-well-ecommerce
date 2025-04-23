<?php
session_start();

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }else if(isset($_COOKIE['guest_cart'])){
        $guestCart = json_decode($_COOKIE['guest_cart'], true);
        unset($guestCart[$productId]);
        setcookie('guest_cart', json_encode($guestCart), time() + 7 * 24 * 60 * 60, '/');
    }
}

header("Location: cart.php");
exit();
?>
