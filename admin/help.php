<?php
    include('header.php'); // Include the header file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
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
        .content h3{
            border-bottom: 2px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Include the sidebar -->
        <?php include('sidebar.php'); ?>
        
        <div class="content">
            <h3>Help</h3>
            <p>Admins can contact each other if any doubts arise</p>
            <p>Admin 1 details:</p>
            <ul>
                <li>email – <a href="mailto:admin1@gmail.com">admin1@gmail.com</a></li>
                <li>Number – 0774789021</li>
            </ul>
            <p>Admin 2 details:</p>
            <ul>
                <li>email – <a href="mailto:admin2@gmail.com">admin2@gmail.com</a></li>
                <li>Number – 0778732521</li>
            </ul>
        </div>
    </div>
    <?php include('footer.php'); ?> 
</body>
</html>
