<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toll_tax_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!-- CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_type VARCHAR(50) NOT NULL,
    car_number VARCHAR(20) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(10, 2),
    paid BOOLEAN DEFAULT 0
); 

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', 'admin_password');

-->

