<?php
session_start();
require_once("connect-db.php");

if (!isset($_SESSION['customer_id']) || empty($_SESSION['cart'])) {
    header("Location: customer-login.php");
    exit();
}

$cart = $_SESSION['cart'];
$total = 0;
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

        <!-- Checkout Section -->
        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-8">
                <h2 class="mt-4">Checkout</h2>
                <h4 class="mt-3">Order Summary</h4>
                <ul class="list-group mb-3">
                    <?php foreach ($cart as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <strong><?php echo $item['name']; ?></strong> x <?php echo $item['quantity']; ?>
                        </div>
                        <span>$<?php echo number_format($subtotal, 2); ?></span>
                    </li>
                    <?php endforeach; ?>

                    <?php
                    // Calculate shipping based on subtotal
                    $shipping = 0;
                    if ($total < 25) {
                        $shipping = 5;
                    } else if ($total < 35) {
                        $shipping = 3;
                    }
                    $grandTotal = $total + $shipping;
                    ?>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Shipping</span>
                        <span>$<?php echo number_format($shipping, 2); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <strong>Grand Total</strong>
                        <strong>$<?php echo number_format($grandTotal, 2); ?></strong>
                    </li>
                </ul>

                <!-- Payment Method Form -->
                <form action="place-order.php" method="POST">
                    <h5 class="mt-3">Choose Payment Method:</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="dummy" id="dummyPay" checked>
                        <label class="form-check-label" for="dummyPay">
                            Dummy Payment (for testing)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypalPay">
                        <label class="form-check-label" for="paypalPay">
                            PayPal Sandbox
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                </form>
            </div>

            <div class="col-md-2"></div>
        </div>

        <!-- Footer -->
        <div class="row mt-5">
            <div class="col-md-12">
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
