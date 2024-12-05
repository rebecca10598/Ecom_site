<?php include('layouts/header.php'); ?>

<?php 

    // checking whether the cart is empty or not

    if(!empty($_SESSION['cart']) ) // check if cart session variable is not empty
    { 
        // if cart is not empty, user can proceed
    }
    else // if cart is empty, redirect user to index.php
    {
        header('Location: index.php');
    }

?>

    <!-- Checkout -->
    <section  class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto">
        </div>
        <div class="checkout-container mx-auto">
            <form id="checkout-form" method="POST" action="server/place_order.php">

                <p class="text-center" style="color: red;">
                    <?php if(isset($_GET['message'])) { echo $_GET['message'];} ?>
                    <?php if(isset($_GET['message'])) { ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php } ?>
                </p>

                <div class="form-group checkout-small-element">
                    <label>Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Enter your Name" required/>
                </div>
                <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Enter your Email" required/>
                </div>
                <div class="form-group checkout-small-element">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Enter your Phone Number" required/>
                </div>
                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="Enter your City" required/>
                </div>
                <div class="form-group checkout-large-element">
                    <label>Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Enter your Address" required/>
                </div>

                <!-- Checkout button -->
                <div class="form-group checkout-btn-container">
                    <p>Total Amount: $ <?php echo $_SESSION['total']; ?></p>
                    <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order"/>
                </div>
            </form>
        </div>
    </section>

<?php include('layouts/footer.php'); ?>
    