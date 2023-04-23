<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

$mysqli = require __DIR__ . "/../php/database.php";

// Gets the Negotiation Information
$customer_email = $_GET["customer_email"];
$provider_email = $_GET["provider_email"];
$service_name = $_GET["service_name"];
$address = $_GET["address"];

$sql = sprintf("SELECT c.name as cname, o.cemail as cemail, p.name as pname, o.pemail as pemail, o.sname as sname, o.type as type, o.cost as cost, s.description as description, o.terms as terms, o.penalty as penalty, o.address as address
                FROM offers as o, customer as c, provider as p, service as s
                WHERE o.cemail = c.email
                AND o.pemail = p.email
                AND o.sname = s.name
                AND o.pemail = s.provider
                AND o.cemail = '%s'
                AND o.pemail = '%s'
                AND o.sname = '%s'
                AND o.address = '%s'",
                $mysqli->real_escape_string($customer_email),
                $mysqli->real_escape_string($provider_email),
                $mysqli->real_escape_string($service_name),
                $mysqli->real_escape_string($address));
                
$result = $mysqli->query($sql);                
$negotiation = $result->fetch_assoc();


// Accepts or Rejects the Negotiation
if (isset($_POST["acceptButton"])) {
    $sql = "INSERT INTO customservice (name, cemail, address, type, cost, description, terms, penalty, provider)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die ("SQL Error: " . $mysqli->error);
    }

    $stmt->bind_param("sssssssss", 
        $negotiation["sname"],
        $negotiation["cemail"],
        $negotiation["address"],
        $negotiation["type"],
        $negotiation["cost"],
        $negotiation["description"],
        $negotiation["terms"],
        $negotiation["penalty"],
        $negotiation["pemail"],
    );

    $stmt->execute();


    $sql = sprintf("DELETE FROM offers
                        WHERE cemail = '%s'
                        AND pemail = '%s'
                        AND sname = '%s'
                        AND address = '%s'",
                        $mysqli->real_escape_string($customer_email),
                        $mysqli->real_escape_string($provider_email),
                        $mysqli->real_escape_string($service_name),
                        $mysqli->real_escape_string($address));
        
    $result = $mysqli->query($sql);

    header("Location: requests.php");
}     
else if (isset($_POST["rejectButton"])) {
    $sql = sprintf("DELETE FROM offers
                    WHERE cemail = '%s'
                    AND pemail = '%s'
                    AND sname = '%s'
                    AND address = '%s'",
                    $mysqli->real_escape_string($customer_email),
                    $mysqli->real_escape_string($provider_email),
                    $mysqli->real_escape_string($service_name),
                    $mysqli->real_escape_string($address));
    
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
                    <a class="header-links" href="requests.php">Requests</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div class="container">

                <div class="center-content">

                    <h1 class="title">
                        <?php echo $negotiation["cname"] ?>'s Negotiation
                    </h1>

                    <form class="item important-item clear" method="post">
                        
                        <p class="item-subtitle">Customer's Address:</p>
                        <p class="item-description">
                            <?php echo $negotiation["address"] ?>
                        </p>

                        <p class="item-subtitle">Service Name:</p>
                        <p class="item-description">
                            <?php echo $negotiation["sname"] ?>
                        </p>

                        <p class="item-subtitle">Negotiating Terms:</p>
                        <p class="item-description">
                            <?php echo $negotiation["terms"] ?>
                        </p>

                        <p class="item-subtitle">Negotiating Penalty:</p>
                        <p class="item-description">
                            <?php echo $negotiation["penalty"] ?>
                        </p>

                        <p class="item-subtitle">Negotiating Cost</p>
                        <p class="item-description"><b>$
                            <?php echo $negotiation["cost"] ?>
                        </b></p>

                        <button class="item-footer item-footer-button" name="acceptButton" value="accept"><b>Accept</b></button>
                        <button class="item-footer item-footer-button red" name="rejectButton" value="reject"><b>Reject</b></button>
                        <a href="requests.php" class="item-footer item-footer-button blue"><b>Cancel</b></a>

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