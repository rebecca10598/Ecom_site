<?php
    session_start();
    include('../server/connection.php'); // Include your database connection

    if (isset($_GET['id'])) 
    {
        $order_id = $_GET['id'];
        // Prepare and execute delete statement
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) 
        {
            echo 'success'; // Respond with success message
        } 
        else 
        {
            echo 'error'; // Respond with error message
        }
        $stmt->close();
    }
    $conn->close();
?>
