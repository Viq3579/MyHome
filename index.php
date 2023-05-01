<?php

    session_start();

    $_SESSION;

    if (isset($_SESSION["email"])) {

        $mysqli = require __DIR__ . "/php/database.php";
        $sql = sprintf("SELECT *
                        FROM user
                        WHERE email = '%s'",
                    $mysqli->real_escape_string($_SESSION["email"]));

        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if ($user["user_type"] == "Client") {

            header("Location: html/home.php");
            exit;

        } else if ($user["user_type"] == "Vendor") {

            header("Location: html/vendor-home.php");
            exit;

        }
        die("An error has occured.");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>MyHome</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/coverpage.css">
        <link rel="stylesheet" href="css/footer.css">
    </head>


    <body>
        
        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="html/login.php">Log In</a>
                    <a class="header-signup signup" href="html/signup.html">Sign Up</a>
                </div>
            
            </div>

        </header>
        

        <main class="main-content">

            <div class="cover">
                <h1 class="cover-logo">MyHome</h1>
    
                <div class="cover-info">
                    <p class="cover-description">
                        Find & manage services fast! Your home for everything your home needs.
                    </p>
                    
                    <a class="signup" href="html/signup.html">Sign Up Today</a>
                </div>
            </div>

            <div class="product-info">
                <div class="info-card info-card-l">
                    <div class="info-card-icon">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <div class="info-card-description">
                        <h2 class="info-card-title">What We Do</h2>
                        <p class="info-card-text">
                            Here at MyHome, we provide a convenient interface for finding & managing all the services you or your home need. You can track existing services, document your home information, and find new services all with the press of a button. We'll even assess your needs and recommend the services we think best fit your situation and budget. So what are you waiting for? Sign Up Today!
                            <!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui provident cupiditate iste repudiandae quasi ut eum fuga, aperiam voluptatum atque vel ex animi officiis voluptatibus dolore, quas eligendi assumenda unde deleniti neque accusamus. Ab, voluptatum est quisquam minima vitae autem vero aperiam pariatur commodi praesentium necessitatibus reiciendis maxime quod iure. -->
                        </p>
                    </div>
                </div>
                <div class="info-card info-card-r">
                    <div class="info-card-icon">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div class="info-card-description">
                        <h2 class="info-card-title">For Vendors...</h2>
                        <p class="info-card-text">
                            If you're a vendor, we provide a convenient storefront for listing and advertising all the services your company offers. We'll find you the customers that best match your services, and even allow you to negotiate with the more savvy clients out there. All your current clients are listed in one convenient space, so no more annoying bookkeeping to keep track of these things!
                            <!-- Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum tempora repellat dicta voluptas animi qui placeat, nam earum eaque, fugiat officiis quasi rerum, perferendis et inventore alias ipsam. Pariatur error vel quos non perspiciatis reprehenderit! Aliquid accusamus magni iure delectus adipisci, quidem illo. Deleniti quia, ratione reiciendis sint sapiente cumque. -->
                        </p>
                    </div>
                </div>
                <div class="info-card info-card-l">
                    <div class="info-card-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="info-card-description">
                        <h2 class="info-card-title">How It Works</h2>
                        <p class="info-card-text">
                            As a customer, you'll provide us with basic information about your home, vehicles, and general financial situation. You'll also be able to list any existing services you already have. We'll then use this information, assessing your needs and current services, to calculate a list of recommended services. You'll also be able search for specific services and filter them by affordability.
                            <br><br>
                            As a vendor, you provide us with some basic information about your company and one or more services, and then we take care of the rest! We'll bring the customers to you, and all you have to do is verify customer requests and do some occaisonal negotiation.
                            <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident in soluta rem quibusdam sunt veniam doloremque assumenda neque, ducimus labore itaque mollitia eos eaque ab modi, dolor sed at. Harum quis odit tempora incidunt culpa at asperiores, assumenda numquam nesciunt itaque deserunt voluptates fuga temporibus! Expedita cumque nulla neque aperiam. -->
                        </p>
                    </div>
                </div>
            </div>
        
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
<!-- 
    HEAD
    <script src="jquery.js"></script> 
    <script> 
        $(function(){
            $("#includedContent").load("b.html"); 
        });
    </script>

    BODY
    <div id="includedContent"></div> 
-->