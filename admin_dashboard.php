<?php
session_start();
require_once "config.php";
// logout 
if(isset($_POST["logout"])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login_register.php");
    exit;
}
// Admin Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["admin_login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["username"] = $username;
        $_SESSION["role"] = "admin";
    } else {
        $login_error = "Invalid username or password";
    }
}

// Resolve Complaint
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resolve_complaint"])) {
    $complaint_id = $_POST["complaint_id"];

    $sql = "UPDATE complaints SET status='resolved' WHERE id='$complaint_id'";
    if ($conn->query($sql) === TRUE) {
        $resolve_success = "Complaint resolved successfully";
    } else {
        $resolve_error = "Error resolving complaint: " . $conn->error;
    }
}

// Fetch Complaints
$complaints = [];
if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
    $sql = "SELECT * FROM complaints";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $complaints[] = $row;
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
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .complaint {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .complaint h4 {
            margin: 0;
            color: #007bff;
        }

        .complaint p {
            margin: 5px 0;
        }

        .resolve-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .resolve-btn:hover {
            background-color: #218838;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            color: #333;
        }

        .login-section {
            text-align: center;
        }

        .login-section input {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-section button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-section button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if(!isset($_SESSION["username"])) { ?>
            <div class="login-section">
                <h2>Admin Login</h2>
                <form action="" method="POST">
                    <input type="text" name="username" placeholder="Username" required><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <button type="submit" name="admin_login">Login</button>
                </form>
                <!-- Link for admin login -->
            <p>Not an admin? <a href="login_register.php">Click here to log in as a user</a></p>
                <?php if(isset($login_error)) { ?>
                    <p><?php echo $login_error; ?></p>
                <?php } ?>
            </div>
        <?php } else { ?>
            <!-- Logout button -->
        <form action="" method="post" style="text-align: right; margin-bottom: 20px;">
            <button type="submit" name="logout">Logout</button>
        </form>
            <h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>
            <?php if($_SESSION["role"] == "admin") { ?>
                <?php if(count($complaints) > 0) { ?>
                    <?php foreach($complaints as $complaint) { ?>
                        <div class="complaint">
                            <h4>Subject: <?php echo $complaint['subject']; ?></h4>
                            <p>Description: <?php echo $complaint['description']; ?></p>
                            <p>Status: <?php echo $complaint['status']; ?></p>
                            <?php if($complaint['status'] == 'pending') { ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="complaint_id" value="<?php echo $complaint['id']; ?>">
                                    <button type="submit" name="resolve_complaint" class="resolve-btn">Resolve</button>
                                </form>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No complaints found</p>
                <?php } ?>
            <?php } else { ?>
                <p>You are not authorized to access this page.</p>
            <?php } ?>
            <?php if(isset($resolve_success)) { ?>
                <p class="message"><?php echo $resolve_success; ?></p>
            <?php } ?>
            <?php if(isset($resolve_error)) { ?>
                <p class="message"><?php echo $resolve_error; ?></p>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>

                    
