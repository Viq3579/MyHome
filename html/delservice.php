<?php
//this page is for customers manually deleting outside services that they no longer have
session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ . "/../php/database.php";

    $sql = "DELETE FROM outsideservice WHERE ((name=? and customer_email=?) and (address=? or address is NULL))";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        die ("SQL Error: " . $mysqli->error);
    }


    $stmt->bind_param("sss", 
    $_POST["name"],
    $_SESSION['email'],
    $_POST["address"]
    );



    $stmt->execute();
    header("Location: ../html/profile.php");
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>Edit Profile</title>
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

                    <a class="header-links" href="home.php">Dashboard</a>
                    <a class="header-links" href="searchservices.html">Services</a>
                    <a class="header-links" href="profile.php">Profile</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>

            </div>

        </header>
        <main class="main-content" style="display: flex; flex-direction: column; align-items: center;">

        <form class="form" action="" method="post">

            <h1 class="login-title">Delete Outside Service</h1>
            <p> Email: <?php echo $_SESSION['email']?></p>

            <div class="input">
                <label class="input-header" for="name">Name of Service:</label>
                <input class="input-field" type="text" id="name" name="name">
            </div>

            <div class="input">
                <label class="input-header" for="address">Address:</label>
                <input class="input-field" type="text" id="address" name="address" default=NULL>
            </div>

            <div class="submit-container">
                <button class="submit-button">Delete</button>
            </div>

        </form>

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
