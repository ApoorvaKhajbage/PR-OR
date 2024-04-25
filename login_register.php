<?php
session_start();
require_once "config.php";

// User Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $row["role"];
        header("Location: user_dashboard.php");
        exit;
    } else {
        $login_error = "Invalid username or password";
    }
}

// User Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $role = "user";

    $check_sql = "SELECT * FROM users WHERE username='$username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $registration_error = "Username already exists";
    } else {
        $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";

        if ($conn->query($sql) === TRUE) {
            $registration_success = "User registered successfully";
        } else {
            $registration_error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 400px;
    margin: 100px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

input[type="text"],
input[type="password"],
input[type="email"],
button {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

p {
    margin-top: 20px;
    text-align: center;
    color: #333;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="login-section">
            <h2>User Login</h2>
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <button type="submit" name="login">Login</button>
            </form>
            <p>Don't have an account? <a href="#register">Register here</a></p>

            <?php if(isset($login_error)) { ?>
                <p><?php echo $login_error; ?></p>
            <?php } ?>
        </div>

        <div class="register-section" id="register">
            <h2>User Registration</h2>
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <button type="submit" name="register">Register</button>
            </form>

            <?php if(isset($registration_success)) { ?>
                <p><?php echo $registration_success; ?></p>
            <?php } ?>
            <?php if(isset($registration_error)) { ?>
                <p><?php echo $registration_error; ?></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
