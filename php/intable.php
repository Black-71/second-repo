<?php
include 'database.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create the 'users' table
$createUsersTable = "
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
)";
if ($conn->query($createUsersTable) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating 'users' table: " . $conn->error . "<br>";
}

// SQL to create the 'contacts' table
$createContactsTable = "
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
if ($conn->query($createContactsTable) === TRUE) {
    echo "Table 'contacts' created successfully.<br>";
} else {
    echo "Error creating 'contacts' table: " . $conn->error . "<br>";
}

$conn->close();
?>
