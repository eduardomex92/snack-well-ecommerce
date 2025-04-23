<?php
session_start();
$user_id = $_SESSION["customer_id"];

require_once("connect-db.php");

# Get the user's current information
$sql = "SELECT * FROM customer WHERE customer_id = :customer_id";
$statement = $db->prepare($sql);
$statement->bindValue(":customer_id", $user_id);
if($statement->execute()){
    $user = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    $message = "<h3>Update Account Information</h3>";
}else{
    $message = "Error fetching user information";
}
?>
<!DOCTYPE html>
<!-- Update Account Page-->
<?php include "includes/head.php"; ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php include "header.php";?>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <fieldset>
                    <legend>
                        <h2>Update Account Information</h2>
                    </legend>
                    <form action="process-customer-update.php" method="post">
                        <?php foreach($user as $u){?>
                        <input type="hidden" name="customer_id" value="<?php echo $u["customer_id"];?>">
                        <label>First Name:</label>
                        <br>
                        <input type="text" id="cFirstName" name="fName" value="<?php echo $u["fName"];?>" required>
                        <br>
                        <label>Last Name:</label>
                        <br>
                        <input type="text" id="cLastName" name="lName" value="<?php echo $u["lName"];?>" required>
                        <br>
                        <label>Phone:</label>
                        <br>
                        <input type="text" id="cPhone" name="phone" value="<?php echo $u["phone"];?>" required>
                        <br>
                        <label>Address:</label>
                        <br>
                        <input type="text" id="cAddress" name="address" value="<?php echo $u["address"];?>" required>
                        <br>
                        <label>City:</label>
                        <br>
                        <input type="text" id="cCity" name="city" value="<?php echo $u["city"];?>" required>
                        <br>
                        <label>State:</label>
                        <br>
                        <input type="text" id="cState" name="state" value="<?php echo $u["state"];?>" required>
                        <br>
                        <label>Zip:</label>
                        <br>
                        <input type="text" id="cZip" name="zip" value="<?php echo $u["zip"];?>" required>
                        <br>
                        <label>E-mail</label>
                        <br>
                        <input type="email" id="cEmail" name="email" value="<?php echo $u["email"];?>" required>
                        <span id="email-status"></span>
                        <br>
                        <label>Username:</label>
                        <br>
                        <span><?php echo $u["username"];?></span>
                        <br>
                        <label for="password">Password:</label>
                        <br>
                        <input type="password" id="password" name="password" >
                        <br>
                        <label for="password">Confirm Password:</label>
                        <br>
                        <input type="password" id="confirmPassword" name="cPassword" >
                        <span id="password-status"></span>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary">Update Account</button>
                        <br>
                        </form>
                        <a href="customer-account.php">Cancel</a>
                        <br><br>
                        <?php }?>
                </fieldset>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php include "footer.php";?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>
</html>