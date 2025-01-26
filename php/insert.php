<?php
session_start(); // Start the session
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB2";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $role = 'user';

    // Validate input
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($phone)) {
        die("Error: All fields are required.");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Error: Email already exists. Please use a different email.";
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password, phone, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fname, $lname, $email, $password, $phone, $role);

    if ($stmt->execute()) {
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        header("Location: /pages/dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
