<?php include('layouts/header.php'); ?>
    
    <!-- Home -->
    <section id="home">
        <div class="container">
            <h5>NEW ARRIVALS</h5>
            <h1><span>Best Prices</span> This Season</h1>
            <p>E-shop offers the best products for the most affordable prices</p>
            <a href="shop.php"><button>Shop Now!!</button></a>
        </div>
    </section>
    
    <!-- Brands -->
    <section id="brand" class="container">
        <div class="row">
            <!-- Pictures displayed in 3 different screen sizes -->
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand1.jpg"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand2.jpg"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand3.jpg"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand4.jpg"/>
        </div>
    </section>

    <!-- New Section -->
    <section id="new" class="w-100">
        <div class="row p-0 m-0">
            <!-- 1st -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/1.jpg"/>
                <div class="details">
                    <h2>Awesome White Shoes</h2>
                    <button class="text-uppercase">Shop Now!</button>
                </div>
            </div>
            <!-- 2nd -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/2.jpg"/>
                <div class="details">
                    <h2>Awesome Jackets</h2>
                    <button class="text-uppercase">Shop Now!</button>
                </div>
            </div>
            <!-- 3rd -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/3.jpg"/>
                <div class="details">
                    <h2>Awesome Watches 50% Off</h2>
                    <button class="text-uppercase">Shop Now!</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3>Our Featured</h3>
            <hr class="mx-auto">
            <p>Here you can check out our featured products!</p>
        </div>
        <div class="row mx-auto container-fluid">

        <!-- to get all 4 featured products from fb, include relevant file ABOVE the loop -->
        <?php include('server/get_featured_products.php'); ?>

        <?php while($row = $featured_products->fetch_assoc()){ ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"> <?php echo $row['product_name']; ?> </h5>
                <h4 class="p-price"> $ <?php echo $row['product_price']; ?> </h4>
                <!-- Take to different single product pages when clicked on buy btn -->
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>"> <button class="buy-btn">Buy Now</button></a>
            </div>

            <?php } ?>

        </div>
    </section>

    <!-- Banner -->
    <section id="banner" class="my-5 py-5"> <!-- my = margin top/bottom | py = padding top/bottom -->
        <div class="container">
            <h4>MID SEASON SALE</h4>
            <h1>Autumn Collection <br> up to 30% OFF</h1>
            <button class="text-uppercase">SHOP NOW</button>
        </div>
    </section>

    <!-- Clothes -->
    <section id="clothes" class="my-5">
        <div class="container text-center mt-5 py-5">
            <h3>Dresses & Coats</h3>
            <hr class="mx-auto">
            <p>Here you can check out our amazing Dresses & Coats!</p>
        </div>
        <div class="row mx-auto container-fluid">

        <!-- To get all 4 products from phpMyAdmin database, include get_dresses_coats -->
        <?php include('server/get_dresses_coats.php'); ?>

        <?php while($row = $dresses_coats_products->fetch_assoc()){ ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"> <?php echo $row['product_name']; ?> </h5>
                <h4 class="p-price">$ <?php echo $row['product_price']; ?> </h4>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>"> <button class="buy-btn">Buy Now</button></a>
            </div>

            <?php } ?>

        </div>
    </section>

    <!-- Watches -->
    <section id="watches" class="my-5">
        <div class="container text-center mt-5 py-5">
            <h3>Watches</h3>
            <hr class="mx-auto">
            <p>Here you can check out our unique Watches!</p>
        </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_watches.php'); ?> 

        <?php while($row = $watches_products->fetch_assoc()){ ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"> <?php echo $row['product_name']; ?> </h5>
                <h4 class="p-price">$ <?php echo $row['product_price']; ?> </h4>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>"> <button class="buy-btn">Buy Now</button></a>
            </div>

            <?php } ?>

        </div>
    </section>

    <!-- Shoes -->
    <section id="shoes" class="my-5">
        <div class="container text-center mt-5 py-5">
            <h3>Shoes</h3>
            <hr class="mx-auto">
            <p>Here you can check out our amazing Shoes!</p>
        </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_shoes.php'); ?>

        <?php while($row = $shoes_products->fetch_assoc()){ ?>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"> <?php echo $row['product_name']; ?> </h5>
                <h4 class="p-price">$ <?php echo $row['product_price']; ?> </h4>
                <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>"> <button class="buy-btn">Buy Now</button></a>
            </div>

            <?php } ?>

        </div>
    </section>

<?php include('layouts/footer.php'); ?>