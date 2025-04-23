<?php
require_once("admin-auth.php");
require_once("connect-db.php");
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $categoryFolder = $_POST['category'];

    if($categoryFolder == "bars"){
        $categoryId = 1;
    } elseif($categoryFolder == "cereal"){
        $categoryId = 2;
    } else {
        echo "Invalid category.";
        exit;
    }

    // File handling
    $image = $_FILES['image'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowedTypes)) {
        die("Unsupported image type. Only JPG, PNG, and GIF are allowed.");
    }
    $imageName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", basename($image['name']));
    $targetDir = "images/" . $categoryFolder . "/";
    $targetFile = $targetDir . $imageName;

    // Move uploaded file to your folder
    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        // Save product in the database
        $imagePath = "/" . $categoryFolder . "/" . $imageName;

        $sql = "INSERT INTO products (name, description, price, stock_quantity, image_url, category_id)
                VALUES (:name, :description, :price, :quantity, :image_url, :category_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description); // Assuming you want to save description too
        $stmt->bindValue(':quantity', $quantity); // Assuming you want to save quantity too
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':category_id', $categoryId); // Adjust if you use numeric IDs
        $stmt->bindValue(':image_url', $imagePath);
        $stmt->execute();
        $stmt->closeCursor();

        $message = "Product added successfully!";
        ?>
        <script>
            setTimeout(function() {
                window.location.href = "admin-add-product.php";
            }, 3000);
        </script>
        <?php
    } else {
        $message=  "Error uploading image.";
    }
}
?>
<?php
session_start()
    ?>
<!DOCTYPE html>
<!-- Home Page-->
<html lang="en">

<?php include "includes/head.php"; ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-12">
                <?php include "header.php"; ?>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php include "footer.php"; ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>

</html>