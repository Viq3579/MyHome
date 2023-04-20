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
                            <th class="table-col-head">Name</th>
                            <th class="table-col-head">Address</th>
                            <th class="table-col-head">Email</th>
                            <th class="table-col-head">Service</th>
                            <th class="table-col-head">Payments</th>
                            <th class="table-col-head">Actions</th>
                        </tr>

                        <?php
                        while($client = $result->fetch_assoc()) {
                            echo "<tr class=\"table-row\">";
                            echo    "<th class=\"table-col\">" . $client["name"] . "</th>";
                            echo    "<th class=\"table-col\">" . $client["address"] . "</th>";
                            echo    "<th class=\"table-col\">" . $client["email"] . "</th>";
                            echo    "<th class=\"table-col\">" . $client["service"] . "</th>";
                            echo    "<th class=\"table-col\">$" . $client["cost"] . "</th>";
                            echo    "<th class=\"table-col\">Negotiate</th>";
                            echo "</tr>";
                        }
                        ?>
                    </table>

                </div>

                <div class="right-content">
                    
                    <h1 class="title">Potential Clients</h1>

                    <?php
                    $i = 0;
                    while ( ($potential_client = $client_result->fetch_assoc()) && ($i < 25) ) {

                        echo "<div class=\"item highlighted-item\">";
                        echo    "<div class=\"item-title-container\">";
                        echo        "<i class=\"item-title fa-solid fa-user\"></i>";
                        echo        "<h3 class=\"item-title\">" . $potential_client["c_name"] . "</h3>";
                        echo    "</div>";
                        echo    "<button class=\"item-footer item-footer-button\"><b>Contact</b></button>";
                        echo "</div>";

                        $i++;
                    }
                    ?>

                </div>

            </div>

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