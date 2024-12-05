<?php 
    session_start();
    include('connection.php');

    if(isset($_GET['details_id']) && isset($_GET['order_id'])) 
    {
        $order_id = $_GET['order_id'];
        $order_status = "paid";
        $details_id = $_GET['details_id'];
        $user_id = $_SESSION['user_id'];
        $payment_date = date('Y-m-d H:i:s');

        // update order status to "paid"
        $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=?"); 
        $stmt->bind_param('si', $order_status, $order_id);
        $stmt->execute();

        // insert payment details
        $stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, details_id, payment_date) 
                                        VALUES (?, ?, ?, ?);");
        $stmt1->bind_param('iiss', $order_id, $user_id, $details_id, $payment_date);
        $stmt1->execute();

        // redirect to user account page
        header("location: ../account.php?payment_message=Payment successfully completed, thank you for shopping with us!");
    } 
    else 
    {
        header("location: index.php");
        exit;    
    }
?>
