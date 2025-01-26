<?php
$servername = "localhost";
$username = "root";
$password = "";

// Establish connection
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS myDB2";
if ($conn->query($sql) === TRUE) {
    echo "Database created or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db("myDB2");

// Check and add the 'role' column if it doesn't exist
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");
if ($result->num_rows === 0) {
    $alterQuery = "ALTER TABLE users ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user'";
    if ($conn->query($alterQuery) === TRUE) {
        echo "Column 'role' added successfully.<br>";
    } else {
        die("Error adding 'role' column: " . $conn->error);
    }
}

// Hash the password securely using PHP
$admin_password = password_hash("AdminPass123!", PASSWORD_DEFAULT);

// Insert admin user
$sql = "INSERT INTO users (fname, lname, email, password, phone, role) 
        VALUES ('Admin', 'User', 'admin@example.com', '$admin_password', '1234567890', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "Admin user added successfully.";
} else {
    echo "Error adding admin user: " . $conn->error;
}

$conn->close();
?>
