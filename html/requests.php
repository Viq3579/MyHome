<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

$mysqli = require __DIR__ . "/../php/database.php";

// Finds all the Quote Requests
$sql = sprintf("SELECT q.cname as name, q.sname as service, q.email as email
                FROM quoterequest as q, provider as p
                where q.pname = p.name
                AND p.email = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));

$quote_result = $mysqli->query($sql);

// Finds all the Negotiations
$sql = sprintf("SELECT c.name as name, o.cemail as customer, o.pemail as vendor, o.sname as service, o.cost as cost, o.terms as terms, o.address as address
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


if (isset($_POST["email"])) {
    $sql = sprintf("SELECT name
                    FROM provider
                    WHERE email = '%s'",
                    $mysqli->real_escape_string($_SESSION["email"]));
        
    $result = $mysqli->query($sql);
    $pname = $result->fetch_assoc();

    $sql = sprintf("DELETE FROM quoterequest
                    WHERE pname = '%s'
                    AND sname = '%s'
                    AND email = '%s'",
                    $pname["name"],
                    $_POST["service"],
                    $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    header("Location: requests.php");
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

                <div class="center-content">
                    <h1 class="title">Negotiations</h1>

                    <?php
                    while ($negotiations = $negotiation_result->fetch_assoc()) {
                    ?>
                        <div class="item important-item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid fa-user"></i>
                                <h3 class="item-title">
                                    <?php echo $negotiations["name"] ?>
                                </h3>
                            </div>
                            <p class="item-subtitle">Service Negotiating:</p>
                            <p class="item-description">
                                <?php echo $negotiations["service"] ?>
                            </p>
                            <p class="item-subtitle">Offered Terms:</p>
                            <p class="item-description">
                                <?php echo $negotiations["terms"] ?>
                            </p>
                            <p class="item-description">Wanted Price: <b>
                                $<?php echo $negotiations["cost"] ?>
                            </b></p>
                            <a 
                            class="item-footer item-footer-button"
                            href="vendor-negotiate.php?customer_email=<?php echo $negotiations["customer"] ?>&provider_email=<?php echo $negotiations["vendor"] ?>&service_name=<?php echo $negotiations["service"] ?>&address=<?php echo $negotiations["address"] ?>">
                                <b>Review Offer</b>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="left-content">
                    <h1 class="title">Send Quotes</h1>

                    <?php
                    while ($quote_requests = $quote_result->fetch_assoc()) {
                    ?>
                        <div class="item highlighted-item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid fa-user"></i>
                                <h3 class="item-title">
                                    <?php echo $quote_requests["name"] ?>
                                </h3>
                            </div>
                            <p class="item-subtitle">Quote on:</p>
                            <p class="item-description">
                                <?php echo $quote_requests["service"] ?>
                            </p>
                            <button class="item-footer item-footer-button" id="quoteButton" 
                            data-name="<?php echo $quote_requests["name"] ?>" 
                            data-email="<?php echo $quote_requests["email"] ?>" 
                            data-service="<?php echo $quote_requests["service"] ?>"><b>Send Quote</b></button>
                        </div>
                    <?php
                    }
                    ?>

                </div>

                <div class="right-content">
                    <h1 class="title">Sign Customers</h1>

                    <?php
                    while ($other = $other_result->fetch_assoc()) {
                    ?>
                        <div class="item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid fa-user"></i>
                                <h3 class="item-title">
                                    <?php echo $other["name"] ?>
                                </h3>
                            </div>
                            <p class="item-subtitle">Service Purchased:</p>
                            <p class="item-description">
                                <?php echo $other["service"]?>
                            </p>
                            <button class="item-footer item-footer-button"><b>Review Contract</b></button>
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </div>


            <form class="item highlighted-item popup" id="popup" method="post">

                <h3 class="item-title">Quote Sent</h3>
                <p class="item-subtitle" id="popupSubtitle">
                    A quote has been to [NAME] for the following service:
                </p>
                <p class="item-description" id="popupDescription">
                    [SERVICE]
                </p>

                <input id="emailPopupInput" type="hidden" name="email" value="">
                <input id="servicePopupInput" type="hidden" name="service" value="">

                <button class="item-footer item-footer-button" id="closePopup"><b>Okay</b></button>

            </div>


            <script>
                const quoteButtons = document.querySelectorAll("#quoteButton");

                var popup = document.getElementById("popup");
                var popupSubtitle = document.getElementById("popupSubtitle");
                var popupDescription = document.getElementById("popupDescription");
                var emailPopupInput = document.getElementById("emailPopupInput");
                var servicePopupInput = document.getElementById("servicePopupInput");
                var closeButton = document.getElementById("closePopup");

                quoteButtons.forEach(quoteButton => {
                    var name = quoteButton.dataset.name;
                    var email = quoteButton.dataset.email;
                    var service = quoteButton.dataset.service;
                    quoteButton.addEventListener("click", function() {
                        popup.style.display = "grid";
                        popupSubtitle.textContent = "A quote has been to " + name + " for the following service:";
                        popupDescription.textContent = service;
                        emailPopupInput.value = email;
                        servicePopupInput.value = service;
                    });
                });
                
                closeButton.addEventListener("click", function() {
                    popup.style.display = "none";
                });
            </script>
            
            
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