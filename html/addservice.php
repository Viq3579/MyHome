<?php
//this page is for customers adding outside services to their profile, so that we can use those services to determine the customer's needs
session_start();

$_SESSION;

if ( !isset($_SESSION["email"]) ) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mysqli = require __DIR__ . "/../php/database.php";

    $name = stripslashes($_POST["name"]);
    //escapes special characters in a string
    $name = mysqli_real_escape_string($mysqli, $name);
    $provider = stripslashes($_POST["provider"]);
    $provider = mysqli_real_escape_string($mysqli, $provider);
    $email = $_SESSION["email"];
    $address = $_POST["address"];
    $cost = $_POST["cost"];
    $type = $_POST["type"];
    $desc = $_POST["description"]; 
    $terms = $_POST["terms"];
    $penalty = $_POST["penalty"];
    
    $query = "SELECT email FROM provider WHERE name = '$provider'";
    $result = mysqli_query($mysqli, $query);
    $temp = mysqli_fetch_array($result);
    if ($temp){
        $pemail = $temp[0];

    } else {
        $pemail = "Not Applicable";
    }
    //$pemail = $temp[0];

    $query = "SELECT name FROM service WHERE provider = '$pemail' AND name = '$name'";
    $result = mysqli_query($mysqli, $query);
    $temp = mysqli_fetch_array($result);
    //$wtf = $temp[0];
    if ($temp[0]) {
        $query = "SELECT * FROM service WHERE provider = '$pemail' AND name = '$name' AND cost = '$cost' AND type = '$type' AND description = '$desc' AND penalty = '$penalty'";
        $result = mysqli_query($mysqli, $query);
        if ($result) {
            $custom = 0;
        } else {
            $custom = 1;
        }
        $sql2 = "INSERT INTO unverifiedservice (name, provider, type, cemail, cost, description, terms, penalty, address, custom)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, $custom)";
        $stmt = $mysqli->stmt_init();
        
        if (!$stmt->prepare($sql2)) {
            die ("SQL Error: " . $mysqli->error);
        }
    } else {
        $sql3 = "INSERT INTO outsideservice (name, provider, type, customer_email, cost, description, terms, penalty, address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->stmt_init();
            
        if (!$stmt->prepare($sql3)) {
            die ("SQL Error: " . $mysqli->error);
        }
    }




    // Varify Name is Unique
    $sql = sprintf("SELECT *
    FROM outsideservice
    WHERE name = '$name' AND provider = '$provider' AND customer_email = '$email' AND address = '$address'",
    $mysqli->real_escape_string($_POST["name"]));

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        die("Key Already Taken");
    }
    else
    {
        if ($_POST["ownerorhome"] == 'Owner') {
            $address = "NOT APPLICABLE";
            $stmt->bind_param("sssssssss", 
            $name,
            $provider,
            $_POST["type"], 
            $_SESSION["email"], 
            $_POST["cost"], 
            $_POST["description"], 
            $_POST["terms"], 
            $_POST["penalty"],
            $address
            );
        } else if ($_POST["ownerorhome"] == 'Home') {
            $stmt->bind_param("sssssssss", 
            $name,
            $provider, 
            $_POST["type"], 
            $_SESSION["email"], 
            $_POST["cost"], 
            $_POST["description"], 
            $_POST["terms"], 
            $_POST["penalty"],
            $_POST["address"]
            );
        }


        $stmt->execute();
        header("Location: ../html/profile.php");
    }
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
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/input-form.css">
        <link rel="stylesheet" href="../css/footer.css">

    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>

                <nav class="header-nav">

                    <a class="header-links" href="home.php">Dashboard</a>
                    <a class="header-links" href="searchservices.php">Services</a>
                    <a class="header-links" href="profile.php">Profile</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>

            </div>

        </header>


        <main class="main-content" style="display: flex; flex-direction: column; align-items: center;">

            <div class="container">

                <div class="center-content">

                    <form class="item important-item clear" action="" method="post">

                        <h1 class="login-title">Add Outside Service</h1>
                        <p> Email: <?php echo $_SESSION['email']?></p>

                        <div class="input">
                            <label class="input-header" for="owner">Owner Service:</label>
                            <input class="input-field white" type="radio" value="Owner" id="owner" name="ownerorhome" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="home">Home Service:</label>
                            <input class="input-field white" type="radio" value="Home" id="home" name="ownerorhome" required>
                        </div>
                        
                        <div class="input">
                            <label class="input-header" for="name">Name of Service:</label>
                            <input class="input-field white" type="text" id="name" name="name">
                        </div>

                        <div class="input">
                            <label class="input-header" for="name">Provider:</label>
                            <input class="input-field white" type="text" id="name" name="provider">
                        </div>
                        
                        <div class="input">
                            <label class="input-header" for="type">Type of Service:</label>
                            <input class="input-field white" type="text" id="type" name="type">
                        </div>

                        <div class="input">
                            <label class="input-header" for="cost">Monthly Cost:</label>
                            <input class="input-field white" type="text" id="cost" name="cost">
                        </div>

                        <div class="input">
                            <label class="input-header" for="description">Description:</label>
                            <input class="input-field white" type="text" id="description" name="description">
                        </div>

                        <div class="input">
                            <label class="input-header" for="terms">Terms of Service:</label>
                            <input class="input-field white" type="text" id="terms" name="terms">
                        </div>

                        <div class="input">
                            <label class="input-header" for="penalty">Penalty:</label>
                            <input class="input-field white" type="text" id="penalty" name="penalty">
                        </div>

                        <div class="input">
                            <label class="input-header" for="address">Address:</label>
                            <input class="input-field white" type="text" id="address" name="address">
                        </div>

                        <div class="submit-container">
                            <button class="submit-button">Add Outside Service</button>
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
