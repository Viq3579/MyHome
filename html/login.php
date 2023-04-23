<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysqli = require __DIR__ . "/../php/database.php";

    $sql = sprintf("SELECT *
                    FROM user
                    WHERE email = '%s'",
                $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();
            session_regenerate_id();
            $_SESSION["email"] = $user["email"];

            if ($user["user_type"] == 'Client') {
                header("Location: home.php");
            } else if ($user["user_type"] == 'Vendor') {
                header("Location: vendor-home.php");
            }
            exit;
        }
    }

    $is_invalid = true;
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
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1><a class="header-logo" href="../index.html">MyHome</a></h1>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="login.php">Log In</a>
                    <a class="header-signup signup" href="signup.html">Sign Up</a>
                </div>
            
            </div>

        </header>

        
        <main class="main-content">

            <form class="form" method="post">

                <h2 class="form-header">Log In</h2>

                <div class="input">
                    <label class="input-header" for="email">Email:</label>
                    <input class="input-field" type="email" id="email" name="email">
                </div>

                <div class="input">
                    <label class="input-header" for="password">Password:</label>
                    <input class="input-field" type="password" id="password" name="password">
                </div>

                <div class="submit-container">
                    <a class="input-header" href="signup.html">Create account?</a>
                    <a class="input-header" href="forgotpass.php">Forgot password?</a>
                    <button class="submit-button">Log In</button>
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