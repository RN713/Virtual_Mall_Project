function validateLoginForm() {
    var email = document.forms[0].email.value;
    var password = document.forms[0].password.value;
    
    // Check for empty fields (existing logic)
    if (email.trim() === "" || password.trim() === "") {
      showError("Please fill in all fields.");
      return false;
    }
    
    // Prevent default form submission (prevents page refresh)
    event.preventDefault();
    
    // Hash password before sending
    const hashedPassword = password_hash(password, PASSWORD_DEFAULT);
    
    // Call server-side script for login verification
    login(email, hashedPassword);
    
    return false; // Don't submit the form yet (handled by login() response)
  }
  
  function login(email, hashedPassword) {
    // Use AJAX or fetch API to send login data to login.php
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) { // Success response
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          // Login successful, redirect to home.php
          window.location.href = "home.php";
        } else {
          showError(response.message); // Display error message from server
        }
      } else {
        showError("An error occurred during login.");
      }
    };
    const data = `email=${email}&password=${hashedPassword}`;
    xhr.send(data);
  }
  
  function showError(message) {
    const errorElement = document.getElementById("error-message");
    errorElement.textContent = message;
    errorElement.style.display = "block"; // Make the error message visible
  }
  