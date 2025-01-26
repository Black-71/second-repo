
<?php
$conn = new mysqli("localhost", "root", "", "myDB2");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['add_user'])) {
  $firstname = $_POST['fname'];
  $lastname = $_POST['lname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $stmt = $conn->prepare("INSERT INTO users(fname,lname,email,phone) VALUES(?,?,?,?) ");
  $stmt->bind_param("ssss",$firstname,$lastname,$email,$phone);
  $stmt->execute();
  $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style type="text/css">
     form {
     margin-bottom: 20px; }
    form input {
     padding: 10px;
      margin: 5px; 
      width: calc(25% - 20px); }
    form button {
     padding: 10px 20px;
      background-color: #171f31;
       color: white;
        border: none; 
        cursor: pointer; }
    form button:hover {
     background-color: #4682B4; }
    .btn { 
      padding: 5px 10px;
     cursor: pointer; }
  </style>
</head>
<body>

<form method="POST" action="">
      <input type="text" name="fname" placeholder="First Name" required>
      <input type="text" name="lname" placeholder="Last Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <button type="submit" name="add_user">Add User</button>
    </form>

</body>
</html>