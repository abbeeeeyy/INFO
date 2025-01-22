<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
		<link rel="stylesheet" href="../CSS/ABOUTMOVIE.css">
		<link rel="icon" href="../IMAGES/logo.png">
		<title>GoBookIt | Movie Details</title>
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

        <?php
        include 'DBCONNECT.php';

            if (isset($_GET['id'])) {
                $movieId = $_GET['id'];

                if(!is_numeric($movieId)){
                    die('Invalid movie ID.');
                }

                $stmt = $conn->prepare("
                    SELECT
                        m.movie_name,
                        m.poster_link,
                        m.trailer_link,
                        m.description,
                        GROUP_CONCAT(DISTINCT d.director_name SEPARATOR ', ') AS director,
                        GROUP_CONCAT(DISTINCT c.cast_name SEPARATOR ', ') AS cast,
                        m.runtime,
                        GROUP_CONCAT(DISTINCT g.genre_name SEPARATOR ', ') AS genre
                    FROM 
                        aboutmovie am
                    JOIN
                        movies m ON am.movie_id = m.movie_id
                    JOIN
                        directors d ON FIND_IN_SET(d.director_id, am.director_id)
                    JOIN
                        casts c ON FIND_IN_SET(c.cast_id, am.cast_id)
                    JOIN
                        genres g ON am.genre_id = g.genre_id
                    WHERE
                        am.movie_id = ?
                ");

                if (!$stmt){
                    die('Prepare failed: ' . $conn->error);
                }

                $stmt->bind_param("i", $movieId);
                
                if(!$stmt->execute()){
                    die('Execute failed: ' . $stmt->error);
                }

                $stmt->bind_result($movie_name, $poster_link, $trailer_link, $description, $director, $cast, $runtime, $genre);

                if($stmt->fetch()){
                    echo "<div class=\"movies\">";
                    echo "<h2>" . htmlspecialchars($movie_name) . "</h2>";
                    echo "<div class=\"media\">";
                    echo "<img src=\"../IMAGES/" . htmlspecialchars($poster_link) . ".jpg\" alt=" . htmlspecialchars($movie_name) . "/>";
                    echo "<iframe src=\"https://www.youtube.com/embed/" . htmlspecialchars($trailer_link). "autoplay=1&mute=1\"></iframe>";
                    echo "</div>";
                    echo "<p>" . htmlspecialchars($description) . "</p>";
                    echo "<div class=\"content\">";
                    echo "<div class=\"content-left\">";
                    echo "<p>Director:</p>";
                    echo "<b>" . str_replace(', ', ', ', htmlspecialchars($director)) . "</b>";
                    echo "<p>Cast:</p>";
                    echo "<b>" . str_replace(', ', ', ', htmlspecialchars($cast)) . "</b>";
                    echo "</div>";
                    echo "<div class=\"content-right\">";
                    echo "<p>Runtime:</p>";
                    echo "<b>" . htmlspecialchars($runtime) . "</b>";
                    echo "<p>Genre/s:</p>";
                    echo "<b>" . str_replace(', ', ', ', htmlspecialchars($genre)) . "</b>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class=\"buy\">";
                    echo "<a href=\"../INDEX.php\"><b>Back to list</b></a>";
                    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
				        <a href="LOGINSIGNUP.php?redirect=BOOKINGFORM.php&movie=<?php echo urlencode($movie_name); ?>"><b>BUY TICKETS</b></a>
                    <?php else: ?>
                        <a href="BOOKINGFORM.php?movie=<?php echo urlencode($movie_name); ?>"><b>BUY TICKETS</b></a>
                    <?php endif;    
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<p>Movie not found.</p>";
                }

                $stmt->close();
            } else {
                echo "<p>No movie ID provided.</p>";
            }
            $conn->close();
        ?>

        <div class="divider"></div>

        <footer>
            <b>For more information, contact us at example@email.com or call us at +123456789.</b>
            <br><br>
            <b>© 2024 GoBookIt. All rights reserved.</b>
        </footer>

	</body>
</html>