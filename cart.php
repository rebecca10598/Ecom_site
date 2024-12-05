<?php include('layouts/header.php'); ?>

<!-- get data from single-product.php form session -->
<?php  

    if (!isset($_SESSION['cart']))  // ensure cart session is initialized correctly
    {
        $_SESSION['cart'] = array();
    }

    // check if the 'add_to_cart' button was clicked, meaning the user wants to add an item to the cart
    if(isset($_POST['add_to_cart']))
    {
        /* check if session already has a cart session active > 
            if user has already added a product to the cart, check whether the NEW product is already in the cart */
        if(isset($_SESSION['cart']))
        { 
            //array_column retrieves all product IDs currently in the cart into an array
            $product_array_ids = array_column($_SESSION['cart'],"product_id");
            
            // check if the selected product ID is not already in the cart
            if(!in_array($_POST['product_id'], $product_array_ids ))
            {
                $product_id = $_POST['product_id'];

                $product_array = array 
                ( // create an associative array for new product details to add to the cart
                    'product_id' => $_POST['product_id'], // product ID, name, price, image, quantity from form submission
                    'product_name' => $_POST['product_name'],
                    'product_price' => $_POST['product_price'],
                    'product_image' => $_POST['product_image'],
                    'product_quantity' => $_POST['product_quantity']
                );
                // add the new product to the session cart using the product ID as the key
                $_SESSION['cart'][$product_id] = $product_array;
            }
            else
            {   // if product is already in the cart, display alert message to user
                echo '<script> alert("Product is already in the Cart"); </script>';
            }
        }
        // if this is the 1st product in the cart (no existing products) initialize a new cart with the selected product
        else
        {   // took data from single_product.php > fetched it from the POST request & added them to separate parameters
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_quantity = $_POST['product_quantity'];

            // Create an associative array for the new product to add to cart
            $product_array = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_price' => $product_price,
                'product_image' => $product_image,
                'product_quantity' => $product_quantity
            );
            /* Initialize session cart with the new product.
                to recognize product array, we need its unique id (each array added to cart will have a unique id) */
            $_SESSION['cart'][$product_id] = $product_array;            
        }
        calculateTotalCart(); // calling function calculateTotalCart() from below
    } 
    else if(isset($_POST['remove_product'])) // remove product from cart session
    {
        $product_id = $_POST['product_id'];
        
        if (isset($_SESSION['cart'][$product_id])) // Check IF the product ID exists in the session cart
        {
            unset($_SESSION['cart'][$product_id]);
        } else 
        {
            echo '<script> alert("The Product you are trying to remove is not in the cart"); </script>';
        }
        calculateTotalCart(); // if we remove a product from the cart > calculate total
    }
    else if(isset($_POST['edit_quantity'])) // check if 'edit_quantity' form was submitted
    {   
        $product_id = $_POST['product_id']; // get product id from the submitted form data

        $product_quantity = $_POST['product_quantity']; // get new product quantity from submitted form data

        $product_array = $_SESSION['cart'][$product_id]; // retrieve current product details from session cart using product id

        $product_array['product_quantity'] = $product_quantity; // update product quantity in product details array

        $_SESSION['cart'][$product_id] = $product_array; // store updated product details back into the session cart
        
        calculateTotalCart(); // if we edit number of products in the cart > calculate total
    }
    else
    { 
        // header('location: index.php'); // redirect user to index.php if the form is not submitted properly
    }

    function calculateTotalCart() // calculates total cost of all products in the cart stored in the session
    {
        $total_price = 0; // initialize total variable to 0 as it will store sum of all products' prices in the cart
        $total_quantity = 0;

        foreach($_SESSION['cart'] as $key => $value) // loop through each item in the cart stored in the session
        {
            $product = $_SESSION['cart'][$key]; // get current product from the cart using the key

            $price = $product['product_price']; // get price of the current product
            $quantity = $product['product_quantity']; // get quantity of the current product

            $total_price = $total_price + ($price * $quantity); // add total cost of current product (price * quantity) to total cart cost
            $total_quantity = $total_quantity + $quantity;
        }
        $_SESSION['total'] = $total_price; // store total cost in the session so it can be accessed & displayed later
        $_SESSION['quantity'] = $total_quantity; // calculate total quantity if user adds/removes to/from cart
    }

?>

    <!-- Cart -->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
            <hr>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php if(isset($_SESSION['cart'])) { ?>

                <!-- Session loop to display all the products in the cart -->
                <?php foreach($_SESSION['cart'] as $key => $value){ ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $value['product_image']; ?>"/>
                            <div>
                                <p> <?php echo $value['product_name']; ?> </p>
                                <small><span>$</span> <?php echo $value['product_price']; ?> </small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                                    <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <!-- Start form with POST method that submits to cart.php -->
                        <form method="POST" action="cart.php" >
                            <!-- hidden input field that stores product ID of current products in the form which is 
                                used to identify which product's quantity is being edited -->
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                            <!-- value attribute is pre-filled with current quantity of products from the session data  -->
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>"/>
                            <!-- Submit button for form. When clicked, 
                                it will send form data (product_id & new quantity) to server via a POST request to cart.php.
                                name attribute is set to "edit_quantity" so that the server-side script 
                                can check if this form has been submitted  -->
                            <input type="submit" class="edit-btn" name="edit_quantity" value="edit"/>
                        </form>
                    </td>
                    <td>
                        <span>$</span>
                        <span class="product-price"> <?php echo $value['product_quantity'] * $value['product_price']; ?> </span> 
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <div class="cart-total">
            <table>
                <tr>
                    <td>Total</td>
                    <?php if(isset($_SESSION['total'])) { ?>
                        <td><span>$</span> <?php echo $_SESSION['total']; ?> </td>
                    <?php } ?>
                </tr>
            </table>            
        </div>

        <div class="checkout-cart-container">
            <form method="POST" action="checkout.php">
                <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout" />
            </form>
        </div>
    </section>

<?php include('layouts/footer.php'); ?>