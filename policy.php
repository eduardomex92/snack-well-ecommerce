<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="container">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <?php include "header.php"; ?>
            </div>
        </div>

        <!-- Policy Section -->
        <div class="row justify-content-center my-5">
            <div class="col-lg-10">
                <div class="p-4 bg-light rounded shadow-sm">
                    <h2 class="mb-4 text-center">Snack Well Policies</h2>
                    <ol>
                        <li>
                            <strong>Shipping Policy</strong>
                            <ul>
                                <li>We offer fast and reliable shipping across the United States.</li>
                                <li>Orders are typically processed within 1-2 business days.</li>
                                <li>Standard shipping takes 3-7 business days, while expedited shipping takes 1-3 business days.</li>
                                <li>Free shipping is available on orders over $50.</li>
                                <li>Tracking information will be provided once your order is shipped.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Return & Refund Policy</strong>
                            <ul>
                                <li>Due to the nature of our products, we do not accept returns on opened items.</li>
                                <li>If your order arrives damaged, incorrect, or defective, please contact us within 7 days of delivery.</li>
                                <li>Refunds or replacements will be issued upon verification of the issue.</li>
                                <li>To request a refund, email <a href="mailto:support@snackwell.com">support@snackwell.com</a> with your order number and photos of the product.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Subscription Policy</strong>
                            <ul>
                                <li>Customers can subscribe to receive their favorite snacks on a recurring basis.</li>
                                <li>Subscriptions can be modified or canceled anytime before the next billing cycle.</li>
                                <li>Changes to subscriptions must be made at least 48 hours before the scheduled renewal date.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Payment Policy</strong>
                            <ul>
                                <li>We accept major credit/debit cards, PayPal, and other secure payment methods.</li>
                                <li>All transactions are encrypted and processed securely.</li>
                                <li>Payment is required in full before orders are shipped.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Allergy & Ingredient Information</strong>
                            <ul>
                                <li>Snack Well is committed to transparency regarding ingredients and potential allergens.</li>
                                <li>Each product page includes detailed ingredient lists and allergen warnings.</li>
                                <li>If you have dietary restrictions, please review the ingredient details before purchasing.</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Privacy Policy</strong>
                            <ul>
                                <li>We respect your privacy and do not share your personal information with third parties.</li>
                                <li>Information collected during checkout is used solely for order processing and customer service.</li>
                                <li>For more details, refer to our Privacy Policy section.</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="row">
            <div class="col-12">
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
