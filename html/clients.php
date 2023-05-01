<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

$mysqli = require __DIR__ . "/../php/database.php";

// Client Table
$sql = sprintf("SELECT customer.name AS name, hasservice.address as address, hasservice.owner_email AS email, hasservice.service_name AS service, service.cost AS cost
                FROM customer, hasservice, service
                WHERE customer.email = hasservice.owner_email 
                AND hasservice.provider_email = service.provider 
                AND hasservice.service_name = service.name
                AND hasservice.provider_email = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));

$result = $mysqli->query($sql);


// Service Calculator
$sql = require __DIR__ . "/../php/service-calculator.php";

$sql = $sql . sprintf("AND s.provider = '%s'", $mysqli->real_escape_string($_SESSION["email"]));

$client_result = $mysqli->query($sql);


// Contract Dishonor Penalty
if (isset($_POST["customer_email"])) {

    $sql = "INSERT INTO customservice (name, cemail, address, type, cost, description, terms, penalty, provider)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die ("SQL Error: " . $mysqli->error);
    }

    $contract_penalty = "Contract Dishonor Penalty Fee";
    $contract_penalty_cemail = $mysqli->real_escape_string($_POST["customer_email"]);
    $contract_penalty_type = "Contract Penalty";
    $contract_penalty_cost = "50";
    $contract_penalty_description = "Contract dishonor penalty for " . $_POST["service"] . ". Payment will be taken from your next monthly payment.";
    $contract_penalty_terms = "Penalty fee for " . $_POST["service"] . ". Penalty Fee cost: "  . $contract_penalty_cost;
    $contract_penalty_penalty = "Failure to provide payment will terminate the service subscribed to.";
    $contract_penalty_pemail = $mysqli->real_escape_string($_SESSION["email"]);

    $stmt->bind_param("sssssssss", 
        $contract_penalty, 
        $contract_penalty_cemail, 
        $_POST["address"], 
        $contract_penalty_type, 
        $contract_penalty_cost, 
        $contract_penalty_description,
        $contract_penalty_terms,
        $contract_penalty_penalty,
        $contract_penalty_pemail
    );

    $stmt->execute();

    header("Location: #");

}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>MyHome Vendor - Clients</title>
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
                    <a class="header-links current-page" href="">Clients</a>
                    <a class="header-links" href="requests.php">Requests</a>

                </nav>
                
                
                <div class="header-cta">
                <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div class="container">

                <div class="center-content left-empty">

                    <h1 class="title">Clients</h1>

                    <table class="table">
                        <tr class=" table-head">
                            <th class="table-col-head">Contract <br> Dishonor</th>
                            <th class="table-col-head">Name</th>
                            <th class="table-col-head">Address</th>
                            <th class="table-col-head">Email</th>
                            <th class="table-col-head">Service</th>
                            <th class="table-col-head">Payments</th>
                        </tr>

                        <?php
                        while($client = $result->fetch_assoc()) {
                        ?>
                            <tr class="table-row">
                                <td class="table-col">
                                    <form method="post">
                                        <input type="hidden" id="customer_email" name="customer_email" value="<?php echo $client["email"] ?>">
                                        <input type="hidden" id="service" name="service" value="<?php echo $client["service"] ?>">
                                        <input type="hidden" id="address" name="address" value="<?php echo $client["address"] ?>">
                                        <button class="table-action">
                                            <i class="fa-solid fa-ban"></i>
                                            <p class="table-action-description">Contract Dishonor</p>
                                        </button>
                                    </form>
                                </td>
                                <td class="table-col" data-cell="name">
                                    <?php echo $client["name"] ?>
                                </td>
                                <td class="table-col" data-cell="address">
                                    <?php echo $client["address"] ?>
                                </td>
                                <td class="table-col" data-cell="email">
                                    <?php echo $client["email"] ?>
                                </td>
                                <td class="table-col" data-cell="service">
                                    <?php echo $client["service"] ?>
                                </td>
                                <td class="table-col" data-cell="cost">
                                    $<?php echo $client["cost"] ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                </div>

                <div class="right-content">
                    
                    <h1 class="title">Potential Clients</h1>

                    <?php
                    $i = 0;
                    while ( ($potential_client = $client_result->fetch_assoc()) && ($i < 25) ) {
                    ?>
                        <div class="item small-item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid fa-user"></i>
                                <h3 class="item-title">
                                    <?php echo $potential_client["c_name"] ?>
                                </h3>
                            </div>
                            <button class="item-footer item-footer-button" 
                                    id="popupButton" 
                                    data-name="<?php echo $potential_client["c_name"] ?>"
                                    data-email="<?php echo $potential_client["c_email"] ?>">
                                <b>Contact</b>
                            </button>
                        </div>

                    <?php
                    $i++;
                    }
                    ?>

                </div>

            </div>

            <div class="item highlighted-item popup" id="popup">

                <h3 class="item-title">Contact Information: </h3>
                <p class="item-subtitle">Name: </p>
                <p class="item-description" id="popupNameArea">Name</p>
                <p class="item-subtitle">Email: </p>
                <p class="item-description" id="popupEmailArea">Email</p>
                <button class="item-footer item-footer-button" id="closePopup"><b>Okay</b></button>

            </div>

            <script>
                const popupButtons = document.querySelectorAll("#popupButton");
                
                var popup = document.getElementById("popup");
                var popupNameArea = document.getElementById("popupNameArea");
                var popupEmailArea = document.getElementById("popupEmailArea");
                var closeButton = document.getElementById("closePopup");

                popupButtons.forEach(popupButton => {
                    var name = popupButton.dataset.name;
                    var email = popupButton.dataset.email;
                    popupButton.addEventListener("click", function() {
                        popup.style.display = "grid";
                        popupNameArea.textContent = name;
                        popupEmailArea.textContent = email;
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