<?php
session_start();


$host = 'localhost';
$username = 'root'; 
$password = '12345';
$dbname = 'test1'; 

$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['Username'];
    $pass = $_POST['Password'];

    
    $user = $conn->real_escape_string($user);
    $pass = $conn->real_escape_string($pass);

    
    $sql = "SELECT id, username, password FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
       
        if (password_verify($pass, $row['password'])) {
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: success.html"); 
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="Username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="Password" required>
            
            <button type="submit">Login</button>
        </form>
        <div class="forgot-password">
            <a href="#">Forgot password?</a>
        </div>
    </div>

</body>
</html>
