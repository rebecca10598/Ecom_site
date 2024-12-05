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

    // Update the product images
    if (isset($_POST['update_images'])) 
    {
        $image1 = $_FILES['product_image1']['name'];
        $image1_temp = $_FILES['product_image1']['tmp_name'];
        
        $image2 = $_FILES['product_image2']['name'];
        $image2_temp = $_FILES['product_image2']['tmp_name'];
        
        $image3 = $_FILES['product_image3']['name'];
        $image3_temp = $_FILES['product_image3']['tmp_name'];
        
        $image4 = $_FILES['product_image4']['name'];
        $image4_temp = $_FILES['product_image4']['tmp_name'];

        if ($image1) move_uploaded_file($image1_temp, "../images/$image1");
        if ($image2) move_uploaded_file($image2_temp, "../images/$image2");
        if ($image3) move_uploaded_file($image3_temp, "../images/$image3");
        if ($image4) move_uploaded_file($image4_temp, "../images/$image4");

        // Update the images in the database
        $query = "UPDATE products SET 
            product_image = IF('$image1' != '', '$image1', product_image), 
            product_image2 = IF('$image2' != '', '$image2', product_image2), 
            product_image3 = IF('$image3' != '', '$image3', product_image3), 
            product_image4 = IF('$image4' != '', '$image4', product_image4) 
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
    <title>Update Product Images</title>
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
        .form-group {
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd; /* Adding the bottom border */
            padding-bottom: 15px; /* Adding some space between content and border */
        }
        .form-group:last-of-type {
            border-bottom: none; /* Remove bottom border for the last section */
        }
        .content h3{
            border-bottom: 2px solid #ddd;
            margin-bottom: 10px;
        }
        .btn-edit_images{
            background-color: orange;
            color: black;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }
        .edit-image-label{
            font-weight: bold;
        }
        .edit-image-label input {
            margin-bottom: 3px;
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include('sidebar.php'); ?> 

        <div class="content">
            <h3>Update Product Images</h3>
            <form action="edit_images.php?id=<?php echo $product_id; ?>" class="edit-image-label" method="post" enctype="multipart/form-data">

                <!-- Image 1 -->
                <div class="form-group">
                    <label for="product_image1">Image 1:</label><br>
                    <input type="file" name="product_image1" id="product_image1">
                </div>

                <!-- Image 2 -->
                <div class="form-group">
                    <label for="product_image2">Image 2:</label><br>
                    <input type="file" name="product_image2" id="product_image2">
                </div>

                <!-- Image 3 -->
                <div class="form-group">
                    <label for="product_image3">Image 3:</label><br>
                    <input type="file" name="product_image3" id="product_image3">
                </div>

                <!-- Image 4 -->
                <div class="form-group">
                    <label for="product_image4">Image 4:</label><br>
                    <input type="file" name="product_image4" id="product_image4">
                </div>

                <!-- Update Button -->
                <button class="btn-edit_images" type="submit" name="update_images">Update Product Images</button>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?> 
    </body>
</html>
