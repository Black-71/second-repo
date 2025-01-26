<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up</title>
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
        .success {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
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
include 'insert.php';
$message = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';

$isValid = true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!";
        $isValid = false;
    }

    // Password validation
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        $errors['password'] = "Password must be at least 8 characters long, include one uppercase letter, one special character, and one numeric digit.";
        $isValid = false;
    }

    if (!ctype_digit($phone)) {
        $errors['phone'] = "Phone number should only contain numeric values.";
        $isValid = false;
    }

    if ($isValid) {
        $message = "Registration Successful!";
    }
}
?>


	<form  method="post">
		<h1> SignUp Form</h1>
		<label for="fname">First Name:</label>
		<input type="text" name="fname" id="fname" required><br>
		<label for="fname">Last Name:</label>
		<input type="text" name="lname" id="lname" required><br>
		<label for="email">Your Email:</label>
		<input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        <?php if (isset($errors['email'])) echo "<div class='error'>{$errors['email']}</div>"; ?>
		<label for="password">Password:</label>
		<input type="text" name="password" id="password" required><br>
		<?php if (isset($errors['password'])) echo "<div class='error'>{$errors['password']}</div>"; ?>

        <label for="phone">Phone Num:</label>
		<input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required><br>
	    <?php if (isset($errors['phone'])) echo "<div class='error'>{$errors['phone']}</div>"; ?>
		<button type="submit">Register</button>
	    <?php if ($message) echo "<div class='success'>{$message}</div>"; ?>
	</form>
    
</body>
</html>