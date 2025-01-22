<?php
session_start();
include 'DBCONNECT.php';

$user_firstname = isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] : '';
$user_lastname = isset($_SESSION['user_lastname']) ? $_SESSION['user_lastname'] : '';
$user_name = $user_firstname . ' ' . $user_lastname;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (!$user_id){
	die('User ID is missing from the session.');
}

$selected_movie = isset($_GET['movie']) ? $_GET['movie'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$phone_number = $_POST['phone_number'];
	$movie = $_POST['movie'];
	$booking_date = $_POST['booking_date'];
	$no_of_tickets = $_POST['no_of_tickets'];
	$payment_method = $_POST['payment_method'];

	// Retrieve the movie_id from the movies table based on the selected movie name
	$stmt_movie = $conn->prepare("SELECT movie_id FROM movies WHERE movie_name = ?");
	if (!$stmt_movie) {
		die('Prepare failed: ' . $conn->error);
	}
	$stmt_movie->bind_param("s", $movie);
	if(!$stmt_movie->execute()) {
		die('Execute failed: ' . $stmt_movie->error);
	}
	$stmt_movie->bind_result($movie_id);
	if (!$stmt_movie->fetch()) {
		die('Fetching movie_id failed.');
	}
	$stmt_movie->close();
	
	// Insert data into the Bookings table
	$stmt = $conn->prepare("INSERT INTO bookings (phone_number, booking_date, no_of_tickets, payment_method) VALUES (?, ?, ?, ?)");
	if (!$stmt) {
		die('Prepare failed: ' . $conn->error);
	}
	$stmt->bind_param("ssss", $phone_number, $booking_date, $no_of_tickets, $payment_method);
	
	if ($stmt->execute()) {
		// Retrieve the last inserted booking_id
		$booking_id = $conn->insert_id;
		
		// Insert data into the moviebookings table
		$stmt_mb = $conn->prepare("INSERT INTO moviebookings (movie_id, booking_id, user_id) VALUES (?, ?, ?)");
		if (!$stmt_mb) {
			die('Prepare failed: ' . $conn->error);
		}
		$stmt_mb->bind_param("iis", $movie_id, $booking_id, $user_id);
		
		if ($stmt_mb->execute()) {
			echo '<p style="background-color: #4CAF50; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Booking successful!</p>';
		} else {
			echo '<p style="background-color: #A91D3A; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Error: ' . $stmt_mb->error . '</p>';
		} 
		$stmt_mb->close();
	} else {
		echo '<p style="background-color: #A91D3A; margin: 0; text-align: center; font-family: \'Archivo\'; padding: 10px 0;">Error: ' . $stmt->error . '</p>';
	} $stmt->close();
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
		<link rel="stylesheet" href="../CSS/BOOKINGFORM.css">
		<link rel="icon" href="../IMAGES/logo.png">
		<title>GoBookIt | Booking Form</title>
	</head>
	<body>
		<header>
			<a href="../INDEX.php" style="color: white; text-decoration: none;">
				<img src = "../IMAGES/logo.png" alt = "Logo" class = "Logo">
				<h3>GoBookIt</h3>
			<a>
		</header>
		
		<div class="divider"></div>
		
		<div class="topnav">
			<a href="../INDEX.php"><b>HOME</b></a>
			<a href="CONTACTUS.php"><b>CONTACT US</b></a>
		</div>

        <script src="../JS/FORMSCRIPT.js"></script>

        <div class="bgimage">
			<h1>BUY TICKET</h1>
            <div class="form-container">
                <div>
                    <h2>BOOKING FORM</h2>
                    <form action="BOOKINGFORM.php" method="post" onsubmit="showThankYou();">
                        <div class="form-group">
							<label for="name">Name:</label>
							<input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($user_name); ?>">
						</div>
                        <div class="form-group">
							<label for="phone">Phone:</label>
							<input type="tel" id="phone_number" name="phone_number" required>
						</div>
                        <div class="form-group">
							<label for="movie">Select Movie:</label>
							<select id="movie" name="movie" required>
                            	<option value="">--Select Movie--</option>
								<option value="Wicked" <?php if($selected_movie == 'Wicked') echo 'selected'; ?>>Wicked</option>
								<option value="Smile 2" <?php if($selected_movie == 'Smile 2') echo 'selected'; ?>>Smile 2</option>
								<option value="Moana 2" <?php if($selected_movie == 'Moana 2') echo 'selected'; ?>>Moana 2</option>
								<option value="The Wild Robot" <?php if($selected_movie == 'The Wild Robot') echo 'selected'; ?>>The Wild Robot</option>
								<option value="The Idea of You" <?php if($selected_movie == 'The Idea of You') echo 'selected'; ?>>The Idea of You</option>
								<option value="Hello, Love, Again" <?php if($selected_movie == 'Hello, Love, Again') echo 'selected'; ?>>Hello, Love, Again</option>
								<option value="And The Breadwinner is..." <?php if($selected_movie == 'And The Breadwinner is...') echo 'selected'; ?>>And The Breadwinner is...</option>
								<option value="My Future You" <?php if($selected_movie == 'My Future You') echo 'selected'; ?>>My Future You</option>
								<option value="Hold Me Close" <?php if($selected_movie == 'Hold Me Close') echo 'selected'; ?>>Hold Me Close</option>
								<option value="Espantaho" <?php if($selected_movie == 'Espantaho') echo 'selected'; ?>>Espantaho</option>
								<option value="Mufasa" <?php if($selected_movie == 'Mufasa') echo 'selected'; ?>>Mufasa</option>
								<option value="Bocchi The Rock! Recap Part 2" <?php if($selected_movie == 'Bocchi The Rock! Recap Part 2') echo 'selected'; ?>>Bocci The Rock! Recap Part 2</option>
							</select>
                        </div>
                        <div class="form-group">
							<label for="date">Select Date:</label>
							<input type="date" id="booking_date" name="booking_date" required>
						</div>
                        <div class="form-group">
							<label for="tickets">Number of Tickets:</label>
							<select id="no_of_tickets" name="no_of_tickets" required onchange="updateSeatSelection()">
                            	<option value="">--Select Tickets--</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
                        </div>
                        <div id="seat-selection-container" class="seat-selection"></div>
                        <div class="form-group">
							<label for="payment">Payment Method:</label>
							<select id="payment_method" name="payment_method" required>
                            	<option value="">--Select Payment Method--</option>
								<option value="credit_card">Credit Card</option>
								<option value="debit_card">Debit Card</option>
								<option value="gcash">Gcash</option>
								<option value="maya">Maya</option>
							</select>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="reset" class="btn-cancel">Cancel</button>
                            <button type="submit" class="btn-book">Book Now</button>
                        </div>
                    </form>
                </div>
                <div class="image-container">
                    <img src="https://centurysquareluxurycinemas.com/wp-content/uploads/2023/08/Theater-1.jpeg" alt="Movie Image">
                </div>
            </div>
		</div>

        <div class="bgimage">
			<h1><br></h1>
		</div>

		<div class="divider"></div>

		<footer>
			<b>For more information, contact us at example@email.com or call us at +123456789.</b>
			<br><br>
			<b>© 2024 GoBookIt. All rights reserved.</b>
		</footer>
	</body>
</html>