<?php
session_start();
require_once "config.php";

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login_register.php");
    exit;
}

// Add Complaint
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_complaint"])) {
    $subject = $_POST["subject"];
    $description = $_POST["description"];
    $status = "pending";
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO complaints (subject, description, status, user_id) VALUES ('$subject', '$description', '$status', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        $add_complaint_success = "Complaint added successfully";
    } else {
        $add_complaint_error = "Error adding complaint: " . $conn->error;
    }
}

// Fetch User's Complaints
$user_complaints = [];
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM complaints WHERE user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_complaints[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

        .add-complaint-section,
        .user-complaints-section {
            margin-bottom: 20px;
        }

        .add-complaint-section h3,
        .user-complaints-section h3 {
            margin-bottom: 10px;
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
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

        .message {
            margin-top: 20px;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>

        <div class="add-complaint-section">
            <h3>Add Complaint</h3>
            <form action="" method="POST">
                <input type="text" name="subject" placeholder="Subject" required><br>
                <textarea name="description" placeholder="Description" rows="4" required></textarea><br>
                <button type="submit" name="add_complaint">Submit</button>
            </form>
            <?php if(isset($add_complaint_success)) { ?>
                <p><?php echo $add_complaint_success; ?></p>
            <?php } ?>
            <?php if(isset($add_complaint_error)) { ?>
                <p><?php echo $add_complaint_error; ?></p>
            <?php } ?>
        </div>

        <div class="user-complaints-section">
            <h3>Your Complaints</h3>
            <?php if(count($user_complaints) > 0) { ?>
                <?php foreach($user_complaints as $complaint) { ?>
                    <div class="complaint">
                        <h4>Subject: <?php echo $complaint['subject']; ?></h4>
                        <p>Description: <?php echo $complaint['description']; ?></p>
                        <p>Status: <?php echo $complaint['status']; ?></p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No complaints found</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
