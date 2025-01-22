<?php
include 'DBCONNECT.php'; // Your database connection file

if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];

    // Delete movie from the aboutmovie table
    $stmt = $conn->prepare("DELETE FROM aboutmovie WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->close();

    // Delete movie from the movies table
    $stmt = $conn->prepare("DELETE FROM movies WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $stmt->close();

    header('Location: DASHBOARD.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/DASHBOARD.css">
    <title>Deleting Movie...</title>
</head>
<body>
    <p>Deleting movie...</p>
</body>
</html>
