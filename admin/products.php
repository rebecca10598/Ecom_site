<?php
    include('header.php');
    include('../server/connection.php');

    // 1. Determine current page number for pagination (default to 1 if not set)
    $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

    // 2. Get total number of products in the database
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    // 3. Define how many products will be displayed per page
    $total_records_per_page = 5;

    // Calculate offset where products for the current page should start
    $offset = ($page_no-1) * $total_records_per_page;

    // Calculate previous & next page numbers for pagination links
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    // Calculate total number of pages needed
    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    // 4. Get all products for the current page (limit results to products per page)
    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT ?, ?");
    $stmt2->bind_param('ii', $offset, $total_records_per_page); // Prevent SQL injection
    $stmt2->execute();
    $result = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        /* Layout for sidebar and content */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden; /* Prevent horizontal scrolling */
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .container {
            display: flex;
            min-height: 100vh; /* Ensure the sidebar spans the full height of the page */
            flex-grow: 1;
        }

        .content {
            flex-grow: 1; /* Allow content to take up remaining space */
            padding: 30px;
            display: flex;
            flex-direction: column;
            margin-bottom: 10px; 
            margin-top: -15px;
            width: 80%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: -30px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: lightgray;
        }

        /* Button styles */
        .edit-images-button {
            background-color: orange;
            color: black;
            border: none;
            border-radius: 4px;
            padding: 2px 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .edit-button {
            background-color: green;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .delete-button {
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 10px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Pagination */
        .pagination {
            margin-top: -50px;
            margin-bottom: 0; /* Remove extra space */
        }

        .pagination .page-item .page-link {
            color: darkblue;
            font-weight: bold;
        }

        .pagination .page-item .page-link:hover {
            background-color: lightblue; /* Hover effect for pagination */
        }

        footer {
            margin-top: auto; /* Push footer to the bottom */
        }
        .content h3 {
            margin-bottom: 10px;
        }

        #deleteDialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid black;
            padding: 20px;
            z-index: 1000;
            display: none;
            box-shadow:  0 5px 10px rgba(0,0,0,1); /* nav shadow */
            font-weight: bold;
            justify-content: center; /* Centers the content vertically */
            border-radius: 8px;
            text-align: center;
        }

        #deleteDialog #confirmYes,
        #deleteDialog #confirmNo {
            margin: 5px;
            background-color: lightgreen;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100px;
            font-weight: bold;
        }

        #deleteDialog #confirmNo {
            background-color: lightcoral;
        }

        #deleteDialog p {
            margin-bottom: 20px;
        }

        #deleteDialog button {
            display: inline-block;
        }

        #deleteDialog .button-group {
            display: flex;
            justify-content: center;
        }

        #successDialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid black;
            padding: 20px;
            z-index: 1000;
            display: none;
            box-shadow:  0 5px 10px rgba(0,0,0,1); /* nav shadow */
            font-weight: bold;
            justify-content: center; /* Centers the content vertically */
            border-radius: 8px;
            text-align: center;
        }

        #successDialog button {
            margin-top: 10px;
            background-color: lightblue;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Include the sidebar -->
        <?php include('sidebar.php'); ?>

        <div class="content">
            <h3>Products</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Product Area</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Special Offer</th>
                        <th>Color</th>
                        <th>Edit Images</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr id="product-<?php echo $row['product_id']; ?>">
                        <td><?php echo $row['product_id']; ?></td>
                        <td><img src="../assets/imgs/<?php echo $row['product_image']; ?>" width="50"></td>
                        <td><?php echo $row['product_area']; ?></td>
                        <td><?php echo $row['product_category']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_price']; ?></td>
                        <td><?php echo $row['product_special_offer']; ?></td>
                        <td><?php echo $row['product_color']; ?></td>
                        <td><button class="edit-images-button" onclick="window.location.href='edit_images.php?id=<?php echo $row['product_id']; ?>'">Edit Images</button></td>
                        <td><button class="edit-button" onclick="window.location.href='edit_product.php?id=<?php echo $row['product_id']; ?>'">Edit</button></td>
                        <td><button class="delete-button" onclick="showDeleteDialog(<?php echo $row['product_id']; ?>)">Delete</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example"> 
                <ul class="pagination mt-5">
                    <li class="page-item <?php if($page_no <= 1) {echo 'disabled';} ?> ">
                        <a class="page-link" href="<?php if($page_no<=1) {echo '#';} else {echo "?page_no=".($previous_page);} ?>">Previous</a>
                    </li>

                    <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

                    <?php if($page_no >= 3) { ?>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo "?page_no=".$total_no_of_pages; ?>">
                                <?php echo $total_no_of_pages; ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="page-item <?php if($page_no >= $total_no_of_pages) {echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) {echo '#';} else {echo "?page_no=".($next_page);} ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <?php include('footer.php'); ?> 

    <!-- Delete confirmation dialog -->
    <div id="deleteDialog">
        <p>Are you sure you want to delete this product?</p>
        <div class="button-group">
            <button id="confirmYes">Yes</button>
            <button id="confirmNo" onclick="closeDialog()">No</button>
        </div>
    </div>

    <!-- Success message dialog -->
    <div id="successDialog">
        <p>Product deleted successfully!</p>
        <button onclick="window.location.reload()">Close</button>
    </div>

    <script>
        var productToDelete;

        function showDeleteDialog(productId) {
            productToDelete = productId;
            document.getElementById('deleteDialog').style.display = 'block'; // Show the delete dialog
        }

        function closeDialog() {
            document.getElementById('deleteDialog').style.display = 'none'; // Close the delete dialog
        }

        document.getElementById('confirmYes').onclick = function() {
            if (productToDelete) {
                fetch('delete_product.php?id=' + productToDelete)
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            closeDialog(); // Close delete dialog
                            document.getElementById('successDialog').style.display = 'block'; // Show success dialog
                            document.getElementById('product-' + productToDelete).remove(); // Remove product row
                        } else {
                            alert('Failed to delete product');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        };
    </script>
</body>
</html>
