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

        <title>MyHome - Edit Home</title>
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


        <?php
        require('../php/database.php');
        
        // When form submitted, insert values into the database.
        if (isset($_REQUEST['address'])) {
            // removes backslashes
            $email = ($_SESSION['email']);
            $address = stripslashes($_REQUEST['address']);
            //escapes special characters in a string
            $address = mysqli_real_escape_string($mysqli, $address);
            $year_built = stripslashes($_REQUEST['year_built']);
            $year_built = mysqli_real_escape_string($mysqli, $year_built);
            $lot_size = stripslashes($_REQUEST['lot_size']);
            $lot_size = mysqli_real_escape_string($mysqli, $lot_size);
            $contype = stripslashes($_REQUEST['contype']);
            $contype = mysqli_real_escape_string($mysqli, $contype);
            $garage = stripslashes($_REQUEST['garage']);
            $garage = mysqli_real_escape_string($mysqli, $garage);
            $floors = stripslashes($_REQUEST['floors']);
            $floors = mysqli_real_escape_string($mysqli, $floors);
            $cooltype = stripslashes($_REQUEST['cooltype']);
            $cooltype = mysqli_real_escape_string($mysqli, $cooltype);
            $floorspace = stripslashes($_REQUEST['floorspace']);
            $floorspace = mysqli_real_escape_string($mysqli, $floorspace);
            $bathrooms = stripslashes($_REQUEST['bathrooms']);
            $bathrooms = mysqli_real_escape_string($mysqli, $bathrooms);
            $heattype = stripslashes($_REQUEST['heattype']);
            $heattype = mysqli_real_escape_string($mysqli, $heattype);
            $bedrooms = stripslashes($_REQUEST['bedrooms']);
            $bedrooms = mysqli_real_escape_string($mysqli, $bedrooms);
            $proptype = stripslashes($_REQUEST['proptype']);
            $proptype = mysqli_real_escape_string($mysqli, $proptype);
            $rooftype = stripslashes($_REQUEST['rooftype']);
            $rooftype = mysqli_real_escape_string($mysqli, $rooftype);
            $foundation = stripslashes($_REQUEST['foundation']);
            $foundation = mysqli_real_escape_string($mysqli, $foundation);

                    // Varify Address is Unique
            $sql = sprintf("SELECT *
            FROM home
            WHERE address = '$address'",
            $mysqli->real_escape_string($_POST["address"]));

            $result = $mysqli->query($sql);
            $user = $result->fetch_assoc();

            if ($user) {
                $query    = "UPDATE home SET lot_size = '$lot_size', cooling_type = '$cooltype', construction_type = '$contype', garage_size = '$garage', year_built = '$year_built', property_type = '$proptype', heating_type = '$heattype', num_floors = '$floors', floor_space = '$floorspace', roof = '$rooftype', bathrooms = '$bathrooms', bedrooms = '$bedrooms', foundation = '$foundation' WHERE address = '$address';";
                $result   = mysqli_query($mysqli, $query);
                if ($result) {
                ?>
                    <main class="main-content">
                        <div class="container">
                            <div class="center-content">
                                <div class="item important-item clear">
                                    <h3 class="subtitle">Edited successfully.</h3>
                                    <a class="submit-button" style="justify-self: center;" href="profile.php">Okay</a>
                                </div>
                            </div>
                        </div>
                    </main>
                <?php
                } else {
                ?>
                    <main class="main-content">
                        <div class="container">
                            <div class="center-content">
                                <div class="item important-item clear">
                                    <h3 class="subtitle">Required fields are missing.</h3>
                                    <a class="submit-button" style="justify-self: center;" href="edithome.php">Try Again</a>
                                </div>
                            </div>
                        </div>
                    </main>
                <?php
                }
            } else {
            ?>
                <main class="main-content">
                        <div class="container">
                            <div class="center-content">
                                <div class="item important-item clear">
                                    <h3 class="subtitle">We find no record of that address for your account.</h3>
                                    <a class="submit-button" style="justify-self: center;" href="edithome.php">Try Again</a>
                                </div>
                            </div>
                        </div>
                    </main>
            <?php
            }
        } else {
        ?>

        <main class="main-content" style="display: flex; flex-direction: column; align-items: center;">

            <div class="container">

                <div class="center-content">
    
                    <form class="item important-item clear" action="" method="post">

                        <h1 class="login-title">Add Home</h1>

                        <div class="input">
                            <label class="input-header" for="address">Address:</label>
                            <input class="input-field white" type="text" id="address" name="address" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="year_built">Year Built:</label>
                            <input class="input-field white" type="text" id="year_built" name="year_built" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="lot_size">Lot Size (square feet):</label>
                            <input class="input-field white" type="number" id="lot_size" name="lot_size" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="contype">Construction Type:</label>
                            <input class="input-field white" type="text" id="contype" name="contype" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="garage">Garage Size:</label>
                            <input class="input-field white" type="number" id="garage" name="garage" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="floors">Floors:</label>
                            <input class="input-field white" type="number" id="floors" name="floors" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="cooltype">Cooling Type:</label>
                            <input class="input-field white" type="text" id="cooltype" name="cooltype" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="floorspace">Floor Space (square feet):</label>
                            <input class="input-field white" type="number" id="floorspace" name="floorspace" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="bathrooms">Bathrooms:</label>
                            <input class="input-field white" type="number" id="bathrooms" name="bathrooms" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="heattype">Heating Type:</label>
                            <input class="input-field white" type="text" id="heattype" name="heattype" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="bedrooms">Bedrooms:</label>
                            <input class="input-field white" type="number" id="bedrooms" name="bedrooms" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="proptype">Property Type:</label>
                            <input class="input-field white" type="text" id="proptype" name="proptype" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="rooftype">Roof Design:</label>
                            <input class="input-field white" type="text" id="rooftype" name="rooftype" required>
                        </div>

                        <div class="input">
                            <label class="input-header" for="foundation">Foundation Type:</label>
                            <input class="input-field white" type="text" id="foundation" name="foundation" required>
                        </div>

                        <div class="submit-container">
                            <button class="submit-button">Update Account</button>
                        </div>

                    </form>

                </div>

            </div>

        </main>

        <?php
        }
        ?>

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
