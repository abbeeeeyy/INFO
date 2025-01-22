<?php
session_start();

// Handle logout action
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	session_destroy();
	header('Location: INDEX.php');
	exit();
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
		<link rel="stylesheet" href="CSS/INDEX.css">
		<link rel="icon" href="IMAGES/logo.png">
		<title>GoBookIt | Home</title>
	</head>
	<body>
		<header>
			<a href="INDEX.php" style="color: white; text-decoration: none; width: 200px;">
				<img src = "IMAGES/logo.png" alt = "Logo" class = "Logo">
				<h3>GoBookIt</h3>
			</a>
			<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
				<b>Welcome, <?php echo htmlspecialchars($_SESSION['user_firstname']); ?>!
				<a href="INDEX.php?action=logout">Log Out</a></b>
			<?php else: ?>
				<b>Welcome, User!<a href="HTML/LOGINSIGNUP.php">Log In</a></b>
			<?php endif; ?>
		</header>
		
		<div class="divider"></div>
		
		<div class="topnav">
			<a href="HOME.php" class="active"><b>HOME</b></a>
			<a href="HTML/CONTACTUS.php"><b>CONTACT US</b></a>
		</div>
		
		<div class="bgimage">
			<h1 style="padding-bottom: 20px;">BUY YOUR TICKETS NOW</h1>
			<?php
				if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
					<h3>For bookings, visit <a href = "HTML/LOGINSIGNUP.php?redirect=BOOKINGFORM.php" style="color: white;">www.gobookit/bookingform.com</a></h3>
                <?php else: ?>
					<h3>For bookings, visit <a href = "HTML/BOOKINGFORM.php" style="color: white;">www.gobookit/bookingform.com</a></h3>
                <?php endif;
			?>  
			
		</div>
		
		<div class="movies">
			<h2>NOW SHOWING</h2>
            <div class="movie-posters">
				<div class="img-container">
					<img src="IMAGES/movieposter1.jpg" alt="Wicked"/>
					<img src="IMAGES/movieposter2.jpg" alt="Smile 2"/>
					<img src="IMAGES/movieposter3.jpg" alt="Moana 2"/>
					<img src="IMAGES/movieposter4.jpg" alt="The Wild Robot"/>
					<img src="IMAGES/movieposter5.jpg" alt="The Idea of You"/>
					<img src="IMAGES/movieposter6.jpg" alt="Hello, Love, Again"/>
				</div>
			</div>
			<div class="movie-titles">
				<b>Wicked</b>
				<b>Smile 2</b>
				<b>Moana 2</b>
				<b>The Wild Robot</b>
				<b>The Idea of You</b>
				<b style="margin-right: 0;">Hello, Love, Again</b>
			</div>
			<div class="buy">
                <button onclick="viewMovie('1')"><b>More Details</b></button>
                <button onclick="viewMovie('2')"><b>More Details</b></button>
                <button onclick="viewMovie('3')"><b>More Details</b></button>
                <button onclick="viewMovie('4')"><b>More Details</b></button>
                <button onclick="viewMovie('5')"><b>More Details</b></button>
                <button onclick="viewMovie('6')" style="margin-right: 0;"><b>More Details</b></button>
			</div>
            
            <br><br>

            <div class="movie-posters">
				<div class="img-container">
					<img src="IMAGES/movieposter7.jpg" alt="And The Breadwinner is..."/>
					<img src="IMAGES/movieposter8.jpg" alt="My Future You"/>
					<img src="IMAGES/movieposter9.jpg" alt="Hold Me Close"/>
					<img src="IMAGES/movieposter10.jpg" alt="Espantaho"/>
					<img src="IMAGES/movieposter11.jpg" alt="Mufasa"/>
					<img src="IMAGES/movieposter12.jpg" alt="Bocchi The Rock! Recap Part 2"/>
				</div>
			</div>
			<div class="movie-titles">
				<b>And The Breadwinner is...</b>
				<b>My Future You</b>
				<b>Hold Me Close</b>
				<b>Espantaho</b>
				<b>Mufasa</b>
				<b style="margin-right: 0;">Bocchi The Rock! Recap Part 2</b>
			</div>
			<div class="buy">
                <button onclick="viewMovie('7')"><b>More Details</b></button>
                <button onclick="viewMovie('8')"><b>More Details</b></button>
                <button onclick="viewMovie('9')"><b>More Details</b></button>
                <button onclick="viewMovie('10')"><b>More Details</b></button>
                <button onclick="viewMovie('11')"><b>More Details</b></button>
                <button onclick="viewMovie('12')" style="margin-right: 0;"><b>More Details</b></button>
			</div>
		</div>

		<div class="bgimage">
			<h1></h1>
		</div>

		<div class="divider"></div>

		<footer>
			<b>For more information, contact us at example@email.com or call us at +123456789.</b>
			<br><br>
			<b>© 2024 GoBookIt. All rights reserved.</b>
		</footer>

        <script>
            function viewMovie(movieId) {
                // Redirect to the movie details page with the movie ID as a query parameter
                window.location.href = 'HTML/ABOUTMOVIE.php?id=' + movieId;
                }
        </script>

	</body>
</html>