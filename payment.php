<?php 
// Include Composer autoload (adjust the path if necessary)
require_once __DIR__ . '/vendor/autoload.php'; 

// Load .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Retrieve PayPal client ID from .env
$paypalClientId = $_ENV['PAYPAL_CLIENT_ID'];

include('layouts/header.php'); 
?>

<?php 

    if(isset($_POST['order_pay_btn'])) 
    {
        $order_status = $_POST['order_status'];
        $order_total_price = isset($_POST['order_total_price']) ? $_POST['order_total_price'] : 0; 
    }

?>

    <!-- Payment -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container text-center">

            <!-- user came from account (not paid orders) -->
            <!-- if no total in session, but 'order_status' is set in POST & it's "not paid" -->
            <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
                <?php $amount = strval(isset($_POST['order_total_price']) ? $_POST['order_total_price'] : 0); ?>

                <?php $order_id = $_POST['order_id']; ?>

                <!-- display total payment from POST data & 'Pay Now' btn -->
                <p>Total Payment is: $ <?php echo number_format($amount, 2); ?></p>                
                <!-- PayPal button container -->
                <div id="paypal-button-container" style="margin-top: 20px; display: inline-block; width: 400px;"></div>
            <?php }

            // ser came from the cart with items (not empty)
            else if(isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
                <!-- get total (converted to string) & store in variable $amount -->
                <?php $amount = strval($_SESSION['total']); ?> 

                <?php $order_id = $_SESSION['order_id']; ?>

                <!-- display total payment from session with 'Pay Now' btn -->
                <p>Total Payment is: $ <?php echo number_format($amount, 2); ?></p>
                <!-- PayPal button container -->
                <div id="paypal-button-container" style="margin-top: 20px; display: inline-block; width: 400px;"></div>
            <?php }
            
            // neither condition is met, display message
            else { ?>
                <p>You have not placed an Order to make a payment</p>
            <?php } ?>

        </div>
    </section>

    <!-- include PayPal SDK & render button -->
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypalClientId; ?>&currency=USD"></script>

    <script>
        // render PayPal button into #paypal-button-container
        paypal.Buttons({
            // button customization
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',
            },

            // create an order
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $amount; ?>' // payment amount
                        }
                    }]
                });
            },

            // capture funds from transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name);
                    // redirect to success page or update order status
                    let details_id = details.id; // extract transaction id
                    // change the order status & store payment info in the db
                    window.location.href = "server/complete_payment.php?details_id=" + details_id + "&order_id=<?php echo $order_id; ?>";                });
            },

            // On error
            onError: function (err) {
                console.error("PayPal error: ", err);
                alert('An error occurred during the payment process.');
            },

            // On cancel
            onCancel: function(data) {
                alert('Payment cancelled.');
            }
        }).render('#paypal-button-container'); // display paypal button
    </script>

<?php include('layouts/footer.php'); ?>
