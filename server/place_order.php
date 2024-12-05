<?php 

    session_start();
    include('connection.php');

    if(!isset($_SESSION['logged_in'])) // if user is NOT logged in
    {
        header('location: ../checkout.php?message=Please Login/Register to place an order!');
        exit;
    }
    else // if user IS logged in
    {
        if(isset($_POST['place_order'])) // check whether user clicked on checkout button or not
        {   
            // 1 - get user info & store it in the db
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $order_cost = $_SESSION['total'];
            $order_status = "not paid";
            
            if (isset($_SESSION['user_id'])) // fetch correct user id from the session
            {
                $user_id = $_SESSION['user_id'];
            } 
            else 
            {
                die("User is not logged in!"); // handle the case where the user is not logged in
            }
            
            $order_date = date('Y-m-d H:i:s');

            // prepare the SQL statement to insert the order
            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                                            VALUES (?, ?, ?, ?, ?, ?, ?);");

            // bind parameters: int, string, int, string, string, string, string
            $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);
            
            if ($stmt->execute()) // execute statement
            {
                // 2 - get the newly inserted order ID
                $order_id = $stmt->insert_id;

                // 3 - get products from the cart (from session)
                foreach ($_SESSION['cart'] as $key => $value) 
                {
                    // extract product details
                    $product = $_SESSION['cart'][$key];
                    $product_id = $product['product_id'];
                    $product_name = $product['product_name'];
                    $product_price = $product['product_price'];
                    $product_image = $product['product_image'];
                    $product_quantity = $product['product_quantity'];

                    // 4 - insert each item into order_items table
                    $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

                    // bind parameters: int, int, string, string, int, int, int, string
                    $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
                    
                    $stmt1->execute(); // execute the statement for each item
                }

                // 5 - optionally clear everything from the cart (delay until payment is completed)
                unset($_SESSION['cart']);

                $_SESSION['order_id'] = $order_id;

                // 6 - inform the user that the order has been placed successfully
                header('Location: ../payment.php?order_status=Your order has been placed successfully!');
            } 
            else 
            {
                echo "Error placing order: " . $stmt->error; // error handling
            }

            $stmt->close(); // close statements
            $stmt1->close();
        }
    }

    $conn->close(); // close database connection
?>
