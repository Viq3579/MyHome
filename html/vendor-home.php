<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

$mysqli = require __DIR__ . "/../php/database.php";


// Gets all of the Vendor's Services
$sql = sprintf("SELECT name, description, cost
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

        <title>MyHome</title>
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
                        echo "<div class=\"item\">";
                        echo    "<div class=\"item-title-container\">";
                        echo        "<i class=\"item-title fa-solid fa-bolt\"></i>";
                        echo        "<h3 class=\"item-title\">" . $service["name"] . "</h3>";
                        echo    "</div>";
                        echo    "<p class=\"item-description\">";
                        echo        $service["description"];
                        echo    "</p>";
                        echo    "<p class=\"item-footer\"><b>$" . $service["cost"] . "</b> per Month</p>";
                        echo "</div>";
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
                                <option class="dropdown-option" value="Electricity">Electricity</option>
                                <option class="dropdown-option" value="Security">Security</option>
                                <option class="dropdown-option" value="Internet">Internet</option>
                                <option class="dropdown-option" value="Insurance">Home Insurance</option>
                                <option class="dropdown-option" value="Insurance">Car Insurance</option>
                                <option class="dropdown-option" value="Insurance">Transport</option>
                                <option class="dropdown-option" value="Cable">Cable</option>
                                <option class="dropdown-option" value="Cellular">Cellular</option>
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