<?php
session_start();

include 'DBCONNECT.php';

$result = $conn->query("SELECT
							m.movie_id,
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
						GROUP BY
							m.movie_id");

// Handle logout action
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
	session_destroy();
	header('Location: ../INDEX.php');
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
		<link rel="stylesheet" href="../CSS/DASHBOARD.css">
		<link rel="icon" href="../IMAGES/logo.png">
		<title>GoBookIt | Movies</title>
	</head>
	<body>
		<header>
			<a href="DASHBOARD.php" style="color: white; text-decoration: none; width: 200px;">
				<img src = "../IMAGES/logo.png" alt = "Logo" class = "Logo">	
				<h3>GoBookIt</h3>
			</a>
			<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
				<b>Welcome, Admin <?php echo htmlspecialchars($_SESSION['admin_firstname']); ?>!
				<a href="../INDEX.php?action=logout">Log Out</a></b>
			<?php endif; ?>
		</header>
		
		<div class="divider"></div>

		<div class="topnav">
			<a href="DASHBOARD.php" class="active"><b>MOVIES</b></a>
			<a href="BOOKINGS.php"><b>BOOKINGS</b></a>
		</div>

		<div class="bgimage">
			<h1 style="padding-bottom: 30px;">ADMIN DASHBOARD</h1>
		</div>

		<br><br>
        <table border="1">
			<tr>
				<th>Movie name</th>
				<th>Poster link</th>
				<th>Trailer link</th>
				<th>Description</th>
				<th>Director/s</th>
				<th>Cast</th>
				<th>Runtime</th>
				<th>Genre/s</th>
				<th>Actions</th>
			</tr>
			<?php while($row = $result->fetch_assoc()): ?>
			<tr>
				<td><?php echo $row['movie_name']; ?></td>
				<td><?php echo $row['poster_link']; ?></td>
				<td><?php echo $row['trailer_link']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td><?php echo $row['director']; ?></td>
				<td><?php echo $row['cast']; ?></td>
				<td><?php echo $row['runtime']; ?></td>
				<td><?php echo $row['genre']; ?></td>
				<td>
					<a href="EDITMOVIEINFO.php?id=<?php echo $row['movie_id']; ?>">Edit</a>
					<a href="DELETEMOVIEINFO.php?id=<?php echo $row['movie_id']; ?>" onclick="return confirm('Are you sure you want to delete this movie?');">Delete</a>
				</td>
			</tr>
			<?php endwhile; ?>
			</table>

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