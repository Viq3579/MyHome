<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

$mysqli = require __DIR__ . "/../php/database.php";

// Finds all the Quote Requests
$sql = sprintf("SELECT q.cname as name, q.sname as service
                FROM quoterequest as q, provider as p
                where q.pname = p.name
                AND p.email = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));

$quote_result = $mysqli->query($sql);

// Finds all the Negotiations
$sql = sprintf("SELECT c.name as name, o.sname as service, o.cost as cost, o.terms as terms
                FROM customer as c, offers as o, provider as p
                WHERE c.email = o.cemail
                AND p.email = o.pemail
                AND o.pemail = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));
        
$negotiation_result = $mysqli->query($sql);

// Finds all Payments and Service Requests
$sql = sprintf("SELECT c.name as name, u.name as service
                FROM customer as c, unverifiedservice as u, provider as p
                WHERE c.email = u.cemail
                AND u.provider = p.name
                AND p.email = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));

$other_result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>MyHome</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>

                <nav class="header-nav">

                    <a class="header-links" href="vendor-home.php">Services</a>
                    <a class="header-links" href="clients.php">Clients</a>
                    <a class="header-links current-page" href="">Requests</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div class="container">

                <div class="left-content">
                    <h1 class="title">Send Quotes</h1>

                    <?php
                    while ($quote_requests = $quote_result->fetch_assoc()) {
                        echo "<div class=\"item highlighted-item\">";
                        echo    "<div class=\"item-title-container\">";
                        echo        "<i class=\"item-title fa-solid fa-user\"></i>";
                        echo        "<h3 class=\"item-title\">" . $quote_requests["name"] . "</h3>";
                        echo    "</div>";
                        echo    "<p class=\"item-subtitle\">Quote on:</p>";
                        echo    "<p class=\"item-description\">";
                        echo        $quote_requests["service"];
                        echo    "</p>";
                        echo    "<button class=\"item-footer item-footer-button\" id=\"quoteButton\"><b>Send Quote</b></button>";
                        echo "</div>";
                    }
                    ?>

                </div>

                <div class="center-content">
                    <h1 class="title">Negotiations</h1>

                    <?php
                    while ($negotiations = $negotiation_result->fetch_assoc()) {
                        echo"<div class=\"item important-item\">";
                        echo    "<div class=\"item-title-container\">";
                        echo        "<i class=\"item-title fa-solid fa-user\"></i>";
                        echo        "<h3 class=\"item-title\">" . $negotiations["name"] . "</h3>";
                        echo    "</div>";
                        echo    "<p class=\"item-subtitle\">Service Negotiating:</p>";
                        echo    "<p class=\"item-description\">" . $negotiations["service"] . "</p>";
                        echo    "<p class=\"item-subtitle\">Offered Terms:</p>";
                        echo    "<p class=\"item-description\">" . $negotiations["terms"] . "</p>";
                        echo    "<p class=\"item-description\">Wanted Price: <b>$" . $negotiations["cost"] . "</b></p>";
                        echo    "<button class=\"item-footer item-footer-button\"><b>Review Offer</b></button>";
                        echo"</div>";
                    }
                    ?>
                </div>

                <div class="right-content">
                    <h1 class="title">Sign Customers</h1>

                    <?php
                    while ($other = $other_result->fetch_assoc()) {
                        echo "<div class=\"item\">";
                        echo    "<div class=\"item-title-container\">";
                        echo        "<i class=\"item-title fa-solid fa-user\"></i>";
                        echo        "<h3 class=\"item-title\">" . $other["name"] . "</h3>";
                        echo    "</div>";
                        echo    "<p class=\"item-subtitle\">Service Purchased:</p>";
                        echo    "<p class=\"item-description\">" . $other["service"] . "</p>";
                        echo    "<button class=\"item-footer item-footer-button\"><b>Review Contract</b></button>";
                        echo "</div>";
                    }
                    ?>
                </div>

            </div>

            <div class="item popup" id="quotePopup">

                <h3 class="item-title">Quote Sent</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea aut qui pariatur temporibus veritatis provident laboriosam veniam? Iure, tempora beatae!
                </p>
                <button class="item-footer item-footer-button" id="closePopup"><b>Okay</b></button>

            </div>


            <script>
                var quoteButton = document.getElementById("quoteButton");
                var quotePopup = document.getElementById("quotePopup");
                var closeButton = document.getElementById("closePopup")

                quoteButton.addEventListener("click", function() {
                    quotePopup.style.display = "block";
                });
                closeButton.addEventListener("click", function() {
                    quotePopup.style.display = "none";
                });
            </script>
            
            
        </main>


        <footer class="footer">

            <div class="footer-container">
                <p class="footer-subtitle">Terms and Conditions</p>
                <p class="footer-content">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, doloremque dicta obcaecati odio at alias molestias impedit id sit? Quasi, perspiciatis, eius doloremque corrupti eum laborum laudantium atque nam enim, expedita totam! Consequatur, quos consequuntur praesentium impedit officiis modi blanditiis at eius odio odit nostrum. Doloremque dolorum recusandae at dignissimos aperiam quos quas porro laborum eveniet magni voluptas, autem est, facilis nobis eligendi architecto magnam. Laudantium inventore earum vero culpa eius facere est neque eos!
                </p>
            </div>
            <div class="footer-container">
                <p class="footer-subtitle">Privacy Policy</p>
                <p class="footer-content">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, doloremque dicta obcaecati odio at alias molestias impedit id sit? Quasi, perspiciatis, eius doloremque corrupti eum laborum laudantium atque nam enim, expedita totam! Consequatur, quos consequuntur praesentium impedit officiis modi blanditiis at eius odio odit nostrum. Doloremque dolorum recusandae at dignissimos aperiam quos quas porro laborum eveniet magni voluptas, autem est, facilis nobis eligendi architecto magnam. Laudantium inventore earum vero culpa eius facere est neque eos!
                </p>
            </div>
            <div class="footer-container">
                <p class="footer-subtitle">Cookie Policy</p>
                <p class="footer-content">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum, nobis excepturi consequatur similique accusamus repudiandae doloremque quos minus eaque temporibus rem omnis aut quis commodi eligendi ratione nulla suscipit laudantium accusantium, explicabo debitis nihil dignissimos. Quia esse quis necessitatibus perspiciatis architecto explicabo totam quae odit placeat voluptatum accusamus neque aperiam fuga reiciendis eligendi ab quas tenetur, voluptates temporibus cumque ipsa similique fugiat. Voluptatibus reiciendis quibusdam modi consectetur voluptas ab rem quas veniam ullam, quod repellat!
                </p>
            </div>

        </footer>

    </body>

</html>