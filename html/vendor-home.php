<?php

session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ . "/../php/database.php";

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
        <link rel="stylesheet" href="../css/home.css">
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
                    <a class="header-links" href="#">Requests</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div class="user-information">

                <h1 class="title">Services</h1>
                
                <div class="user-information-container">

                    <!-- <div class="user-services"> -->
                        
                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title">Service Name</h3>
                            </div>
                            <p class="service-description">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae voluptatum optio sapiente minus non odio. Ducimus repellendus at temporibus aut.
                            </p>
                            <p class="service-cost"><b>$100</b> per Month</p>
                        </div>

                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title">Lorem Ipsum Dolor Sit</h3>
                            </div>
                            <p class="service-description">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae voluptatum optio sapiente minus non odio. Ducimus repellendus at temporibus aut.
                            </p>
                            <p class="service-cost"><b>$100</b> per Month</p>
                        </div>

                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title">Lorem</h3>
                            </div>
                            <p class="service-description">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae voluptatum optio sapiente minus non odio. Ducimus repellendus at temporibus aut.
                            </p>
                            <p class="service-cost"><b>$100</b> per Month</p>
                        </div>

                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title">Lorem Ipsum Dolor</h3>
                            </div>
                            <p class="service-description">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae voluptatum optio sapiente minus non odio. Ducimus repellendus at temporibus aut.
                            </p>
                            <p class="service-cost"><b>$100</b> per Month</p>
                        </div>

                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title">Lorem Ipsum Dolor Sit Amet Consectetur</h3>
                            </div>
                            <p class="service-description">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae voluptatum optio sapiente minus non odio. Ducimus repellendus at temporibus aut.
                            </p>
                            <p class="service-cost"><b>$100</b> per Month</p>
                        </div>
                        
                    <!-- </div> -->

                </div>

            </div>

            <div class="advertised-services">
                
                <h1 class="title">Register a Service</h1>

                <form class="form" method="post">
    
                    <div class="input">
                        <label class="input-header" for="name">Name of Service:</label>
                        <input class="input-field" type="text" id="name" name="name">
                    </div>
                    
                    <div class="input">
                        <label class="input-header" for="type">Type of Service:</label>
                        <input class="input-field" type="text" id="type" name="type">
                    </div>
    
                    <div class="input">
                        <label class="input-header" for="cost">Monthly Cost:</label>
                        <input class="input-field" type="text" id="cost" name="cost">
                    </div>
    
                    <div class="input">
                        <label class="input-header" for="description">Description:</label>
                        <input class="input-field" type="text" id="description" name="description">
                    </div>

                    <div class="input">
                        <label class="input-header" for="terms">Terms of Service:</label>
                        <input class="input-field" type="text" id="terms" name="terms">
                    </div>

                    <div class="input">
                        <label class="input-header" for="penalty">Penalty:</label>
                        <input class="input-field" type="text" id="penalty" name="penalty">
                    </div>
    
                    <div class="submit-container">
                        <button class="submit-button">Register Service</button>
                    </div>
    
                </form>

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