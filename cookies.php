<?php
session_start();

// Database connection code
$con = mysqli_connect('localhost', 'root', '', 'registration');

// Check connection
if (!$con) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $txtfname = $_POST['txtfname'];
    $txtmname = $_POST['txtmname'];
    $txtlname = $_POST['txtlname'];
    $txtpwd = $_POST['txtpwd'];

    // Database insert SQL code
    $sql = "INSERT INTO registration (fname, mname, lname, pwd) VALUES ('$txtfname', '$txtmname', '$txtlname', '$txtpwd')";

    // Insert into database 
    $rs = mysqli_query($con, $sql);

    if ($rs) {
        echo "Contact Record Inserted <br> <br>";
        // Set a cookie for the user's first name
        setcookie("user_fname", $txtfname, time() + (86400 * 30), "/", "", true, true);
    } else {
        echo "Error inserting record: " . mysqli_error($con) . "<br><br>";
    }
}

// Select and display all records from registration table
$sql_select = 'SELECT * FROM registration';
$retval = mysqli_query($con, $sql_select);

if (!$retval) {
    echo "Error fetching data: " . mysqli_error($con);
    exit();
}

echo "Fetched data successfully <br> <br>";
while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
    echo "ID: {$row['id']} <br>";
    echo "First Name: {$row['fname']} <br>";
    echo "Middle Name: {$row['mname']} <br>";
    echo "Last Name: {$row['lname']} <br>";
}

// Close the connection
session_unset();
session_destroy();
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookies Form</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
        }
        .container h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            color: #666666;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #dddddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        textarea {
            resize: none;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Form</h1>
        <?php
        if (isset($_COOKIE["user_fname"])) {
            echo "<p>Welcome back, " . $_COOKIE["user_fname"] . "!</p>";
        }
        ?>
        <form name="frmContact" method="post" action="">
            <label for="txtfname">First Name</label>
            <input type="text" name="txtfname" id="txtfname" required>
            
            <label for="txtmname">Middle Name</label>
            <input type="text" name="txtmname" id="txtmname">
            
            <label for="txtlname">Last Name</label>
            <input type="text" name="txtlname" id="txtlname" required>
            
            <label for="txtpwd">Password</label>
            <input type="password" name="txtpwd" id="txtpwd" required>
            
            <input type="submit" name="Submit" id="Submit" value="Submit">
        </form>
    </div>
</body>
</html>


<!-- database  
CREATE TABLE registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    mname VARCHAR(50),
    lname VARCHAR(50) NOT NULL,
    pwd VARCHAR(255) NOT NULL
);

if u r unsatisfied that the data fetched data and the form is on the same page then remove the top php code AND save in contact.php and then in cookies.php remove the top php code
-->