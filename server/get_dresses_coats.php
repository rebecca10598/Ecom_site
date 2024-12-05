<?php 

    include('connection.php');

    //create http query that connects to database & retrieves Dresses & Coats > store in a variable called $stmt 
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_category='dresses_coats' LIMIT 4");

    $stmt->execute();

    //store results in a variable called $coats_products
    $dresses_coats_products =  $stmt->get_result();

?>