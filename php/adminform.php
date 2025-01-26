
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Form</title>
	<style>
		body{
			background-image: linear-gradient( #b4dce2,#efddcc,#e3e4a4,#f4d07c);
			background-repeat: no-repeat;
			display: flex;
			height: 100vh;
			margin: 0;
			justify-content: center;
			align-items: center;

		}
		form{
			background-color: rgba(205, 205, 205, 0.4);
			padding: 20px;
			border: 2px solid  white;
			border-radius: 5%;
			width: 450px;


		}
		form h1{
			text-align: center;
			margin-bottom: 20px;
			color: black;



		}
		form label{
			font-size: 20px;
			color: #444;

		}
		form input{
			padding-right: 2px;
			margin: 12px;
			width: 400px;
			height: 50px;
			border: 2px solid gray;
			border: 1px white;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;


		}
		 .error {
            color: red;
            font-size: 14px;
        }
        
		form button{
		background-image: linear-gradient(#b4dce2,#efddcc);
		padding: 5px;
		height: 15px;
		height: 35px;
        font-size: 20px;
        font-weight: bold;
       display: block;
       margin: 0 auto;
       width: 100px;
       border: 2px  white;
       border-radius: 15%;

		}
		form button:hover{
			background-image: linear-gradient(#efddcc,#b4dce2);


		}

	</style>
</head>
<body>
<?php
session_start();
$errors = [];
$mysqli = new mysqli("localhost", "root", "", "myDB2");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email)) {
        $errors['email'] = "Email is required!";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required!";
    }

    if (empty($errors)) {
        $stmt = $mysqli->prepare("SELECT password, id, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword, $id, $role);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $id;
                $_SESSION['role'] = $role;

                if ($role === 'admin') {
                    header("Location: /pages/dashboard.php");
                } else {
                    header("Location: /pages/dashboard.php");
                }
                exit();
            } else {
                $errors['login'] = "Incorrect password!";
            }
        } else {
            $errors['login'] = "No account found with that email!";
        }

        $stmt->close();
    }
}
?>

	<form  method="post">
		<h1> Login Form</h1>
		<label for="email">Your Email:</label>
		<input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required><br>
		 <?php if (isset($errors['email'])) echo "<div class='error'>{$errors['email']}</div>"; ?>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required><br>
		<?php if (isset($errors['password'])) echo "<div class='error'>{$errors['password']}</div>"; ?>
		<button type="submit">Login</button>
<?php if (isset($errors['login'])) echo "<p style='color: red;'>{$errors['login']}</p>"; ?>	</form>
    
</body>
</html>