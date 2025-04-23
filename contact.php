<?php
session_start();
require_once("connect-db.php");

$feedback = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim(strtolower($_POST["email"]));
    $message = trim($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
        $statement = $db->prepare($sql);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":message", $message);

        if ($statement->execute()) {
            $feedback = "Thank you for contacting us! We'll be in touch shortly.";
        } else {
            $feedback = "There was a problem submitting your message. Please try again.";
        }
    } else {
        $feedback = "All fields are required.";
    }
}
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
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="contact-info">
                    <h4>Have a Question?</h4>
                    <p>We’re here to help! Fill out the form or reach us via phone or email. Our Customer Care Team is
                        available to help you get the best experience when shopping at SnackWell.
                        Please give our Team 24 hours to respond during business hours.
                        Our Business Hours
                        M-F 9am-5pm CT </p>
                    <br><br>
                    <img src="images/Logos_Icons/Icons/Phone-icon.jpg" alt="Phone" class="contact-icon">
                    <a>1-800-555-1234</a>
                    <br><br>
                    <img src="images/Logos_Icons/Icons/Mail-icon.jpg" alt="Email" class="contact-icon">
                    <a href="mailto:example@example.com?subject=Hello&body=I%20have%20a%20question.">Email Us</a>
                </div>
                <div class="contact-form">
                    <fieldset>
                        <legend>
                            <h4>Contact Us</h4>
                        </legend>

                        <?php if (!empty($feedback)): ?>
                            <div class="alert alert-info"><?php echo htmlspecialchars($feedback); ?></div>
                        <?php endif; ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <br>
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <br>
                                <label for="message">Message:</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <br><br>
                            </div>
                        </form>
                    </fieldset>
                </div>

            </div>
            <div class="col-md-2"></div>
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