<?php
    include('header.php');
    include('../server/connection.php');

    if (isset($_POST['add_product'])) 
    {
        $name = $_POST['product_name'];
        $description = $_POST['product_description'];
        $price = $_POST['product_price'];
        $special_offer = $_POST['product_special_offer'];
        $area = $_POST['product_area'];
        $category = $_POST['product_category'];
        $color = $_POST['product_color'];

        // Handle Image Uploads
        $image1 = $_FILES['product_image1']['name'];
        $image2 = $_FILES['product_image2']['name'];
        $image3 = $_FILES['product_image3']['name'];
        $image4 = $_FILES['product_image4']['name'];

        // Temp file names
        $image1_temp = $_FILES['product_image1']['tmp_name'];
        $image2_temp = $_FILES['product_image2']['tmp_name'];
        $image3_temp = $_FILES['product_image3']['tmp_name'];
        $image4_temp = $_FILES['product_image4']['tmp_name'];

        // Move files to the images folder
        move_uploaded_file($image1_temp, "../images/$image1");
        move_uploaded_file($image2_temp, "../images/$image2");
        move_uploaded_file($image3_temp, "../images/$image3");
        move_uploaded_file($image4_temp, "../images/$image4");

        // Insert query to add product details into the database
        $query = "INSERT INTO products (product_name, product_description, product_price, product_special_offer, product_area, product_category, product_color, product_image, product_image2, product_image3, product_image4) 
                    VALUES ('$name', '$description', '$price', '$special_offer', '$area', '$category', '$color', '$image1', '$image2', '$image3', '$image4')";

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
    <title>Add New Product</title>
    <style>
        body {
            overflow: hidden; /* Prevent scrolling */
        }
        .container {
            display: flex;
            min-height: 100vh;
            flex-grow: 1;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            padding-left: 50px;
            font-size: 0.7rem; /* Shrinks the overall text size */
        }

        .content h3 {
            border-bottom: 2px solid #ddd;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 0.95rem; /* Shrinks label text */
            display: block;
            font-weight: bold;
            margin-bottom: 4px;
            margin-top: 3px;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="number"],
        .form-group select {
            font-size: 0.95rem; /* Shrinks input text */
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            margin-top: 5px;
            font-size: 0.95rem; /* Shrinks file input text */
        }

        .btn-add-product {
            background-color: green;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1rem; /* Slightly smaller button text */
            margin-top: 34px; /* Adjust margin for spacing */
            display: block;
            font-weight: bold;
        }

        /* Layout for the two columns */
        .form-layout {
            display: flex;
            gap: 20px; /* Space between the two columns */
        }

        .left-column,
        .right-column {
            flex: 1; /* Equal width for both columns */
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include('sidebar.php'); ?>

        <div class="content">
            <h3>Add New Product</h3>
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="form-layout">
                    <div class="left-column">
                        <div class="form-group">
                            <label for="product_name">Name:</label>
                            <input type="text" name="product_name" required>
                        </div>

                        <div class="form-group">
                            <label for="product_description">Description:</label>
                            <textarea name="product_description" rows="1" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_price">Price:</label>
                            <input type="number" name="product_price" required>
                        </div>

                        <div class="form-group">
                            <label for="product_special_offer">Special Offer:</label>
                            <input type="text" name="product_special_offer">
                        </div>

                        <div class="form-group">
                            <label for="product_area">Product Area:</label>
                            <select name="product_area" required>
                                <option value="Bags (Men & Women)">Bags (Men & Women)</option>
                                <option value="Bags (Men)">Bags (Men)</option>
                                <option value="Bags (Women)">Bags (Women)</option>
                                <option value="Coats (Men)">Coats (Men)</option>
                                <option value="Coats (Women)">Coats (Women)</option>
                                <option value="Dresses (Women)">Dresses (Women)</option>
                                <option value="Shoes (Men & Women)">Shoes (Men & Women)</option>
                                <option value="Shoes (Men)">Shoes (Men)</option>
                                <option value="Shoes (Women)">Shoes (Women)</option>
                                <option value="Tops (Men)">Tops (Men)</option>
                                <option value="Tops (Women)">Tops (Women)</option>
                                <option value="Watches (Men)">Watches (Men)</option>
                                <option value="Watches (Women)">Watches (Women)</option>
                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn-add-product">Add Product</button>
                    </div>

                    <div class="right-column">
                    <div class="form-group">
                            <label for="product_category">Category:</label>
                            <select name="product_category" required>
                                <option value="dresses_coats">Dresses or Coats</option>
                                <option value="watches">Watches</option>
                                <option value="shoes">Shoes</option>
                                <option value="tops">Tops</option>
                                <option value="bags">Bags</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_color">Color:</label>
                            <input type="text" name="product_color" required>
                        </div>

                        <div class="form-group">
                            <label for="product_image1">Image 1:</label>
                            <input type="file" name="product_image1" required>
                        </div>

                        <div class="form-group">
                            <label for="product_image2">Image 2:</label>
                            <input type="file" name="product_image2">
                        </div>

                        <div class="form-group">
                            <label for="product_image3">Image 3:</label>
                            <input type="file" name="product_image3">
                        </div>

                        <div class="form-group">
                            <label for="product_image4">Image 4:</label>
                            <input type="file" name="product_image4">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>
    </body>
</html>
