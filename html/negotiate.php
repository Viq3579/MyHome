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

        <title>Negotiate</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/home.css">
        <!-- <link rel="stylesheet" href="../css/input-form.css"/> -->
        <link rel="stylesheet" href="../css/adddhome.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/input-form.css"/>
    </head>


    <body>

        <?php
            require('../php/database.php');
            
            $servicename = $_POST["servicename"];
            $providername = $_POST["providername"];

            $terms = $_POST["terms"];
            $cost = $_POST["cost"];
            $description = $_POST["desc"];
            $type = $_POST["type"];


            if (isset($_POST["address"]))
            {
                $address = $_POST["address"];
                $address = mysqli_real_escape_string($mysqli, $address);
            }
            else {
                $address = "Not Specified";
            }

            $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
            $result = mysqli_query($mysqli, "SELECT name FROM customer WHERE email='$sanemail'");
            $displayname = mysqli_fetch_array($result);

            $result = mysqli_query($mysqli, "SELECT S.penalty FROM service AS S, provider AS P WHERE S.provider = P.email AND P.name = '$providername' AND S.name = '$servicename'");
            $penalty = mysqli_fetch_array($result);

            $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
            $pemail = $_POST['pemail'];


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

            <form class="form" action="sendnegotiate.php" method="post">
                <h1 class="login-title"><b>Negotiate</b></h1>
                <p><b>Service Name:</b> <?php echo $servicename?></p>
                <input type="hidden" name="servicename" value="<?php echo $servicename;?>">
                <input type="hidden" name="type" value="<?php echo $type;?>">
                <p><b>Service Provider:</b> <?php echo $providername?></p>
                <input type="hidden" name="pname" value="<?php echo $providername;?>">
                <p><b>Customer Name:</b> <?php echo $displayname[0]?></p>
                <p><b>Address:</b> <?php echo $address?></p>
                <input type="hidden" name="setaddress" value="<?php echo $address;?>">
                <h1 class="login-title">Current Offer:</h1>
                <p><b>Price:</b> $<?php echo $cost?> per month</p>
                <input type="hidden" name="setcost" value="<?php echo $cost;?>">
                <input type="hidden" name="description" value="<?php echo $description;?>">
                <p><b>Terms:</b> <?php echo $terms?></p>
                <input type="hidden" name="setterms" value="<?php echo $terms;?>">
                <input type="hidden" name="pemail" value="<?php echo $pemail;?>">
                <p><b>Penalty:</b> <?php echo $penalty[0]?></p>
                <input type="hidden" name="setpenalty" value="<?php echo $penalty[0];?>">
                <label class="input-header" for="afford"><b>Accept Current Offer?  </b></label>
                <input class="input-checkbox" type="checkbox" name="accept" value="Yes" id="afford"> 
                <h1 class="login-title">--------------OR--------------</h1><br>
                <h1 class="login-title">Response:</h1>
                <input type="number" class="login-input" name="newcost" placeholder="Price"/>
                <input type="text" class="login-input" name="address" placeholder="For Address:"/>
                <textarea rows="4" cols="40" name="newterms" placeholder="Service Terms"></textarea>
                <br>
                <br>
                <textarea rows="4" cols="40" name="newpenalty" placeholder="Service Penalty"></textarea>
                <br>
                <br>
                <button class="login-button">Submit</button>
                <br><br>
                <a class="login-button" href="home.php">Return to Dashboard</a>
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

    </body>

</html>