<?php
session_start();

include 'DBCONNECT.php';

// Execute the SQL query with ORDER BY clause
$result = $conn->query("
    SELECT 
        b.booking_id,
        m.movie_name,
        u.user_firstname,
        u.user_lastname,
        u.user_email,
        b.phone_number,
        b.booking_date,
        b.no_of_tickets,
        b.payment_method
    FROM bookings b
    JOIN moviebookings mb ON b.booking_id = mb.booking_id
    JOIN movies m ON mb.movie_id = m.movie_id
    JOIN users u ON mb.user_id = u.user_id
    ORDER BY b.booking_date ASC
");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Archivo' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/BOOKINGS.css">
    <link rel="icon" href="../IMAGES/logo.png">
    <title>GoBookIt | Bookings</title>
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
        <a href="DASHBOARD.php"><b>MOVIES</b></a>
        <a href="BOOKINGS.php" class="active"><b>BOOKINGS</b></a>
    </div>

    <div class="bgimage">
        <h1 style="padding-bottom: 30px;">BOOKINGS</h1>
    </div>

    <br><br>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>Movie Name</th>
            <th>User Firstname</th>
            <th>User Lastname</th>
            <th>User Email</th>
            <th>Phone Number</th>
            <th>Booking Date</th>
            <th>Number of Tickets</th>
            <th>Payment Method</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): 
            $booking_date = new DateTime($row['booking_date']);
            $current_date = new DateTime();
            $date_class = $booking_date < $current_date ? 'past-date' : 'future-date';
        ?>
        <tr class="<?php echo $date_class; ?>">
            <td><?php echo $row['booking_id']; ?></td>
            <td><?php echo $row['movie_name']; ?></td>
            <td><?php echo $row['user_firstname']; ?></td>
            <td><?php echo $row['user_lastname']; ?></td>
            <td><?php echo $row['user_email']; ?></td>
            <td><?php echo $row['phone_number']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td><?php echo $row['no_of_tickets']; ?></td>
            <td><?php echo $row['payment_method']; ?></td>
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
