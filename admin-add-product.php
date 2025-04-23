<?php
require_once("admin-auth.php");
require_once("connect-db.php");
    ?>
<!DOCTYPE html>
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
                <fieldset>
                    <legend>Add product</legend>
                    <form action="admin-process-product.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <br>
                            <input type="text" class="form-control" name="name" required>
                            <br><br>
                            <label for="description">Description:</label>
                            <br>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter Description"required></textarea>
                            <br><br>
                            <label for="price">Price:</label>
                            <br>
                            <input type="number" step="0.01" class="form-control" name="price" required>
                            <br><br>
                            <label for="quantity">Quantity:</label>
                            <br>
                            <input type="number" class="form-control" name="quantity" required>
                            <br><br>
                            <label for="category">Category:</label>
                            <br>
                            <select class="form-control" name="category" required>
                                <option value="bars">Bars</option>
                                <option value="cereal">Cereal</option>
                            </select>
                            <br><br>
                            <label for="image">Image:</label>
                            <br>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                            <br><br>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                            <br><br>
                        </div>
                    </form>
                </fieldset>
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