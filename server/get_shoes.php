<?php 

    include('connection.php');

    //create http query that connects to database & retrieves Watches > store in a variable called $stmt 
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_category='shoes' LIMIT 4");

    $stmt->execute();

    //store results in a variable called $coats_products
    $shoes_products =  $stmt->get_result();

?>