
<?php

$host = 'localhost'; // Change this to your database host
$dbName = 'ccc457'; // Change this to your database name
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password

try {
    // Create a new PDO instance
    $con = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    
    // Set PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if connection fails
    echo "Connection failed: " . $e->getMessage();
    die();
}



// Function to sanitize user inputs
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Checking if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve user inputs
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    // Query to check if the email and password exist in the register table
    $query ="SELECT * FROM register WHERE email = :email AND password = :password";
    
    $stmt = $con->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    
    // Fetching the row from the register table
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Checking if the email and password exist in the register table
    if ($row) {
        // Retrieve the name_cust from the register table
        $name_cust = $row['name_cust'];
        
         // Deleting existing records from the name_customer table
         $deleteQuery = "DELETE FROM name_customer";
         $deleteStmt = $con->prepare($deleteQuery);
         $deleteStmt->execute();

        // Inserting the name_cust into the name_customer table
        $insertQuery = "INSERT INTO `name_customer` (`name_cust`) VALUES (:name_cust)";
        $insertStmt = $con->prepare($insertQuery);
        $insertStmt->bindParam(':name_cust', $name_cust);
        $insertStmt->execute();
        
        // Redirecting to home.php
        header("Location: home.php");
        exit();
    } else {
        echo "Email or password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="Admin.css">

    <script>
        function validateForm() {
    var email = document.forms["loginForm"]["email"].value;
    var password = document.forms["loginForm"]["password"].value;
    var errorMessage = document.getElementById("error-message");

    if (email === "" || password === "") {
        errorMessage.textContent = "Email and password are required.";
        errorMessage.style.display = "block";
        return false;
    } else {
        errorMessage.style.display = "none";
    }
}
    </script>
</head>
<body>
    <h2>Login Form</h2>
    <form name="loginForm" method="POST" action="" onsubmit="return validateForm()">
        <label>Email:</label>
        <input type="text" name="email" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" id ='sub' value="Submit">
    </form>
    <p>Not a member? <a href="register.php">Register here</a></p>
</body>
</html>