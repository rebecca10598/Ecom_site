<?php
    include('../server/connection.php');

    if (isset($_GET['id'])) 
    {
        $product_id = $_GET['id'];
        // Prepare a DELETE SQL statement
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param('i', $product_id);

        // Execute and return a response
        if ($stmt->execute()) 
        {
            echo 'success';
        } 
        else 
        {
            echo 'error';
        }
        $stmt->close();
    } 
    else 
    {
        echo 'error';
    }
    $conn->close();
?>
