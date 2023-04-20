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
        <link rel="stylesheet" href="../css/search.css">
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

    <?php
        require('../php/database.php');
        
        if (isset($_REQUEST['name']))
        {
            $name = stripslashes($_REQUEST['name']);
            $name = mysqli_real_escape_string($mysqli, $name);
        } else {
            $name = "NULL";
        }
        
        $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
        $result = mysqli_query($mysqli, "SELECT family_income FROM customer WHERE email = '$sanemail'");
        $temp = mysqli_fetch_array($result);
        $monthlyincome = $temp['family_income'] / 12;
        $result = mysqli_query($mysqli, "SELECT SUM(S.cost) FROM service AS S, hasservice AS H
        WHERE H.owner_email = '$sanemail' and H.service_name = S.name");
        $temp = mysqli_fetch_array($result);
        $maxprice = $monthlyincome - $temp['SUM(S.cost)'];
        $result = mysqli_query($mysqli, "SELECT SUM(O.cost) FROM outsideservice AS O
        WHERE O.customer_email = '$sanemail'");
        $temp = mysqli_fetch_array($result);
        $maxprice = $monthlyincome - $temp['SUM(O.cost)'];
        if (isset($_POST["afford"])){
            $afford = $_POST["afford"];
        } else {
            $afford = 'No';
        }
        if ($afford != 'Yes')
        {
            $stypequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE S.type='$name' AND P.email=S.provider";
            $snamequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE S.name='$name' AND P.email=S.provider";
            $typequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE P.type='$name' AND P.email=S.provider";
            $namequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE P.name='$name' AND P.email=S.provider";
        } else {
            $stypequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE type='$name' AND P.email=S.provider AND cost <= '$maxprice'";
            $snamequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE name='$name' AND P.email=S.provider AND cost <= '$maxprice'";
            $typequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE P.type='$name' AND P.email=S.provider AND S.cost <= '$maxprice'";
            $namequery = "SELECT S.name AS sname, P.name AS pname, P.email AS pemail, S.type, S.description, S.terms, S.cost FROM service AS S, provider AS P WHERE P.name='$name' AND P.email=S.provider AND S.cost <= '$maxprice'";
    
        }

        ?>

        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>

                <nav class="header-nav">

                    <a class="header-links" href="home.php">Dashboard</a>
                    <a class="header-links current-page" href="#">Services</a>
                    <a class="header-links" href="profile.php">Profile</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div>
                <h1 class="title">Search Services</h1>

                    <form class="form" method="post">
                        <div class="input">
                            <!-- <label class="input-header" for="name">Search:</label> -->
                            <input class="input-field" type="text" id="name" name="name">
                        </div>

                        <!-- <div class="input">
                            <label class="input-header" for="type">Provider Type:</label>
                            <input class="input-field" type="text" id="type" name="type">
                        </div>

                        <div class="input">
                            <label class="input-header" for="sname">Service Name:</label>
                            <input class="input-field" type="text" id="sname" name="sname">
                        </div>

                        <div class="input">
                            <label class="input-header" for="stype">Service Type:</label>
                            <input class="input-field" type="text" id="stype" name="stype">
                        </div> --> 

                       
                        <label class="input-header" for="afford">Filter By Affordability?</label>
                        <input class="input-checkbox" type="checkbox" name="afford" value="Yes" id="afford">               

                        <div class="submit-container">
                            <button class="submit-button" href="searchservices.php">Search</button>
                        </div>
                    </form>

                    <div class="user-information-container">

                        <div class="user-services">
                            
                            <h1 class="title">Results</h1>

                            <?php
                            require('../php/database.php');

                            if ($name != NULL)
                            {
                                $result = mysqli_query($mysqli, $stypequery);
                                while($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                    <form action="negotiate.php" method="post">
                                        <div class="service-detail recommended-service">
                                            <div class="service-title-container">
                                                <i class="service-title fa-solid fa-bolt"></i>
                                                <h3 class="service-title"><?php echo $row['sname'];?></h3>
                                                <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                            </div>
                                            <p class="service-description" name="provider">
                                                Provider Name: <?php echo $row['pname'];?>
                                                <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                            </p>
                                            <p class="service-description">
                                                Type: <?php echo $row['type'];?>
                                                <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                            </p>
                                            <br>
                                            <p class="service-description">
                                                Description: <?php echo $row['description'];?>
                                                <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                            </p>
                                            <br>
                                            <br>
                                            <p class="service-description">
                                                Terms: <?php echo $row['terms'];?>
                                                <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                            </p>
                                            <div class="submit-container">
                                                <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                                <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                                <button class="service-cost submit-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                            </div> 
                                            <a class="service-cost recommended-service-button" href="requestquote.php"><b>Request Quote</b></a>
                                        </div>
                                    </form>
                                    <?php
                                }
    
                            } 

                            if ($name != NULL)
                            {
                                $result = mysqli_query($mysqli, $snamequery);
                                while($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                    <form action="negotiate.php" method="post">
                                        <div class="service-detail recommended-service">
                                            <div class="service-title-container">
                                                <i class="service-title fa-solid fa-bolt"></i>
                                                <h3 class="service-title"><?php echo $row['sname'];?></h3>
                                                <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                            </div>
                                            <p class="service-description" name="provider">
                                                Provider Name: <?php echo $row['pname'];?>
                                                <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                            </p>
                                            <p class="service-description">
                                                Type: <?php echo $row['type'];?>
                                                <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                            </p>
                                            <br>
                                            <p class="service-description">
                                                Description: <?php echo $row['description'];?>
                                                <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                            </p>
                                            <br>
                                            <br>
                                            <p class="service-description">
                                                Terms: <?php echo $row['terms'];?>
                                                <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                            </p>
                                            <div class="submit-container">
                                                <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                                <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                                <button class="service-cost submit-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                            </div> 
                                            <a class="service-cost recommended-service-button" href="requestquote.php"><b>Request Quote</b></a>
                                        </div>
                                    </form>
                                    <?php
                                }
                            } 

                            if ($name != NULL)
                            {
                                $result = mysqli_query($mysqli, $namequery);
                                while($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                    <form action="negotiate.php" method="post">
                                        <div class="service-detail recommended-service">
                                            <div class="service-title-container">
                                                <i class="service-title fa-solid fa-bolt"></i>
                                                <h3 class="service-title"><?php echo $row['sname'];?></h3>
                                                <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                            </div>
                                            <p class="service-description" name="provider">
                                                Provider Name: <?php echo $row['pname'];?>
                                                <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                            </p>
                                            <p class="service-description">
                                                Type: <?php echo $row['type'];?>
                                                <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                            </p>
                                            <br>
                                            <p class="service-description">
                                                Description: <?php echo $row['description'];?>
                                                <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                            </p>
                                            <br>
                                            <br>
                                            <p class="service-description">
                                                Terms: <?php echo $row['terms'];?>
                                                <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                            </p>
                                            <div class="submit-container">
                                                <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                                <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                                <button class="service-cost submit-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                            </div> 
                                            <a class="service-cost recommended-service-button" href="requestquote.php"><b>Request Quote</b></a>
                                        </div>
                                    </form>
                                    <?php
                                }
    
                            }
                            if ($name != NULL)
                            {
                                $result = mysqli_query($mysqli, $typequery);
                                while($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                    <form action="negotiate.php" method="post">
                                        <div class="service-detail recommended-service">
                                            <div class="service-title-container">
                                                <i class="service-title fa-solid fa-bolt"></i>
                                                <h3 class="service-title"><?php echo $row['sname'];?></h3>
                                                <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                            </div>
                                            <p class="service-description" name="provider">
                                                Provider Name: <?php echo $row['pname'];?>
                                                <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                            </p>
                                            <p class="service-description">
                                                Type: <?php echo $row['type'];?>
                                                <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                            </p>
                                            <br>
                                            <p class="service-description">
                                                Description: <?php echo $row['description'];?>
                                                <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                            </p>
                                            <br>
                                            <br>
                                            <p class="service-description">
                                                Terms: <?php echo $row['terms'];?>
                                                <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                            </p>
                                            <div class="submit-container">
                                                <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                                <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                                <button class="service-cost submit-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                            </div> 
                                            <a class="service-cost recommended-service-button" href="requestquote.php"><b>Request Quote</b></a>
                                        </div>
                                    </form>
                                    <?php
                                }
    
                            }
                            ?>
                        
                            
                        </div>

                        <div class="home-information">
                            <br><br><br>
                            <h1 class="subtitle">Services Needed</h1>
                            <!-- <a href="#" class="service-cost recommended-service-button"><b>Calculate Needs</b><br></b></a><br>-->
                        
                            <?php
                            $sql = require __DIR__ . "/../php/service-calculator.php";
                            $sql = $sql . sprintf("AND c.email = '%s'", $mysqli->real_escape_string($_SESSION["email"]));
                            $client_result = $mysqli->query($sql);
                            while ($row = mysqli_fetch_array($client_result)){
                                ?>
                                <div class="service-detail recommended-service">
                                    <form action="negotiate.php" method="post">
                                        <div class="service-title-container">
                                            <i class="service-title fa-solid fa-bolt"></i>
                                            <h3 class="service-title"><?php echo $row['s_name'];?></h3>
                                            <input type="hidden" name="servicename" value="<?php echo $row['s_name'];?>">
                                            <input type="hidden" name="type" value="<?php echo $row['s_type'];?>">
                                        </div>
                                        <p class="service-description">
                                            Provided By: <?php echo $row['p_name'];?><br><br>
                                            <input type="hidden" name="providername" value="<?php echo $row['p_name'];?>">
                                        </p>
                                        <p class="service-description">
                                            Description: <?php echo $row['s_description'];?><br><br>
                                            <input type="hidden" name="desc" value="<?php echo $row['s_description'];?>">
                                        </p>
                                        <p class="service-description">
                                            Terms: <?php echo $row['s_terms'];?><br><br>
                                            <input type="hidden" name="terms" value="<?php echo $row['s_terms'];?>">
                                        </p>
                                        <input type="hidden" name="cost" value="<?php echo $row['s_cost'];?>">
                                        <input type="hidden" name="pemail" value="<?php echo $row['p_email'];?>">
                                        <button class="service-cost recommended-service-button"><b>$<?php echo $row['s_cost'];?></b> per Month</button>
                                    </form>
                                </div>
                                <?php
                            }
                        ?>

                        </div>
    
                    </div>
    
                </div>
    
                <div class="advertised-services">
                    

                    <h2 class="subtitle">Services Subscribed To</h2>
                    
                    <?php
                    require('../php/database.php');
                    $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
                    $result = mysqli_query($mysqli, "SELECT * FROM outsideservice WHERE customer_email='$sanemail'");
                    while($row = mysqli_fetch_array($result))
                    {
                    ?>

                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title"><?php echo $row['name'];?></h3>
                            </div>
                            <p class="service-description">
                                <?php echo $row['description'];?><br><br>
                                Type: <?php echo $row['type'];?><br><br>
                                Terms: <?php echo $row['terms'];?><br><br>
                                Address: <?php echo $row['address'];?>
                            </p>
                            <p class="service-cost"><b>$<?php echo $row['cost'];?></b> per Month</p>
                        </div>

                    <?php
                    }
                    ?>

                    <?php
                    require('../php/database.php');
                    $result = mysqli_query($mysqli, "SELECT service_name, description, terms, cost, address, type FROM hasservice, service WHERE owner_email='$sanemail' and service_name = name");
                    while($row = mysqli_fetch_array($result))
                    {
                    ?>

                        <div class="service-detail">
                            <div class="service-title-container">
                                <i class="service-title fa-solid fa-bolt"></i>
                                <h3 class="service-title"><?php echo $row['service_name'];?></h3>
                            </div>
                            <p class="service-description">
                                <?php echo $row['description'];?><br><br>
                                Type: <?php echo $row['type'];?><br><br>
                                Terms: <?php echo $row['terms'];?>
                                Address: <?php echo $row['address'];?>
                            </p>
                            <p class="service-cost"><b>$<?php echo $row['cost'];?></b> per Month</p>
                        </div>

                    <?php
                    }
                    ?>
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