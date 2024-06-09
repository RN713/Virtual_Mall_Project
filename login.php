<?php
include "connection.php";
?>


<?php
  

  // Get login credentials from POST data
  $email = $_POST["email"];
  $password = $_POST["password"]; // No need for reference here

  // Prepare and execute SQL statement with hashed password comparison
  $sql = "SELECT * FROM register WHERE email = ? AND password = ?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("s", $email, $password); // Bind email and password directly
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Login successful, potentially add name to customer table here
    $name = $row["name"]; // Assuming a "name" column in register_table
    // ... Add name to customer table logic ...

    $response = ["success" => true];
  } else {
    $response = ["success" => false, "message" => "Invalid email or password."];
  }

  $con->close();
  echo json_encode($response);
?>
