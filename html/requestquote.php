<?php
include("../php/auth_session.php");
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>Request Quote</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/input-form.css"/>
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>
        <?php
        require('../php/database.php');
        
        // When form submitted, insert values into the database.
        if (isset($_REQUEST['cname']) && isset($_REQUEST['sname']) && isset($_REQUEST['pname'])) {
            // removes backslashes
            $email = ($_SESSION['email']);
            $address = stripslashes($_REQUEST['address']);
            //escapes special characters in a string
            $address = mysqli_real_escape_string($mysqli, $address);
            $cname = stripslashes($_REQUEST['cname']);
            $cname = mysqli_real_escape_string($mysqli, $cname);
            $sname = stripslashes($_REQUEST['sname']);
            $sname = mysqli_real_escape_string($mysqli, $sname);
            $pname = stripslashes($_REQUEST['pname']);
            $pname = mysqli_real_escape_string($mysqli, $pname);

                    // Varify Key is unique
            $sql = sprintf("SELECT *
            FROM quoterequest
            WHERE email = '$email' AND sname = '$sname' AND pname = '$pname'",
            $mysqli->real_escape_string($_POST["address"]));

            $result = $mysqli->query($sql);
            $user = $result->fetch_assoc();

            if ($user) {
                echo "<div class='form'>
                <h3>You already have an active request for this service. If you believe this to be an error, please contact support</h3><br/>
                <p class='link'>Click here to <a href='requestquote.php'>Try Again</a></p>
                </div>";
            }
            else
            {
                $query    = "INSERT into `quoterequest` (email, address, cname, pname, sname)
                            VALUES ('$email', '$address','$cname', '$pname', '$sname')";
                $result   = mysqli_query($mysqli, $query);
                if ($result) {
                    echo "<div class='form'>
                        <h3> Request made successfully.</h3><br/>
                        <p class='link'>Click here to return to <a href='searchservices.php'>Search</a></p>
                        </div>";
                } else {
                    echo "<div class='form'>
                        <h3>Required fields are missing.</h3><br/>
                        <p class='link'>Click here to <a href='requestquote.php'>Request Quote</a> again.</p>
                        </div>";
                }
            }
        } else {
        ?>


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
            
            <form class="form" action="requestquote.php" method="post">

                <h1 class="login-title">Request Quote</h1>

                <div class="input">
                    <label class="input-header" for="provider">Provider Name:</label>
                    <input class="input-field" type="text" id="pname" name="pname" required>
                </div>

                <div class="input">
                    <label class="input-header" for="service">Service Name:</label>
                    <input class="input-field" type="text" id="sname" name="sname" required>
                </div>

                <div class="input">
                    <label class="input-header" for="customer">Your Name:</label>
                    <input class="input-field" type="text" id="cname" name="cname" required>
                </div>

                <div class="input">
                    <label class="input-header" for="address">Address:</label>
                    <input class="input-field" type="text" id="address" name="address">
                </div>
                
                <div class="submit-container">
                    <button class="submit-button">Request Quote</button>
                </div>
                
            </form>

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
        <?php
        }
        ?>
    </body>

</html>