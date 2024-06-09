<?php
include "connection.php";
?>


<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="Admin.css">
    <script src="validation.js"></script>
</head>
<body>
    <h2>Registration</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateRegistrationForm()">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <input type="submit" value="Register">
    </form>

    <?php
    session_start();

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Validate form data
        if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            echo "Please fill in all fields.";
        } elseif ($password !== $confirm_password) {
            echo "Password and Confirm Password do not match.";
        } else {
            // Connect to the database (using connection.php)
            require_once "connection.php";

            // Check if the email is already registered
            $query = "SELECT COUNT(*) FROM register WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_array($result);

            if ($row[0] > 0) {
                echo "Email is already registered.";
            } else {
                // Insert the user into the register table
                $query = "INSERT INTO `register` (`name_cust`, `email`, `password`) VALUES ('$name', '$email', '$password')";
                $result = mysqli_query($con, $query);

                if ($result) {
                    // Redirect to the login page
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Registration failed. Please try again.";
                }
            }
        }
    }
    ?>
    <p> <a href="index.php">Login here</a></p>
</body>
</html>