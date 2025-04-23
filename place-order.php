<?php
session_start();
require_once("connect-db.php");

if (!isset($_SESSION['customer_id']) || empty($_SESSION['cart']) || !isset($_POST['payment_method'])) {
    header("Location: cart.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];
$cartItems = $_SESSION['cart'];
$payment_method = $_POST['payment_method'];
$total = 0;
$shipping = 0;

try {
    $db->beginTransaction();

    // Create new cart
    $statement = $db->prepare("INSERT INTO cart (customer_id, status) VALUES (:customer_id, 'active')");
    $statement->execute([':customer_id' => $customer_id]);
    $cart_id = $db->lastInsertId();

    // prepare cart items insert
    $statementItem = $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, subtotal)
                                   VALUES (:cart_id, :product_id, :quantity, :subtotal)");

    foreach ($cartItems as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;

        $statementItem->execute([
            ':cart_id' => $cart_id,
            ':product_id' => $item['product_id'],
            ':quantity' => $item['quantity'],
            ':subtotal' => $subtotal
        ]);
    }

    // shipping logic
    if ($total < 25) {
        $shipping = 5;
    } else if ($total < 35) {
        $shipping = 3;
    }

    $total += $shipping;

    // Insert order
    $statementOrder = $db->prepare("INSERT INTO orders (customer_id, cart_id, total_price) 
                                    VALUES (:customer_id, :cart_id, :total_price)");
    $statementOrder->execute([
        ':customer_id' => $customer_id,
        ':cart_id' => $cart_id,
        ':total_price' => $total
    ]);
    $order_id = $db->lastInsertId();

    // Handle payment
    if ($payment_method === 'dummy') {
        $statementPay = $db->prepare("INSERT INTO payments (order_id, amount, payment_method, payment_status) 
                                      VALUES (:order_id, :amount, 'dummy', 'completed')");
        $statementPay->execute([
            ':order_id' => $order_id,
            ':amount' => $total
        ]);

        $db->commit();
        unset($_SESSION['cart']);
        header("Location: order-confirmation.php?order_id=$order_id");
        exit();

    } else if ($payment_method === 'paypal') {
        $db->commit();
        unset($_SESSION['cart']);

        $paypalUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        $businessEmail = "email@snackwell.net";

        echo "
        <form id='paypalForm' action='$paypalUrl' method='post'>
            <input type='hidden' name='cmd' value='_xclick'>
            <input type='hidden' name='business' value='$businessEmail'>
            <input type='hidden' name='item_name' value='Snack Well Order #$order_id'>
            <input type='hidden' name='amount' value='" . number_format($total, 2, '.', '') . "'>
            <input type='hidden' name='currency_code' value='USD'>
            <input type='hidden' name='return' value='http://snackwell.net/order-confirmation.php?order_id=$order_id'>
        </form>
        <script>document.getElementById('paypalForm').submit();</script>
        ";
        exit();
    }

} catch (Exception $e) {
    $db->rollBack();
    echo "Transaction failed: " . $e->getMessage();
}
?>
