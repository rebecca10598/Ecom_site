<?php 

    include('connection.php');

    //create http query that connects to database & retrieves all 4 Products > store in a variable called $stmt 
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_category IN ('shoe', 'bag', 'watch', 'top') LIMIT 4");


    $stmt->execute();

    //store results in a variable called $featured_products
    $featured_products =  $stmt->get_result();

?>