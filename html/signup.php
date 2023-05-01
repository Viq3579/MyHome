<?php

session_start();

if (isset($_SESSION["email"])) {

    $mysqli = require __DIR__ . "/../php/database.php";
    $sql = sprintf("SELECT *
                    FROM user
                    WHERE email = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user["user_type"] == "Client") {

        header("Location: home.php");
        exit;

    } else if ($user["user_type"] == "Vendor") {

        header("Location: vendor-home.php");
        exit;

    }
    die("An error has occured.");
    exit;
}

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $is_invalid = false;

    // Connect to mySQL
    $mysqli = require __DIR__ . "/../php/database.php";


    // Email Check
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $is_invalid = true;
        $error_msg = "Valid email is required.";
    }

    // Varify Email is Unique
    if ($is_invalid == false) {
        $sql = sprintf("SELECT *
                        FROM user
                        WHERE email = '%s'",
                    $mysqli->real_escape_string($_POST["email"]));

        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if ($user) {
            $is_invalid = true;
            $error_msg = "Email is already taken.";
        }
    }

    // Password Check and Hash
    if ($is_invalid == false) {
        if (empty($_POST["password"])) {
            $is_invalid = true;
            $error_msg = "Password is required.";
        }
    }
    if ($is_invalid == false) {
        if (strlen($_POST["password"]) < 8) {
            $is_invalid = true;
            $error_msg = "Password must be at least 8 characters.";
        }
    }
    if ($is_invalid == false) {
        if (!preg_match("/[a-z]/", $_POST["password"])) {
            $is_invalid = true;
            $error_msg = "Password must contain a lowercase letter.";
        }
    }
    if ($is_invalid == false) {
        if (!preg_match("/[A-Z]/", $_POST["password"])) {
            $is_invalid = true;
            $error_msg = "Password must contain a capital letter.";
        }
    }
    if ($is_invalid == false) {
        if (!preg_match("/[0-9]/i", $_POST["password"])) {
            $is_invalid = true;
            $error_msg = "Password must contain a number.";
        }
    }
    if ($is_invalid == false) {
        if($_POST["password"] != $_POST["password_confirmation"]) {
            $is_invalid = true;
            $error_msg = "Passwords must match.";
        }
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    // Client or Vendor Check
    if ($is_invalid == false) {
        if (isset($_POST["type"])&& $_POST["type"] == 'Yes') {
            $user_type = "Vendor";
        } else {
            $user_type = "Client";
        }
    }

    // Captcha Validation
    if ($is_invalid == false) {
        $captcha;
        if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
            $is_invalid = true;
            $error_msg = "Check recaptcha";
        }
    }


    // Add Account to Database
    if ($is_invalid == false) {
        $sql = "INSERT INTO user (email, password_hash, user_type)
                VALUES (?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die ("SQL Error: " . $mysqli->error);
        }

        $stmt->bind_param("sss", $_POST['email'], $hash, $user_type);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['email'] = $_POST['email'];
            if ($user_type == 'Client') {
                header("Location: ../html/editprofilep2.php");
            } else if ($user_type == 'Vendor') {
                header("Location: ../html/editprofile3.php");
            }

        } else {
            if ($mysqli->errno == 1062) {
                die("Email already taken");
            } else {
                die($mysqli->error . " " . $mysqli->errno);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>MyHome - Signup</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/login-signup.css">
        <link rel="stylesheet" href="../css/input-form.css">
        <link rel="stylesheet" href="../css/footer.css">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1><a class="header-logo" href="../index.php">MyHome</a></h1>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="login.php">Log In</a>
                    <a class="header-signup signup" href="signup.php">Sign Up</a>
                </div>
            
            </div>

        </header>

        
        <main class="main-content">

            <form class="form" method="post">

                <h2 class="form-header">Create Account</h2>

                <?php
                if ($is_invalid == true) {
                ?>
                    <h3 class="form-error">
                        <?php echo $error_msg ?>
                    </h3>
                <?php
                }
                ?>

                <div class="input">
                    <label class="input-header" for="email">Email:</label>
                    <input class="input-field" type="text" id="email" name="email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>">
                </div>

                <div class="input">
                    <label class="input-header" for="password">Password:</label>
                    <input class="input-field" type="password" id="password" name="password">
                </div>

                <div class="input">
                    <label class="input-header" for="password_confirmation">Confirm Password:</label>
                    <input class="input-field" type="password" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="input inline-input">
                    <input class="input-checkbox" type="checkbox" name="type" value="Yes" id="type" <?php if (isset($_POST['type'])) { echo "checked"; } ?>>
                    <label class="input-header" for="type">Are you a Vendor?</label>
                </div>
                <div class="g-recaptcha input-header" data-sitekey="6Le5aJMlAAAAAAfVkQn_W8IOvOVIJOkQ7WeNgfe1"></div>


                <div class="submit-container">
                    <a class="form-link" href="login.php">Already have an account?</a>
                    <button class="submit-button">Add Account</button>
                </div>

            </form>

        </main>


        <footer class="footer">

            <div class="footer-container">
                <p class="footer-subtitle">Terms and Conditions</p>
                <p class="footer-content">
                    By using this site I consent to MyHome using my submitted data for calculations to determine services which I can afford or which I should be interested in. I also consent to MyHome providing my personal information to vendors in the event that I purchase a service from said vendor. I certify that all information submitted to this site is correct to the best of my knowledge. MyHome is not responsible for faulty results due to incorrect data. MyHome is also not responsible for difficulties in procuring an advertised service beyond the steps streamlined by our calculators. Although users should report fraudulent vendors to MyHome immediately, MyHome is not responsible for reimbursing any lost funds.
                    <!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, doloremque dicta obcaecati odio at alias molestias impedit id sit? Quasi, perspiciatis, eius doloremque corrupti eum laborum laudantium atque nam enim, expedita totam! Consequatur, quos consequuntur praesentium impedit officiis modi blanditiis at eius odio odit nostrum. Doloremque dolorum recusandae at dignissimos aperiam quos quas porro laborum eveniet magni voluptas, autem est, facilis nobis eligendi architecto magnam. Laudantium inventore earum vero culpa eius facere est neque eos! -->
                </p>
            </div>
            <div class="footer-container">
                <p class="footer-subtitle">Privacy Policy</p>
                <p class="footer-content">
                    Any and all data submitted to this webpage is used solely for the purposes of maintaining the user's account and performing the advertised services. No additional data beyond that explicitely submitted is every collected by this webpage. Data collected here is never sold to or otherwise acquired by any third party. Additionally, this site does not acquire or use any data from any third party source, either for advertising or service caldulation.
                    <!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, doloremque dicta obcaecati odio at alias molestias impedit id sit? Quasi, perspiciatis, eius doloremque corrupti eum laborum laudantium atque nam enim, expedita totam! Consequatur, quos consequuntur praesentium impedit officiis modi blanditiis at eius odio odit nostrum. Doloremque dolorum recusandae at dignissimos aperiam quos quas porro laborum eveniet magni voluptas, autem est, facilis nobis eligendi architecto magnam. Laudantium inventore earum vero culpa eius facere est neque eos! -->
                </p>
            </div>
            <div class="footer-container">
                <p class="footer-subtitle">Cookie Policy</p>
                <p class="footer-content">
                    MyHome does not use cookies, however should future optimizations require cookies, said cookies serve exclusively to increase efficiency and improve the user experience. No cookies should collect any user data that would lie beyond the scope of that explicitely submitted, and no cookies should have any communication with an external site. All cookies should be entirely optional, with the site being functional and accessible regardless of whether or not they are accepted.
                </p>
            </div>

        </footer>
    </body>

</html>