<?php
session_start();
include 'DBCONNECT.php'; // Your database connection file

// Store the intended destination URL
if (isset($_GET['redirect'])) {
	$_SESSION['redirect'] = $_GET['redirect'];
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$admin_email = $_POST['admin_email'];
	$admin_pass = $_POST['admin_pass'];
	
	// Query to check user credentials
	$stmt = $conn->prepare("SELECT admin_firstname, admin_lastname FROM admins WHERE admin_email = ? AND admin_pass = ?");
	$stmt->bind_param("ss", $admin_email, $admin_pass);
	$stmt->execute();
	$stmt->bind_result($admin_firstname, $admin_lastname);
	$stmt->fetch();
	$stmt->close();
	
	if ($admin_firstname) {
		$_SESSION['loggedin'] = true;
		$_SESSION['admin_email'] = $admin_email;
		$_SESSION['admin_firstname'] = $admin_firstname;
		$_SESSION['admin_lastname'] = $admin_lastname;
		
		// Redirect to the intended destination or index page if no destination is set
		$redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : 'DASHBOARD.php';
		unset($_SESSION['redirect']); // Clear the redirect session variable
		header('Location: ' . $redirect);
		exit();
	} else {
		echo '<p style="background-color: #A91D3A; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Invalid email or password.</p>';
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
		<link rel="stylesheet" href="../CSS/ADMINLOGIN.css">
		<link rel="icon" href="../IMAGES/logo.png">
		<title>GoBookIt | Admin Log In</title>
	</head>
	<body>
		<header>
			<a href="../INDEX.php" style="color: white; text-decoration: none;">
				<img src="../IMAGES/logo.png" alt="Logo" class="Logo">
				<h3>GoBookIt</h3>
			</a>
		</header>

		<div class="divider"></div>

		<div class="topnav">
			<a href="../INDEX.php"><b>HOME</b></a>
			<a href="CONTACTUS.php"><b>CONTACT US</b></a>
		</div>

		<div class="bgimage">
			<h1>Admin Log In</h1>
			<div class="form-container">
				
				<div class="login-form">
					<h2>Log In</h2>
					<form action="ADMINLOGIN.php" method="POST">
						<div class="form-group">
							<label for="admin_email">Email:</label>
							<input type="text" id="admin_email" name="admin_email" placeholder="Enter your email" required>
						</div>
						<div class="form-group">
							<label for="admin_pass">Password:</label>
							<input type="password" id="admin_pass" name="admin_pass" placeholder="Enter your password" required>
						</div>
						<br>
						<div class="form-actions">
							<button type="submit" class="btn-login" name="login">Log In</button>
						</div>
					</form>
				</div>
            </div>
			<br><br>
    	</div>
				<div class="divider"></div>

				<footer>
					<b>For more information, contact us at example@email.com or call us at +123456789.</b>
					<br><br>
					<b>© 2024 GoBookIt. All rights reserved.</b>
				</footer>
			</body>
		</html> 