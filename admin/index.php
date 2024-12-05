<?php
    include('header.php'); // Include the header file
    include('../server/connection.php'); // Database connection

    // Pagination setup
    $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

    // Get total number of orders
    $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM orders");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    // Number of records per page
    $total_records_per_page = 6;
    $offset = ($page_no - 1) * $total_records_per_page;
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    // Fetch orders for the current page
    $query = "SELECT * FROM orders LIMIT $offset, $total_records_per_page";
    $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <style>
        /* Ensure body and html only occupy the content height */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column; /* Allow flex layout */
            overflow: hidden;
        }

        /* Layout for sidebar and content */
        .container {
            display: flex;
            flex-grow: 1; /* Allow container to take remaining space */
            min-height: calc(100vh - 50px); /* Adjust height considering header/footer */
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            display: flex;
            flex-direction: column; /* Allow content to stack vertically */
            justify-content: space-between; /* Space between content and pagination */
            margin-top: -15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -17px;
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
            margin-bottom: 60px; /* Remove extra space */
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
            margin-bottom: -10px;
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
        <?php include('sidebar.php'); ?>

        <div class="content">
            <h3>User Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>User ID</th>
                        <th>Date & Time</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr id="order-<?php echo $row['order_id']; ?>">
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['order_status']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td><?php echo $row['user_phone']; ?></td>
                        <td><?php echo $row['user_address']; ?></td>
                        <td><button class="edit-button" onclick="window.location.href='edit_order.php?id=<?php echo $row['order_id']; ?>'">Edit</button></td>
                        <td><button class="delete-button" onclick="showDeleteDialog(<?php echo $row['order_id']; ?>)">Delete</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example"> 
                <ul class="pagination">
                    <li class="page-item <?php if($page_no <= 1) {echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($page_no <= 1) {echo '#';} else {echo "?page_no=".($page_no-1);} ?>">Previous</a>
                    </li>

                    <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

                    <?php if($page_no >= 3) { ?>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo "?page_no=".$page_no;?>">
                                <?php echo $page_no; ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="page-item <?php if($page_no >= $total_no_of_pages) {echo 'disabled';} ?>">
                        <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) {echo '#';} else {echo "?page_no=".($page_no+1);} ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <?php include('footer.php'); ?> 

    <!-- Delete confirmation dialog -->
    <div id="deleteDialog">
        <p>Are you sure you want to delete this order?</p>
        <div class="button-group">
            <button id="confirmYes">Yes</button>
            <button id="confirmNo" onclick="closeDialog()">No</button>
        </div>
    </div>

    <!-- Success message dialog -->
    <div id="successDialog">
        <p>Order deleted successfully!</p>
        <button onclick="window.location.reload()">Close</button>
    </div>

    <script>
        var orderToDelete;

        function showDeleteDialog(orderId) {
            orderToDelete = orderId;
            document.getElementById('deleteDialog').style.display = 'block'; // Show the delete dialog
        }

        function closeDialog() {
            document.getElementById('deleteDialog').style.display = 'none'; // Close the delete dialog
        }

        document.getElementById('confirmYes').onclick = function() {
            if (orderToDelete) {
                fetch('delete_order.php?id=' + orderToDelete)
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            closeDialog(); // Close delete dialog
                            document.getElementById('successDialog').style.display = 'block'; // Show success dialog
                            document.getElementById('order-' + orderToDelete).remove(); // Remove product row
                        } else {
                            alert('Failed to delete order');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        };
    </script>

    </body>
</html>
