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

            $result = mysqli_query($mysqli, "SELECT penalty FROM service AS S, provider AS P WHERE S.provider = P.email AND P.name = '$providername' AND S.name = '$servicename'");
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
                <p><b>Service Provider:</b> <?php echo $providername?></p>
                <p><b>Customer Name:</b> <?php echo $displayname[0]?></p>
                <p><b>Address:</b> <?php echo $address?></p>
                <input type="hidden" name="setaddress" value="<?php echo $address;?>">
                <h1 class="login-title">Current Offer:</h1>
                <p><b>Price:</b> $<?php echo $cost?> per month</p>
                <input type="hidden" name="setcost" value="<?php echo $cost;?>">
                <p><b>Terms:</b> <?php echo $terms?></p>
                <input type="hidden" name="setterms" value="<?php echo $terms;?>">
                <input type="hidden" name="pemail" value="<?php echo $pemail;?>">
                <p><b>Penalty:</b> <?php echo $penalty[0]?></p>
                <input type="hidden" name="setpenalty" value="<?php echo $penalty[0];?>">
                <h1 class="login-title">Response:</h1>
                <input type="number" class="login-input" name="price" placeholder="Price" required />
                <input type="text" class="login-input" name="address" placeholder="For Address:" required />
                <textarea rows="4" cols="40" name="newterms" placeholder="Service Terms" required></textarea>
                <br>
                <br>
                <textarea rows="4" cols="40" name="newpenalty" placeholder="Service Penalty" required></textarea>
                <br>
                <br>
                <a class="login-button" href="paymentpage.html">Accept Current Offer</a>
                <br><br>
                <button class="login-button" href="sendnegotiate.php">Send Counter-Offer</button>
                <br><br>
                <a class="login-button" href="home.php">Return to Dashboard</a>
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