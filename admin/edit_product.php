<?php
    include('header.php');
    include('../server/connection.php');

    // Retrieve the product details
    if (isset($_GET['id'])) 
    {
        $product_id = $_GET['id'];
        $query = "SELECT * FROM products WHERE product_id='$product_id'";
        $result = mysqli_query($conn, $query);
        $product = mysqli_fetch_assoc($result);
    }

    // Update the product details
    if (isset($_POST['update_product'])) 
    {
        $name = $_POST['product_name'];
        $category = $_POST['product_category'];
        $price = $_POST['product_price'];
        $offer = $_POST['product_special_offer'];
        $color = $_POST['product_color'];

        $query = "UPDATE products SET 
                    product_name='$name', 
                    product_category='$category', 
                    product_price='$price', 
                    product_special_offer='$offer', 
                    product_color='$color' 
                    WHERE product_id='$product_id'";

        if (mysqli_query($conn, $query)) 
        {
            header('location: products.php');
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
    <title>Edit Product</title>
    <style>
        html, body {
            overflow: hidden;
        }
        /* Layout for sidebar and content */
        .container {
            display: flex;
            min-height: 100vh; /* Ensure the sidebar spans the full height of the page */
        }
        .sidebar {
            width: 200px; /* Fixed width for the sidebar */
            background-color: lightgray;
            padding: 20px;
            height: 100vh; /* Full height */
        }
        .content {
            flex-grow: 1; /* Allow content to take up remaining space */
            padding: 20px;
        }
        .content h3{
            border-bottom: 2px solid #ddd;
        }
        .btn-edit_product{
            background-color: green;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
        }
        .edit-product label{
            margin-bottom: 4px;
            margin-top: 7px;
            font-weight: bold;
        }
        .edit-product input,
        .edit-product select {
            margin-bottom: 2px;
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Include the sidebar within the container -->
        <?php include('sidebar.php'); ?> 

        <div class="content">
            <h3>Edit Product</h3>
            <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post" class="edit-product">
                <label for="name">Product Name:</label><br>
                <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>

                <!-- New Category dropdown -->
                <label for="category">Category:</label><br>
                <select name="product_category" required>
                    <option value="dresses_coats" <?php if($product['product_category'] == 'dresses_coats') echo 'selected'; ?>>Dresses or Coats</option>
                    <option value="watches" <?php if($product['product_category'] == 'watches') echo 'selected'; ?>>Watches</option>
                    <option value="shoes" <?php if($product['product_category'] == 'shoes') echo 'selected'; ?>>Shoes</option>
                    <option value="tops" <?php if($product['product_category'] == 'tops') echo 'selected'; ?>>Tops</option>
                    <option value="bags" <?php if($product['product_category'] == 'bags') echo 'selected'; ?>>Bags</option>
                </select><br>

                <label for="price">Price:</label><br>
                <input type="number" name="product_price" value="<?php echo $product['product_price']; ?>" required><br>
                
                <label for="offer">Special Offer:</label><br>
                <input type="text" name="product_special_offer" value="<?php echo $product['product_special_offer']; ?>"><br>
                
                <label for="color">Color:</label><br>
                <input type="text" name="product_color" value="<?php echo $product['product_color']; ?>"><br><br>
                
                <button class="btn-edit_product" type="submit" name="update_product">Update Product</button>
            </form>
        </div>
        
    </div>
    <?php include('footer.php'); ?> 
    </body>
</html>
