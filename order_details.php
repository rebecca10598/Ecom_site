<?php include('layouts/header.php'); ?>

<?php  

    /* Order Process:
        1. Not paid
        2. Shipped
        3. Delivered   */

    include('server/connection.php');

    // ensuring the user is logged in & an order ID is sent via POST request
    if(isset($_POST['order_id']) && isset($_SESSION['logged_in'])) 
    {
        $order_id = $_POST['order_id']; 
        $order_status = $_POST['order_status'];

        // query to fetch order details based on order_id
        $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $order_details = $stmt->get_result();

        $order_total_price = calculateTotalOrderPrice($order_details);
    } 
    else 
    {
        header('location: account.php'); // if no order_id is sent, redirect to account page
        exit;
    }

    // calculates & returns total price products in an order based on price & quantity of each item
    function calculateTotalOrderPrice($order_details) 
    {
        // initialize variable to store total order price, starting at 0 (used to get total price of products in the order)
        $total = 0;

        // loop through each row in $order_details array (each row represents a product in the order)
        foreach($order_details as $row) 
        {
            $product_price = $row['product_price']; // extract price of product from current row
            $product_quantity = $row['product_quantity']; // extract quantity of product ordered from current row
            // calculate total product price (price * quantity) & add it to total
            $total = $total + ($product_price * $product_quantity); 
        }
        return $total; // return accumulated total price for entire order
    }

?>

    <!-- Order Details -->
    <section id="orders" class="cart container my-5 py-3">
        <div class="container mt-5">
            <h2 class="font-weight-bold text-center">Order Details</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>

            <?php foreach($order_details as $row) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $row['product_image'];?>"/>
                            <div>
                                <p class="mt-3"><?php echo $row['product_name'];?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span>$ <?php echo $row['product_price'];?></span>
                    </td>
                    <td>
                        <span><?php echo $row['product_quantity'];?></span>
                    </td>
                </tr> 
            <?php } ?>
        </table>

        <!-- Pay Now Button -->
        <?php if (isset($order_status) && trim($order_status) === "not paid") { ?>
            <div style="text-align: right; margin-top: 15px;">
                <!-- form that submits a POST req to 'payment.php' -->
                <form method="POST" action="payment.php">
                    <!-- hidden input fields passing order_id in POST req -->
                    <input type="hidden" name="order_id" value="<?php echo $order_id;?>" />

                    <!-- hidden input fields passing order_total_price & order_status in POST req -->
                    <input type="hidden" name="order_total_price" value="<?php echo $order_total_price;?>" />
                    <input type="hidden" name="order_status" value="<?php echo $order_status;?>" />
                    
                    <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Pay Now" style="padding: 7px 12px; font-size: 16px;" />
                </form>
            </div>
        <?php } ?>
    </section>

<?php include('layouts/footer.php'); ?>