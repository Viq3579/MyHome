<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

$mysqli = require __DIR__ . "/../php/database.php";

// Gets the Information
$service_name = $mysqli->real_escape_string($_GET["name"]);
$customer_email = $mysqli->real_escape_string($_GET["cemail"]);
$address = $mysqli->real_escape_string($_GET["address"]);
$cost = $mysqli->real_escape_string($_GET["cost"]);
$provider_name = $mysqli->real_escape_string($_GET["provider"]);
$custom = $mysqli->real_escape_string($_GET["custom"]);

$sql = "SELECT c.name as name, 
            u.name as service, 
            u.address as address, 
            u.type as type, 
            u.cost as cost, 
            u.description as description, 
            u.terms as terms,
            u.penalty as penalty,
            u.provider as provider,
            u.custom as custom
        FROM unverifiedservice as u, customer as c, provider as p
        WHERE u.cemail = c.email
        AND u.provider = p.name
        AND u.name = '$service_name'
        AND u.cemail = '$customer_email'
        AND u.address = '$address'
        AND u.cost = '$cost'
        AND u.provider = '$provider_name'
        and u.custom = '$custom'";

$result = $mysqli->query($sql);
$service_info = $result->fetch_assoc();

if (isset($_POST["acceptButton"])) {

    // Finds out if Service is Custom
    $sql = sprintf("SELECT name
                    FROM service
                    WHERE name = '%s'
                    AND provider = '%s'
                    AND cost = '%s'
                    AND terms = '%s'
                    AND penalty = '%s'",
                    $service_name,
                    $_SESSION["email"],
                    $cost,
                    $service_info["terms"],
                    $service_info["penalty"]);

    $result = $mysqli->query($sql);
    $is_service = $result->fetch_assoc();

    // Adds service to 'hasservice' table or 'customservice' table
    if (isset($is_service["name"])) {

        // Adds service to 'hasservice' table
        $sql = "INSERT INTO hasservice (owner_email, service_name, provider_email, address, custom)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die ("SQL Error: " . $mysqli->error);
        }

        $stmt->bind_param("sssss", 
            $customer_email,
            $service_name,
            $mysqli->real_escape_string($_SESSION["email"]),
            $address,
            $custom
        );

        $stmt->execute();

    } else {

        // Adds service to 'customservice' table
        $sql = "INSERT INTO customservice (name, cemail, address, type, cost, description, terms, penalty, provider)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die ("SQL Error: " . $mysqli->error);
        }

        $stmt->bind_param("sssssssss", 
            $service_name,
            $customer_email,
            $address,
            $service_info["type"],
            $cost,
            $service_info["cost"],
            $service_info["description"],
            $service_info["penalty"],
            $mysqli->real_escape_string($_SESSION["email"])
        );

        $stmt->execute();

    }


    // Deletes entry in 'unverifiedservice' table
    $sql = "DELETE FROM unverifiedservice
            WHERE name = '$service_name'
            AND cemail = '$customer_email'
            AND address = '$address'
            AND cost = '$cost'
            AND provider = '$provider_name'
            and custom = '$custom'";

    $result = $mysqli->query($sql);

    header("Location: requests.php");

} else if (isset($_POST["rejectButton"])) {

    // Deletes entry in 'unverifiedservice' table
    $sql = "DELETE FROM unverifiedservice
            WHERE name = '$service_name'
            AND cemail = '$customer_email'
            AND address = '$address'
            AND cost = '$cost'
            AND provider = '$provider_name'
            and custom = '$custom'";

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

        <title>MyHome Vendor - Request Review</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/input-form.css">
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
                        <?php echo $service_info["name"] ?>'s Request
                    </h1>

                    <form class="item important-item clear" method="post">
                        
                        <p class="item-subtitle">Customer's Address:</p>
                        <p class="item-description">
                            <?php echo $service_info["address"] ?>
                        </p>

                        <p class="item-subtitle">Service Name:</p>
                        <p class="item-description">
                            <?php echo $service_info["service"] ?>
                        </p>

                        <p class="item-subtitle">Review Description:</p>
                        <p class="item-description">
                            <?php echo $service_info["description"] ?>
                        </p>

                        <p class="item-subtitle">Review Terms:</p>
                        <p class="item-description">
                            <?php echo $service_info["terms"] ?>
                        </p>

                        <p class="item-subtitle">Review Penalty:</p>
                        <p class="item-description">
                            <?php echo $service_info["penalty"] ?>
                        </p>

                        <p class="item-subtitle">Subscribed Cost:</p>
                        <p class="item-description"><b>$
                            <?php echo $service_info["cost"] ?>
                        </b></p>

                        <div class="input">
                            <label class="input-header" for="provider_signature">Signature:</label>
                            <input class="input-field white" type="text" id="provider_signature" name="provider_signature" required>
                        </div>

                        <button class="item-footer item-footer-button" style="margin-bottom: 2rem;" name="acceptButton" value="accept"><b>Sign</b></button>
                        <button class="item-footer item-footer-button red" name="rejectButton" value="reject"><b>Reject</b></button>
                        <a class="item-footer item-footer-button blue" href="requests.php"><b>Cancel</b></a>

                    </form>

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