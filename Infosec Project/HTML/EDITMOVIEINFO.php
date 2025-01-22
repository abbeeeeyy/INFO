<?php
include 'DBCONNECT.php'; // Your database connection file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch movie data
    $stmt = $conn->prepare("SELECT
                            m.movie_name,
                            m.poster_link,
                            m.trailer_link,
                            m.description,
                            m.runtime,
                            GROUP_CONCAT(DISTINCT d.director_id) AS director_ids,
                            GROUP_CONCAT(DISTINCT d.director_name SEPARATOR ', ') AS director,
                            GROUP_CONCAT(DISTINCT c.cast_id) AS cast_ids,
                            GROUP_CONCAT(DISTINCT c.cast_name SEPARATOR ', ') AS cast,
                            GROUP_CONCAT(DISTINCT g.genre_id) AS genre_ids,
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
                        GROUP BY
                            am.movie_id");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($movie_name, $poster_link, $trailer_link, $description, $runtime, $director_ids, $director, $cast_ids, $cast, $genre_ids, $genre);
    $stmt->fetch();
    $stmt->close();
    
    // Convert ids to arrays
    $director_ids = explode(',', $director_ids);
    $cast_ids = explode(',', $cast_ids);
    $genre_ids = explode(',', $genre_ids);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update movie data
        $movie_name = $_POST['movie_name'];
        $poster_link = $_POST['poster_link'];
        $trailer_link = $_POST['trailer_link'];
        $description = $_POST['description'];
        $runtime = $_POST['runtime'];
        
        $stmt = $conn->prepare("
            UPDATE
                movies
            SET
                movie_name = ?, poster_link = ?, trailer_link = ?, description = ?, runtime = ?
            WHERE
                movie_id = ?
        ");
        $stmt->bind_param("sssssi", $movie_name, $poster_link, $trailer_link, $description, $runtime, $id);
        
        if ($stmt->execute()) {
            // Update aboutmovie table
            $conn->query("DELETE FROM aboutmovie WHERE movie_id = $id");
            foreach ($_POST['director'] as $director_id) {
                foreach ($_POST['cast'] as $cast_id) {
                    foreach ($_POST['genre'] as $genre_id) {
                        $conn->query("INSERT INTO aboutmovie (movie_id, director_id, cast_id, genre_id) VALUES ($id, $director_id, $cast_id, $genre_id)");
                    }
                }
            }
            header('Location: DASHBOARD.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
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
    <link rel="stylesheet" href="../CSS/EDITMOVIEINFO.css">
    <link rel="icon" href="../IMAGES/logo.png">
    <title>GoBookIt | Edit Movie Info</title>
</head>
<body>
    <header>
        <a href="DASHBOARD.php" style="color: white; text-decoration: none; width: 200px;">
            <img src="../IMAGES/logo.png" alt="Logo" class="Logo">
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
    <form method="post" action="">
        <div class="form-container">
            <!-- First Column: Movie Details -->
            <div class="form-group">
                <label for="movie_name">Movie Name:</label>
                <input type="text" id="movie_name" name="movie_name" value="<?php echo htmlspecialchars($movie_name); ?>" required>
                <br>
                <label for="poster_link">Poster Link:</label>
                <input type="text" id="poster_link" name="poster_link" value="<?php echo htmlspecialchars($poster_link); ?>" required>
                <br>
                <label for="trailer_link">Trailer Link:</label>
                <input type="text" id="trailer_link" name="trailer_link" value="<?php echo htmlspecialchars($trailer_link); ?>" required>
                <br>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
                <br>
                <label for="runtime">Runtime:</label>
                <input type="text" id="runtime" name="runtime" value="<?php echo htmlspecialchars($runtime); ?>" required>
            </div>
            <!-- Second Column: Director -->
            <div class="form-group">
                <label for="director">Director (Hold ctrl to select more than one):</label>
                <select id="director" name="director[]" multiple required>
                    <?php
                    $result = $conn->query("SELECT director_id, director_name FROM directors");
                    while ($row = $result->fetch_assoc()) {
                        $selected = in_array($row['director_id'], $director_ids) ? 'selected' : '';
                        echo "<option value='{$row['director_id']}' $selected>{$row['director_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Third Column: Cast -->
            <div class="form-group">
                <label for="cast">Cast (Hold ctrl to select more than one):</label>
                <select id="cast" name="cast[]" multiple required>
                    <?php
                    $result = $conn->query("SELECT cast_id, cast_name FROM casts");
                    while ($row = $result->fetch_assoc()) {
                        $selected = in_array($row['cast_id'], $cast_ids) ? 'selected' : '';
                        echo "<option value='{$row['cast_id']}' $selected>{$row['cast_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Fourth Column: Genre -->
            <div class="form-group">
                <label for="genre">Genre (Hold ctrl to select more than one):</label>
                <select id="genre" name="genre[]" multiple required>
                    <?php
                    $result = $conn->query("SELECT genre_id, genre_name FROM genres");
                    while ($row = $result->fetch_assoc()) {
                        $selected = in_array($row['genre_id'], $genre_ids) ? 'selected' : '';
                        echo "<option value='{$row['genre_id']}' $selected>{$row['genre_name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" name="update_movie" class="update">Update Movie</button>
            <button type="button" class="cancel" onclick="window.location.href='DASHBOARD.php'">Cancel</button>
        </div>
    </form>

    <div class="ins">
        <h2>Instructions for new admins:</h2>
        <p>For the Trailer link:</p>
        <img src="../IMAGES/instructions.png" alt="instructions" class="instructions">
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
