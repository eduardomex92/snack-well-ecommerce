<?php
// index.php
// Home page for the website
session_start();

//If user is logged in, redirect to my-account.php
if (isset($_SESSION['customer_id'])) {
    header("Location: my-account.php");
    exit();
}

require_once("connect-db.php");

$sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
$statement = $db->prepare($sql);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>
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

        <!-- Carousel -->
        <div class="row my-4">
            <div class="col-12">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($products as $key => $product) { ?>
                            <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>">
                                <a href="product-details.php?id=<?php echo $product['product_id']; ?>">
                                    <img src="images/<?php echo $product['image_url']; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- deals banner -->
        <div class="row">
            <div class="col-12">
                <div class="deals-banner text-center fw-bold">
                    Deals On Meals
                    <br>

                </div>
            </div>
        </div>

        <!-- best sellers -->
        <div class="row my-4">
            <div class="col-12">
                <div class="best-sellers">
                    <h3>Best Sellers</h3>
                    <div class="product-grid d-flex justify-content-center flex-wrap gap-4 mt-4">
                    <a href="product-details.php?id=5" class="text-decoration-none text-dark">
                        <div class="product">
                            <img src="images/bars/bar4.jpeg" alt="ChocoChip Bar">
                            <div class="product-name">CocoaCoat Bar</div>
                        </div>
                    </a>
                    <a href="product-details.php?id=2" class="text-decoration-none text-dark">
                        <div class="product">
                            <img src="images/cereal/cereal1.jpeg" alt="Fruits/Nuts Bowl">
                            <div class="product-name">Choco-Flake</div>
                        </div>
                    </a>
                    <a href="product-details.php?id=7" class="text-decoration-none text-dark">
                        <div class="product">
                            <img src="images/bars/bar6.jpeg" alt="SweetGrain Bar">
                            <div class="product-name">Sweet Strawberry Crunch</div>
                        </div>
                    </a>
                    <a href="product-details.php?id=22" class="text-decoration-none text-dark">
                        <div class="product">
                            <img src="images/cereal/cereal2.jpeg" alt="Apple Snack">
                            <div class="product-name">Golden Crunch</div>
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <div class="row">
            <div class="col-12">
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>

</body>
</html>
