<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaint_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!-- CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);
CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('pending', 'resolved') NOT NULL DEFAULT 'pending',
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
); 
INSERT INTO users (username, email, password, role) 
VALUES ('admin', 'admin@example.com', 'admin_password', 'admin');

-->
