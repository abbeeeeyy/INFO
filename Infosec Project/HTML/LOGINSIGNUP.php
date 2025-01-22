<?php
session_start();
include 'DBCONNECT.php'; // Your database connection file

// Store the intended destination URL
if (isset($_GET['redirect'])) {
    $_SESSION['redirect'] = $_GET['redirect'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $user_email = $_POST['user_email'];
        $user_pass = $_POST['user_pass'];

        // Query to check user credentials
        $stmt = $conn->prepare("SELECT user_id, user_firstname, user_lastname FROM users WHERE user_email = ? AND user_pass = ?");
        $stmt->bind_param("ss", $user_email, $user_pass);
        $stmt->execute();
        $stmt->bind_result($user_id, $user_firstname, $user_lastname);
        $stmt->fetch();
        $stmt->close();

        if ($user_firstname) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_firstname'] = $user_firstname;
            $_SESSION['user_lastname'] = $user_lastname;
			$_SESSION['user_id'] = $user_id;

            // Redirect to the intended destination or index page if no destination is set
            $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : '../INDEX.php';
            unset($_SESSION['redirect']); // Clear the redirect session variable
            header('Location: ' . $redirect);
            exit();
        } else {
            echo '<p style="background-color: #A91D3A; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Invalid email or password.</p>';
        }
    } elseif (isset($_POST['signup'])) {
        // Handle sign-up
        $user_firstname = $_POST['signup_userfirstname'];
        $user_lastname = $_POST['signup_userlastname'];
        $user_email = $_POST['signup_useremail'];
        $user_pass = $_POST['signup_userpass'];
        $confirm_userpass = $_POST['confirm_userpass'];

        if ($user_pass !== $confirm_userpass) {
            echo '<p style="background-color: #A91D3A; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Password does not match.</p>';
        } else {
            // Query to insert new user
            $stmt = $conn->prepare("INSERT INTO users (user_firstname, user_lastname, user_email, user_pass) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $user_firstname, $user_lastname, $user_email, $user_pass);

            if ($stmt->execute()) {
				$user_id = $stmt->insert_id;
                // Set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_firstname'] = $user_firstname;
                $_SESSION['user_lastname'] = $user_lastname;
				$_SESSION['user_id'] = $user_id;

                // Redirect to the intended destination or index page if no destination is set
                $redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : '../INDEX.php';
                unset($_SESSION['redirect']); // Clear the redirect session variable
                header('Location: ' . $redirect);
                exit();
            } else {
                echo '<p style="background-color: #A91D3A; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Error: ' . $stmt->error . '</p>';
            }
            $stmt->close();
        }
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
    <link rel="stylesheet" href="../CSS/LOGINFORM.css">
    <link rel="icon" href="../IMAGES/logo.png">
    <title>GoBookIt | Login & Sign Up</title>
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
        <h1>LOG IN OR REGISTER</h1>
        <div class="form-container">

            <div class="login-form">
                <h2>Log In</h2>
                <form action="LOGINSIGNUP.php" method="post">
                    <div class="form-group">
                        <label for="user_email">Email:</label>
                        <input type="text" id="user_email" name="user_email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="user_pass">Password:</label>
                        <input type="password" id="user_pass" name="user_pass" placeholder="Enter your password" required>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn-login" name="login">Log In</button>
                    </div>
                </form>
            </div>

            <div class="signup-form">
                <h2>Sign Up</h2>
                <form action="LOGINSIGNUP.php" method="post">
                    <div class="form-group">
                        <label for="signup_userfirstname">First Name:</label>
                        <input type="text" id="signup_userfirstname" name="signup_userfirstname" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup_userlastname">Last Name:</label>
                        <input type="text" id="signup_userlastname" name="signup_userlastname" placeholder="Enter your last name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup_useremail">Email:</label>
                        <input type="email" id="signup_useremail" name="signup_useremail" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="signup_userpass">Password:</label>
                        <input type="password" id="signup_userpass" name="signup_userpass" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_userpass">Confirm Password:</label>
                        <input type="password" id="confirm_userpass" name="confirm_userpass" placeholder="Confirm your password" required>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn-signup" name="signup">Sign Up</button>
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
