<?php include('layouts/header.php'); ?>

<?php  

    include('server/connection.php');

    if(isset($_SESSION['logged_in'])) 
    {
        header('location: account.php');
        exit;
    }

    // check if user clicked on the login button
    if(isset($_POST['login_btn'])) 
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // prepare SQL statement to check email and get hashed password
        $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? LIMIT 1");
        $stmt->bind_param('s', $email);

        if($stmt->execute()) 
        {
            $stmt->bind_result($user_id, $user_name, $user_email, $hashed_password);
            $stmt->store_result();

            if($stmt->num_rows() == 1) 
            {
                $stmt->fetch();

                // verify the password using password_verify()
                if(password_verify($password, $hashed_password)) 
                {
                    // set session variables
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_name'] = $user_name;
                    $_SESSION['user_email'] = $user_email;
                    $_SESSION['logged_in'] = true;

                    header('location: account.php?login_success=You have successfully Logged in!');
                } 
                else 
                {
                    header('location: login.php?error=Could not verify your account due to incorrect credentials!');
                }
            } 
            else 
            {
                header('location: login.php?error=Could not verify your account due to incorrect credentials!');
            }
        } 
        else 
        {
            header('location: login.php?error=Something went wrong. Please try again!');
        }
    }

?>

    <!-- Login -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <!-- Margin right/left auto -->
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php">
                <p style="color: red" class="text-center">
                    <?php if(isset($_GET['error'])) { echo $_GET['error']; } ?>
                </p>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="email" required/>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="password" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
                </div>
                <div class="form-group">
                    <a id="register-url" href="register.php" class="btn">Don't have an account? Register here!</a>
                </div>
            </form>
        </div>
    </section>

<?php include('layouts/footer.php'); ?>