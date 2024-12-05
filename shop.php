<?php 

    include('server/connection.php');

    // 1. determine current page number for pagination (ensuring page_no is always set, defaulting to 1 if not provided)
    $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? $_GET['page_no'] : 1;

    if (isset($_POST['search'])) // check if the search form has been submitted
    {
        // get category & price values from form
        $category = $_POST['category'];
        $price = $_POST['price'];
        
        // split comma-separated category values into an array (for singular/plural forms)
        $categories = explode(',', $category);
        
        // prepare SQL query to search products matching either category (singular/plural) & have a price <= to selected price
        $stmt = $conn->prepare
        (
            "SELECT * FROM products 
                            WHERE (product_category LIKE ? OR product_category LIKE ?) 
                            AND product_price <= ?"
        );

        // bind parameters for category (singular/plural) & price to the SQL query
        $stmt->bind_param('ssi', $categories[0], $categories[1], $price);
        $stmt->execute();
        $products = $stmt->get_result(); 
    } 
    // if no search is submitted, return all products
    else 
    {   
        // 2. get total number of products in the db
        $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM products");
        $stmt1->execute();
        $stmt1->bind_result($total_records);
        $stmt1->store_result();
        $stmt1->fetch();

        // 3. define how many products will be displayed per page
        $total_records_per_page = 8;

        // calculate offset where products for the current page should start
        $offset = ($page_no-1) * $total_records_per_page; // formula allows fetching correct products based on page number

        // calculate previous & next page numbers for pagination links
        $previous_page = $page_no - 1 ;
        $next_page = $page_no + 1;
        $adjacents = "2"; // number of adjacent pages to show in pagination links

        // calculate total number of pages needed (based on total records & records per page)
        $total_no_of_pages = ceil($total_records/$total_records_per_page);

        // 4. get all products for current page (limiting result to products per page)
        $stmt2 = $conn->prepare("SELECT * FROM products LIMIT ?, ?");
        $stmt2->bind_param('ii', $offset, $total_records_per_page); // parameter binding to avoid risks of SQL injection
        $stmt2->execute();
        $products = $stmt2->get_result(); 
    }

?>

<?php include('layouts/header.php'); ?>

    <!-- Search Products -->
    <section id="search_shop" class="my-5 py-5 ms-2">
        <div class="container mt-5 py-5">
            <p>Search Products</p>
            <hr>
        </div>

        <form action="shop.php" method="POST">
            <div class="row mx-auto container">
                <div class="col-lg-12 col-md-12 col-sm-12">
                <p>Category:</p>
                    <div class="form-check">
                        <input id="category_one" class="form-check-input" value="shoe,shoes" type="radio" name="category" 
                            <?php if(isset($category) && $category=="shoe,shoes") {echo 'checked';} ?> />
                        <label class="form-check-label" for="flexRadioDefault1" >
                            Shoes
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="category_two" class="form-check-input" value="watch,watches" type="radio" name="category" 
                            <?php if(isset($category) && $category=="watch,watches") {echo 'checked';} ?> />
                        <label class="form-check-label" for="flexRadioDefault2" >
                            Watches
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="category_two" class="form-check-input" value="dresses_coats" type="radio" name="category" 
                            <?php if(isset($category) && $category=='dresses_coats') {echo 'checked';} ?> />
                        <label class="form-check-label" for="flexRadioDefault2" >
                            Dresses & Coats
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="category_two" class="form-check-input" value="top,tops" type="radio" name="category" 
                            <?php if(isset($category) && $category=="top,tops") {echo 'checked';} ?> />
                        <label class="form-check-label" for="flexRadioDefault2" >
                            Tops
                        </label>
                    </div>
                    <div class="form-check">
                        <input id="category_two" class="form-check-input" value="bag,bags" type="radio" name="category" 
                            <?php if(isset($category) && $category=="bag,bags") {echo 'checked';} ?> />
                        <label class="form-check-label" for="flexRadioDefault2" >
                            Bags
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mx-auto container mt-5">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p>Price:</p>
                    <input type="range" id="customRange2" class="form-range w-80" name="price" 
                        value="<?php if(isset($price)) {echo $price;} else {echo "100";} ?>" min="1" max="1000" />
                    <div class="w-80">
                        <span style="float: left;">1</span>
                        <span style="float: right;">1000</span>
                    </div>
                </div>
            </div>

            <div class="form-group my-3 mx-3">
                <input type="submit" name="search" value="Search" class="btn btn-primary" />
            </div>
        </form>
    </section>

    <!-- Shop (All Products) -->
    <section id="featured_shop" class="my-5 py-5">
        <div class="container mt-4">
            <h3>Our Products</h3>
            <hr>
            <p>Here you can check out all of our products!</p>
            <br>
        </div>
        <!-- "container" for more space from the right/left-->
        <div class="row mx-auto container">

        <?php while($row = $products->fetch_assoc() ) { ?>

            <!-- go to another page after clicking on a product -->
            <div onclick="window.location.href='single_product.php';" class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'];?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name'];?></h5>
                <h4 class="p-price">$ <?php echo $row['product_price'];?> </h4>
                <!-- takes the user to the single product page with the product_id -->
                <a class="btn shop-buy-btn" href="<?php echo "single_product.php?product_id=".$row['product_id'];?>">
                    Buy Now
                </a>
            </div>

        <?php } ?>

            <nav aria-label="Page navigation example"> <!-- bootstrap navigation component for pagination -->
                <ul class="pagination mt-5">
                    <li class="page-item <?php if($page_no <= 1) {echo 'disabled';} ?> ">
                        <!-- if current page is the 1st page (page_no <= 1), the link is disabled. 
                                otherwise, it links to the previous page -->
                        <a class="page-link" href="<?php if($page_no<=1) {echo '#';} else {echo "?page_no=".($page_no-1);} ?>">
                            Previous
                        </a>
                    </li>

                    <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

                    <!-- if current page is 3 or higher, display ... & current page number -->
                    <?php if($page_no >= 3) { ?>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo "?page_no=".$page_no;?>">
                                <?php echo $page_no; ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="page-item <?php if($page_no >= $total_no_of_pages) {echo 'disabled';} ?> ">
                        <!-- if current page is the last one, the link is disabled.
                                otherwise, it links to the next page -->
                        <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) {echo '#';} else {echo "?page_no=".($page_no+1);} ?>">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </section>

<?php include('layouts/footer.php'); ?>