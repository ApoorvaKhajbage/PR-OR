<?php
session_start();
require_once "config.php";

// Check if admin is logged in
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
    exit;
}

// Logout functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit;
}

// Add transaction functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_transaction"])) {
    $car_type = $_POST["car_type"];
    $car_number = $_POST["car_number"];

    // Calculate toll fee based on car type (example calculation)
    $fee = 0;
    switch ($car_type) {
        case "Car":
            $fee = 5.00;
            break;
        case "Bus":
            $fee = 10.00;
            break;
        case "Truck":
            $fee = 15.00;
            break;
        // Add more cases for other vehicle types if needed
    }

    // Insert transaction into database
    $sql = "INSERT INTO transactions (car_type, car_number, amount) VALUES ('$car_type', '$car_number', $fee)";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
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
            max-width: 800px;
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

        h3 {
            margin-top: 30px;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        select, input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Admin</h2>

        <h3>Add New Transaction</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="car_type">Car Type:</label>
            <select id="car_type" name="car_type">
                <option value="Car">Car</option>
                <option value="Bus">Bus</option>
                <option value="Truck">Truck</option>
            </select><br>
            <label for="car_number">Car Number:</label>
            <input type="text" id="car_number" name="car_number" required><br>
            <label for="fee">Fee:</label>
            <input type="text" id="fee" name="fee" value="<?php echo isset($fee) ? $fee : ''; ?>" readonly><br>
            <button type="submit" name="add_transaction">Confirm Transaction</button>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
