<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "myDB2");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM users WHERE id=$id");
}

if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $stmt = $conn->prepare("UPDATE users SET fname=?, lname=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("ssssi", $firstname, $lastname, $email, $phone, $id);
    $stmt->execute();
    $stmt->close();
}

$users = $conn->query("SELECT * FROM users");
?>
<!<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style type="text/css">
    body{
      background-color: $f9f9f9;
       margin: 0; 
      padding: 0;
    }
     .container { 
      width: 80%;
     margin: auto;
      padding: 20px; 
      background: #fff;
       border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
    table {
     width: 100%; 
     border-collapse: collapse; 
     margin-top: 20px; }
    table, th, td { border: 1px solid #ccc;
     text-align: center; 
     padding: 10px; }
    th {
     background-color: #333; 
     color: #fff; }
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
    .btn.edit {
     background-color: #008080;
      color: white; 
      text-decoration: none;
      border: none; }
      .btn a{
        text-decoration:none;
        color: white;      }
    .btn.delete { background-color: #171f31;
     text-decoration:none ;
     color: white; 
     border: none; }
  </style>
</head>
<body>
  

    <!-- Users Table -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $users->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= $row['fname']; ?></td>
          <td><?= $row['lname']; ?></td>
          <td><?= $row['email']; ?></td>
          <td><?= $row['phone']; ?></td>
          <td>
            <form style="display:inline-block;" method="POST" action="">
              <input type="hidden" name="id" value="<?= $row['id']; ?>">
              <input type="hidden" name="fname" value="<?= $row['fname']; ?>">
              <input type="hidden" name="lname" value="<?= $row['lname']; ?>">
              <input type="hidden" name="email" value="<?= $row['email']; ?>">
              <input type="hidden" name="phone" value="<?= $row['phone']; ?>">
              <button class="btn edit" type="submit" name="edit_user"><a href="edit.php"> Edit</a></button>
            </form>
            <a class="btn delete" href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
