<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <style>
        .sidebar-nav {
            width: 200px;
            height: 100vh; /* Full height of the viewport */
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            display: flex;
            flex-direction: column; /* Vertical layout */
            margin-left: -60px;
            background-color: lightgray;
        }

        .sidebar-nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav ul li {
            margin: 8px 0;
            background-color: white; /* Box background */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
        }

        .sidebar-nav ul li a {
            text-decoration: none;
            color: darkblue; /* Text color */
            font-weight: bold;
            display: block; /* Full width clickable area */
            padding: 10px; /* Padding for link */
            transition: background-color 0.3s; /* Smooth transition */
        }

        .sidebar-nav ul li a:hover {
            background-color: lightblue; /* Hover effect */
            border-radius: 5px; /* Maintain rounded corners on hover */
        }
    </style>
</head>
<body>
    <nav class="sidebar-nav" >
        <ul>
            <li><a href="index.php">Orders</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="add_product.php">Add New Product</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="help.php">Help ?</a></li>
        </ul>
    </nav>
</body>
</html>
