
<php
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