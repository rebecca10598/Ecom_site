<?php
    include('header.php');
    include('../server/connection.php');

    // Retrieve the order details
    if (isset($_GET['id'])) 
    {
        $order_id = $_GET['id'];
        $query = "SELECT * FROM orders WHERE order_id='$order_id'";
        $result = mysqli_query($conn, $query);
        $order = mysqli_fetch_assoc($result);
    }

    // Update the order status
    if (isset($_POST['update_order'])) 
    {
        $status = $_POST['order_status'];
        
        // Update the orders table
        $update_query = "UPDATE orders SET order_status='$status' WHERE order_id='$order_id'";
        if (mysqli_query($conn, $update_query)) 
        {
            // Redirect to index.php after successful update
            header('location: index.php');
        } 
        else 
        {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        html, body {
            overflow: hidden;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 200px;
            background-color: lightgray;
            padding: 20px;
            height: 100vh;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .content h3{
            border-bottom: 2px solid #ddd;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, select {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        .btn-edit_order {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include('sidebar.php'); ?> 

        <div class="content">
            <h3>Edit Order</h3>

            <!-- Display order details -->
            <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Order Price:</strong> $<?php echo $order['order_cost']; ?></p>

            <!-- Form to edit order status -->
            <form action="edit_order.php?id=<?php echo $order_id; ?>" method="post">
                <label for="order_status">Order Status:</label>
                <select name="order_status" id="order_status">
                    <option value="Not Paid" <?php if($order['order_status'] == 'Not Paid') echo 'selected'; ?>>Not Paid</option>
                    <option value="Paid" <?php if($order['order_status'] == 'Paid') echo 'selected'; ?>>Paid</option>
                    <option value="Shipped" <?php if($order['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                    <option value="Delivered" <?php if($order['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                </select>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                <button class="btn-edit_order" type="submit" name="update_order">Edit Order</button>
            </form>
            
        </div>
    </div>

    <?php include('footer.php'); ?>
    </body>
</html>
