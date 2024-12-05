<?php  

    include('server/connection.php');

    if(isset($_GET['product_id'])) // get product_id using GET request
    {
        $product_id = $_GET['product_id'];
        
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product =  $stmt->get_result(); //return an array with [1] product
    }
    //in case no product id is given
    else
    {
        header('location: index.php');
    }

?>

<?php include('layouts/header.php'); ?>

    <!-- Single Product -->
    <section class="container single-product my-5 pt-5"> <!-- container puts images according to the intended size-->
        <div class="row mt-5">

        <?php while($row = $product->fetch_assoc()){ ?>

            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>" id="mainImg"/>
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <h6 style="color: coral; font-weight: bold;"> <?php echo $row['product_area']; ?> </h6>
                <!-- py-4 is padding top/bottom 4 -->
                <h3 class="py-4"> <?php echo $row['product_name']; ?> </h3>
                <h2 class="p-price">$ <?php echo $row['product_price']; ?> </h2>

                <!-- php form session with hidden inputs (add to cart & product_quantity) 
                that will take the user to their cart after clicking on the "add to cart" button -->
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                    <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
                    <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
                    <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

                    <input type="number" name="product_quantity" value="1"/>
                    <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>
                </form>
                
                <!-- mt = margin top | mb = margin bottom -->
                <h4 class="mt-5 mb-5">Product Details</h4>
                <span class="justify-text"> <?php echo $row['product_description']; ?> </span>
            </div>

        <?php } ?>

        </div>
    </section>

    <!-- Related Products -->
    <section id="related-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
            <h3>Related Products</h3>
            <hr class="mx-auto">
        </div>
        <div class="row mx-auto container-fluid">
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/featured1.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Shoes</h5>
                <h4 class="p-price">$ 150.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/featured2.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Bag</h5>
                <h4 class="p-price">$ 145.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/featured3.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports Watch</h5>
                <h4 class="p-price">$ 80.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>

            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/featured4.jpg"/>
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name">Sports T-shirt</h5>
                <h4 class="p-price">$ 110.00</h4>
                <button class="buy-btn">Buy Now</button>
            </div>
        </div>
    </section>

    <!-- JavaScript Function Code -->
    <script>
        // referencing to the main img
        var mainImg = document.getElementById("mainImg");
        // return an array of 4 images with 4 indexes
        var smallImg = document.getElementsByClassName("small-img");

        //instead of repeating the code to be clicked multiple times, we use for loop for clicking other images
        for(let i=0; i<4; i++){
            // listen to clicks for smallImg
            smallImg[i].onclick = function(){
                mainImg.src = smallImg[i].src; // source (src) of the main img will be replaced with the small image (next img)
            }
        }
    </script>

<?php include('layouts/footer.php'); ?>