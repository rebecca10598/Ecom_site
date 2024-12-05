<?php include('layouts/header.php'); ?>

<?php  

    include('server/connection.php');

    if(isset($_SESSION['logged_in'])) // if user has already been registered, take the user to the account page
    {
        header('location: account.php');
        exit;
    }

    if(isset($_POST['register']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if($password !== $confirmPassword) // ensuring password matches the confirmed password
        {
            header('location: register.php?error=The password you entered does not match!');
        }

        else if(strlen($password) < 6) // if password is less than 6 characters
        {
                header('location: register.php?error=Password should be at least 6 characters!');
        }

        else // if there is no error
        {
            // check whether there is a user with the same email or not
            $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
            $stmt1->bind_param('s', $email);
            $stmt1->execute();
            $stmt1->bind_result($num_rows);
            $stmt1->store_result();
            $stmt1->fetch();

            if($num_rows != 0) // if there is a user already registered with this email 
            {
                header('location: register.php?error=User with this email already exists!');
            }

            else // if no user is registered with this email before
            {
                // hashed the password using password_hash()
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // create a new user
                $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?,?,?)");
                $stmt->bind_param('sss', $name, $email, $hashed_password);

                // if account has been created successfully
                if($stmt->execute()) 
                {
                    $user_id = $stmt->insert_id;
                    $_SESSION['user_id'] = $user_id; // insert user id in the session
                    
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['logged_in'] = true;
                    header('location: account.php?register_success=You have successfully registered!');
                }
                else
                {
                    header('location: register.php?error=Account could not be created. Please try again!');
                }
            }
        }
    }    

?>

    <!-- Register -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <!-- Margin right/left auto -->
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" method="POST" action="register.php">
                <p style="color: red"><?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="name" required/>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="email" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Do you have an account? Login here!</a>
                </div>
            </form>
        </div>
    </section>

<?php include('layouts/footer.php'); ?>