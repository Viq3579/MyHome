<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

include("../php/service_icon.php");

$mysqli = require __DIR__ . "/../php/database.php";


// Gets all of the Vendor's Services
$sql = sprintf("SELECT name, description, cost, type
                FROM service
                WHERE provider = '%s'",
                $mysqli->real_escape_string($_SESSION["email"]));

$result = $mysqli->query($sql);



// Adds a new Service
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $sql = "INSERT INTO service (name, type, provider, cost, description, terms, penalty)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die ("SQL Error: " . $mysqli->error);
    }

    $stmt->bind_param("sssssss", 
        $_POST["name"], 
        $_POST["type"], 
        $_SESSION["email"], 
        $_POST["cost"], 
        $_POST["description"], 
        $_POST["terms"], 
        $_POST["penalty"]
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

        <title>MyHome Vendor - Services</title>
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

                    <a class="header-links current-page" href="">Services</a>
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

                <div class="center-content left-empty">
                    
                    <h1 class="title">Services</h1>
                        
                    <?php
                    while($service = $result->fetch_assoc()) {
                    ?>
                        <div class="item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid <?php service_icon($service["type"]) ?>"></i>
                                <h3 class="item-title">
                                    <?php echo $service["name"] ?>
                                </h3>
                            </div>
                            <p class="item-description">
                                <?php echo $service["description"] ?>
                            </p>
                            <p class="item-footer">
                                <b>$<?php echo $service["cost"] ?></b> per Month
                            </p>
                        </div>
                    <?php
                    }
                    ?>

                </div>

                <div class="right-content">

                    <h1 class="title">Register a Service</h1>

                    <form class="form" method="post">
        
                        <div class="input">
                            <label class="input-header" for="name">Name of Service:</label>
                            <input class="input-field" type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="input">
                            <label class="input-header" for="type">Type of Service:</label>
                            <select class="dropdown" name="type" id="type">
                                <option class="dropdown-option" value="Cellular">Cellular</option>
                                <option class="dropdown-option" value="Internet">Internet</option>
                                <option class="dropdown-option" value="Cable">Cable</option>
                                <option class="dropdown-option" value="Water Supply">Water Supply</option>
                                <option class="dropdown-option" value="Sewage">Sewage</option>
                                <option class="dropdown-option" value="Gas">Gas</option>
                                <option class="dropdown-option" value="Electricity">Electricity</option>
                                <option class="dropdown-option" value="Home Cleaning">Home Cleaning</option>
                                <option class="dropdown-option" value="Lawncare">Lawncare</option>
                                <option class="dropdown-option" value="Babysitting">Babysitting</option>
                                <option class="dropdown-option" value="Elderly Care">Elderly Care</option>
                                <option class="dropdown-option" value="Transport">Transport</option>
                                <option class="dropdown-option" value="Mortgage">Mortgage</option>
                                <option class="dropdown-option" value="Home Insurance">Home Insurance</option>
                                <option class="dropdown-option" value="Life Insurance">Life Insurance</option>
                                <option class="dropdown-option" value="Health Insurance">Health Insurance</option>
                                <option class="dropdown-option" value="Car Insurance">Car Insurance</option>
                                <option class="dropdown-option" value="Device Insurance">Device Insurance</option>
                                <option class="dropdown-option" value="Security">Security</option>
                            </select>
                        </div>
        
                        <div class="input">
                            <label class="input-header" for="cost">Monthly Cost:</label>
                            <input class="input-field" type="text" id="cost" name="cost" required>
                        </div>
        
                        <div class="input">
                            <label class="input-header" for="description">Description:</label>
                            <input class="input-field" type="text" id="description" name="description" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="terms">Terms of Service:</label>
                            <input class="input-field" type="text" id="terms" name="terms" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="penalty">Penalty:</label>
                            <input class="input-field" type="text" id="penalty" name="penalty" required>
                        </div>
        
                        <div class="submit-container">
                            <button class="submit-button">Register Service</button>
                        </div>
        
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