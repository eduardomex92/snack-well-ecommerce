<?php
session_start();

require_once("connect-db.php");

$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim(strtolower($_POST["email"]));
    $testimonial = trim($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($testimonial)) {
        $sql = "INSERT INTO testimonials (name, email, message) VALUES (:name, :email, :message)";
        $statement = $db->prepare($sql);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":message", $testimonial);

        if($statement->execute()) {
            $message = "Thank you for your feedback";
        }else{
            $message = "Something went wrong. Please try again.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}

?>
<!DOCTYPE html>
<!-- Customer Login Page-->
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

        <!-- Testimonials Section -->
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="testimonials">
                    <h3>Testimonials</h3>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" required><br>

                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" required><br>

                        <label for="message">Your Testimonial:</label>
                        <textarea name="message" rows="5" class="form-control" required></textarea><br>

                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </form>

                    <hr>

                    <h4>What People Are Saying</h4>
                    <?php
                    $sql = "SELECT name, message, submitted_at FROM testimonials ORDER BY submitted_at DESC";
                    $statement = $db->prepare($sql);
                    $statement->execute();
                    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if ($results && count($results) > 0) {
                        foreach ($results as $row) {
                            echo "<div class='testimonial'>";
                            echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong> wrote:</p>";
                            echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
                            echo "<small>Posted on " . $row['submitted_at'] . "</small>";
                            echo "</div><hr>";
                        }
                    } else {
                        echo "<p>No testimonials yet. Be the first to leave one!</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <!-- Footer -->
        <div class="row">
            <div class="col-md-12">
                <?php include "footer.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>