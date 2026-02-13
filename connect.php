<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize input
    $firstName = trim($_POST["first_name"]);
    $lastName = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Connect to MySQL
    $conn = new mysqli('localhost', 'root', 'test', 'ecommerce');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $hashedPassword);

    if ($stmt->execute()) {
        echo "✅ Registration successful!";
        // Optionally redirect to login or success page:
        // header("Location: success.html");
        // exit();
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "❌ Invalid request method.";
}
?>
