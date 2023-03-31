<?php
include("../php/auth_session.php");
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
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>

                <nav class="header-nav">

                    <a class="header-links" href="home.php">Dashboard</a>
                    <a class="header-links" href="searchservices.php">Services</a>
                    <a class="header-links current-page" href="#">Profile</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div class="user-information">

                <h1 class="title">Profile:</h1>
                
                <div class="user-information-container">

                    <div class="user-services">
                        
                        <h2 class="subtitle">Personal Details</h2>
                        
                        <?php
                        require('../php/database.php');
                        $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
                        $result = mysqli_query($mysqli, "SELECT * FROM customer WHERE email='$sanemail'");
                        while($row = mysqli_fetch_array($result))
                        {
                            ?>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-envelope"></i>
                                    <p class="house-description"><?php echo $row['email'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-phone"></i>
                                    <p class="house-description"><?php echo $row['phone_num'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-car"></i>
                                    <p class="house-description"><?php echo $row['num_cars'];?> Cars</p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-bank"></i>
                                    <p class="house-description">Annual Income: $ <?php echo $row['family_income'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-balance-scale"></i>
                                    <p class="house-description">Non-Service Expenses: $<?php echo $row['misc_expenses'];?></p>
                                </div>
                            <?php
                        }
                    ?>
                    </div>
                    
                    <div class="home-information">
                        
                        <h2 class="subtitle">Your Home Information</h2>
                        
                        <?php
                        require('../php/database.php');
                        $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
                        $result = mysqli_query($mysqli, "SELECT * FROM home WHERE owner_email='$sanemail'");
                        while($row = mysqli_fetch_array($result))
                        {
                            ?>
                                <img class="house-image" height="200px" src="https://cdn.houseplansservices.com/product/dt0biqq4ga38s7rdm8tjnbglkp/w800x533.jpg?v=2" alt="A Picture of Your House.">
                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-location-dot"></i>
                                    <p class="house-description"><?php echo $row['address'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-bed"></i>
                                    <p class="house-description"><?php echo $row['bedrooms'];?> Bedrooms</p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-shower"></i>
                                    <p class="house-description"><?php echo $row['bathrooms'];?> Bathrooms</p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Construction Type: <?php echo $row['construction_type'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Cooling Type: <?php echo $row['cooling_type'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Floor Space: <?php echo $row['floor_space'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Foundation Type: <?php echo $row['foundation'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Garage Size: <?php echo $row['garage_size'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Heating Time: <?php echo $row['heating_time'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Heating Type: <?php echo $row['heating_type'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Lot Size: <?php echo $row['lot_size'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Number of Floors: <?php echo $row['num_floors'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Property Type: <?php echo $row['property_type'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Roof Style: <?php echo $row['roof'];?></p>
                                </div>

                                <div class="house-detail">
                                    <i class="house-description fa-solid fa-square"></i>
                                    <p class="house-description">Year Built: <?php echo $row['year_built'];?></p>
                                </div>
                                <a href="edithome.php" class="service-cost recommended-service-button"><b>Edit Property Details</b></a>
                                <br>
                            <?php
                        }
                    ?>

                        
                    </div>

                </div>

            </div>

            <div class="advertised-services">
                
                <h1 class="title">Actions</h1>

                <a href="addhome.php" class="service-cost recommended-service-button"><b>Add Home</b></a>
                <br>
                <a href="addservice.php" class="service-cost recommended-service-button"><b>Add Outside Service</b></a>
                <br>
                <a href="delservice.php" class="service-cost recommended-service-button"><b>Delete Outside Service</b></a>
                <br>
                <a href="changeprofile.php" class="service-cost recommended-service-button"><b>Edit Personal Details</b></a>
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