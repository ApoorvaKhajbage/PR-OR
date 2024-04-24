
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bookstore</h1>

        <?php
        session_start();
        $conn = mysqli_connect('localhost', 'root', '', 'bookstore');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Handle user registration
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
            if (mysqli_query($conn, $sql)) {
                echo "<p>Registration successful. Please login.</p>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        // Handle user login
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username;
                } else {
                    echo "<p>Incorrect password.</p>";
                }
            } else {
                echo "<p>User not found.</p>";
            }
        }

        // Logout functionality
        if (isset($_POST['logout'])) {
            session_unset();
            session_destroy();
        }

        // Display login or logout form based on session
        if (isset($_SESSION['username'])) {
            echo "<form method='post'><input type='submit' name='logout' value='Logout'></form>";

            // Display books catalog
            $sql = "SELECT * FROM books";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Book Name</th><th>Author</th><th>Price</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row['book_name'] . "</td><td>" . $row['author'] . "</td><td>" . $row['price'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No books found.</p>";
            }
        } else {
            echo "<form method='post'>
                <label for='username'>Username:</label>
                <input type='text' id='username' name='username' required>
                <label for='password'>Password:</label>
                <input type='password' id='password' name='password' required>
                <input type='submit' name='login' value='Login'>
                </form>";

            echo "<p>Don't have an account? <a href='#' onclick='toggleForm()'>Register here</a></p>";

            // Registration form (hidden by default)
            echo "<form method='post' id='registerForm' style='display:none;'>
                <label for='regUsername'>Username:</label>
                <input type='text' id='regUsername' name='username' required>
                <label for='regPassword'>Password:</label>
                <input type='password' id='regPassword' name='password' required>
                <input type='submit' name='register' value='Register'>
                </form>";
        }

        mysqli_close($conn);
        ?>

        <script>
            function toggleForm() {
                var form = document.getElementById('registerForm');
                form.style.display = (form.style.display == 'none') ? 'block' : 'none';
            }
        </script>
    </div>
</body>
</html>


<!-- // CREATE TABLE users (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(255) NOT NULL UNIQUE,
//     password VARCHAR(255) NOT NULL
// );

// CREATE TABLE books (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     book_name VARCHAR(255) NOT NULL,
//     author VARCHAR(255) NOT NULL,
//     price DECIMAL(10, 2) NOT NULL
// ); -->
