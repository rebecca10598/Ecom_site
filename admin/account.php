<?php
    include('header.php');
    include('../server/connection.php');

    // Start the session and retrieve admin details
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Start the session only if it's not already started
    }

    $admin_email = $_SESSION['admin_email'];

    // Query to retrieve admin details
    $query = "SELECT * FROM admins WHERE admin_email='$admin_email'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account</title>
    <style>
        body {
            overflow: hidden; /* Prevent scrolling */
        }
        .container {
            display: flex;
            min-height: 100vh; /* Ensure the sidebar spans the full height of the page */
        }
        .sidebar {
            width: 250px; /* Fixed width for the sidebar */
            background-color: lightgray;
            padding: 10px;
        }
        .content {
            flex-grow: 1; /* Allow content to take up remaining space */
            padding: 20px;
        }
        .content p {
            padding-top: 10px;
        }
        .content h3{
            border-bottom: 2px solid #ddd;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Include the sidebar within the container -->
    <?php include('sidebar.php'); ?> 

    <div class="content">
        <h3>Admin Account</h3>
        <p>Logged in now:</p>
        <p><strong>Admin ID:</strong> <?php echo $admin['admin_id']; ?></p>
        <p><strong>Name:</strong> <?php echo $admin['admin_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $admin['admin_email']; ?></p>
    </div>
</div>
<?php include('footer.php'); ?> 
</body>
</html>
