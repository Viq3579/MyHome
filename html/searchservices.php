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
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/input-form.css">
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


            <div class="container">

                <div class="center-content">

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

                        <div class="input inline-input">
                            <input class="input-checkbox" type="checkbox" name="afford" value="Yes" id="afford">
                            <label class="input-header" for="afford">Filter By Affordability?</label>
                        </div>
                        <div class="submit-container">
                            <button class="submit-button" href="searchservices.php">Search</button>
                        </div>
                    </form>

                    <h1 class="subtitle">Results</h1>

                    <?php
                    require('../php/database.php');

                    if ($name != NULL)
                    {
                        $result = mysqli_query($mysqli, $stypequery);
                        while($row = mysqli_fetch_array($result))
                        {
                        ?>
                            <form class="item highlighted-item" action="negotiate.php" target="_blank" method="post">
                                <div class="item-title-container">
                                    <i class="item-title fa-solid fa-bolt"></i>
                                    <h3 class="item-title"><?php echo $row['sname'];?></h3>
                                    <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                </div>
                                
                                <p class="item-subtitle">Provider Name: </p>
                                <p class="item-description" name="provider">
                                    <?php echo $row['pname'];?>
                                    <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                </p>

                                <p class="item-subtitle">Type: </p>
                                <p class="item-description">
                                    <?php echo $row['type'];?>
                                    <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                </p>

                                <p class="item-subtitle">Description: </p>
                                <p class="item-description">
                                    <?php echo $row['description'];?>
                                    <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                </p>

                                <p class="item-subtitle">Terms: </p>
                                <p class="item-description">
                                    <?php echo $row['terms'];?>
                                    <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                </p>

                                <div class="submit-container">
                                    <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                    <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                    <button class="item-footer item-footer-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                </div> 
                                <a class="item-footer item-footer-button" href="requestquote.php"><b>Request Quote</b></a>
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
                            <form class="item highlighted-item" action="negotiate.php" target="_blank" method="post">
                                <div class="item-title-container">
                                    <i class="item-title fa-solid fa-bolt"></i>
                                    <h3 class="item-title"><?php echo $row['sname'];?></h3>
                                    <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                </div>

                                <p class="item-subtitle">Provider Name: </p>
                                <p class="item-description" name="provider">
                                    <?php echo $row['pname'];?>
                                    <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                </p>

                                <p class="item-subtitle">Type: </p>
                                <p class="item-description">
                                    <?php echo $row['type'];?>
                                    <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                </p>

                                <p class="item-subtitle">Description: </p>
                                <p class="item-description">
                                    <?php echo $row['description'];?>
                                    <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                </p>

                                <p class="item-subtitle">Terms: </p>
                                <p class="item-description">
                                    <?php echo $row['terms'];?>
                                    <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                </p>

                                <div class="submit-container">
                                    <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                    <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                    <button class="item-footer submit-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                </div> 
                                <a class="item-footer item-footer-button" href="requestquote.php"><b>Request Quote</b></a>
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
                            <form class="item highlighted-item" action="negotiate.php" target="_blank" method="post">
                                <div class="item-title-container">
                                    <i class="item-title fa-solid fa-bolt"></i>
                                    <h3 class="item-title"><?php echo $row['sname'];?></h3>
                                    <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                </div>

                                <p class="item-subtitle">Provider Name: </p>
                                <p class="item-description" name="provider">
                                    <?php echo $row['pname'];?>
                                    <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                </p>

                                <p class="item-subtitle">Type: </p>
                                <p class="item-description">
                                    <?php echo $row['type'];?>
                                    <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                </p>

                                <p class="item-subtitle">Description: </p>
                                <p class="item-description">
                                    <?php echo $row['description'];?>
                                    <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                </p>

                                <p class="item-subtitle">Terms: </p>
                                <p class="item-description">
                                    <?php echo $row['terms'];?>
                                    <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                </p>
                                <div class="submit-container">
                                    <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                    <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                    <button class="item-footer item-footer-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                </div> 
                                <a class="item-footer item-footer-button" href="requestquote.php"><b>Request Quote</b></a>
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
                            <form class="item highlighted-item" action="negotiate.php" target="_blank" method="post">
                                <div class="item-title-container">
                                    <i class="item-title fa-solid fa-bolt"></i>
                                    <h3 class="item-title"><?php echo $row['sname'];?></h3>
                                    <input type="hidden" name="servicename" value="<?php echo $row['sname'];?>">
                                </div>

                                <p class="item-subtitle">Provider Name: </p>
                                <p class="item-description" name="provider">
                                    <?php echo $row['pname'];?>
                                    <input type="hidden" name="providername" value="<?php echo $row['pname'];?>">
                                </p>

                                <p class="item-subtitle">Type: </p>
                                <p class="item-description">
                                    <?php echo $row['type'];?>
                                    <input type="hidden" name="type" value="<?php echo $row['type'];?>">
                                </p>

                                <p class="item-subtitle">Description: </p>
                                <p class="item-description">
                                    <?php echo $row['description'];?>
                                    <input type="hidden" name="desc" value="<?php echo $row['description'];?>">
                                </p>

                                <p class="item-subtitle">Terms: </p>
                                <p class="item-description">
                                    <?php echo $row['terms'];?>
                                    <input type="hidden" name="terms" value="<?php echo $row['terms'];?>">
                                </p>

                                <div class="submit-container">
                                    <input type="hidden" name="cost" value="<?php echo $row['cost'];?>">
                                    <input type="hidden" name="pemail" value="<?php echo $row['pemail'];?>">
                                    <button class="item-footer item-footer-button"><b>$<?php echo $row['cost'];?></b> per Month</button>
                                </div> 
                                <a class="item-footer item-footer-button" href="requestquote.php"><b>Request Quote</b></a>
                            </form>
                        <?php
                        }

                    }
                    ?>

                </div>

                <div class="left-content">

                    <h2 class="subtitle">Services Subscribed To</h2>
                    
                    <?php
                    require('../php/database.php');
                    $sanemail = mysqli_real_escape_string($mysqli, $_SESSION['email']);
                    $result = mysqli_query($mysqli, "SELECT * FROM outsideservice WHERE customer_email='$sanemail'");
                    while($row = mysqli_fetch_array($result))
                    {
                    ?>

                        <div class="item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid fa-bolt"></i>
                                <h3 class="item-title"><?php echo $row['name'];?></h3>
                            </div>
                            <p class="item-description">
                                <?php echo $row['description'];?><br><br>
                                Type: <?php echo $row['type'];?><br><br>
                                Terms: <?php echo $row['terms'];?><br><br>
                                Address: <?php echo $row['address'];?>
                            </p>
                            <p class="item-footer"><b>$<?php echo $row['cost'];?></b> per Month</p>
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

                        <div class="item">
                            <div class="item-title-container">
                                <i class="item-title fa-solid fa-bolt"></i>
                                <h3 class="item-title"><?php echo $row['service_name'];?></h3>
                            </div>
                            <p class="item-description">
                                <?php echo $row['description'];?><br><br>
                                Type: <?php echo $row['type'];?><br><br>
                                Terms: <?php echo $row['terms'];?>
                                Address: <?php echo $row['address'];?>
                            </p>
                            <p class="item-footer"><b>$<?php echo $row['cost'];?></b> per Month</p>
                        </div>

                    <?php
                    }
                    ?>

                </div>

                <div class="right-content">

                    <h1 class="subtitle">Services Needed</h1>
                    <!-- <a href="#" class="service-cost recommended-service-button"><b>Calculate Needs</b><br></b></a><br>-->
                
                    <?php
                    $sql = require __DIR__ . "/../php/service-calculator.php";
                    $sql = $sql . sprintf("AND c.email = '%s'", $mysqli->real_escape_string($_SESSION["email"]));
                    $client_result = $mysqli->query($sql);
                    while ($row = mysqli_fetch_array($client_result)){
                    ?>
                        <div class="item highlighted-item">
                            <form action="negotiate.php" target="_blank" method="post">
                                <div class="item-title-container">
                                    <i class="item-title fa-solid fa-bolt"></i>
                                    <h3 class="item-title"><?php echo $row['s_name'];?></h3>
                                    <input type="hidden" name="servicename" value="<?php echo $row['s_name'];?>">
                                    <input type="hidden" name="type" value="<?php echo $row['s_type'];?>">
                                </div>
                                <p class="item-subtitle">Provided By: </p>
                                <p class="item-description">
                                    <?php echo $row['p_name'];?><br><br>
                                    <input type="hidden" name="providername" value="<?php echo $row['p_name'];?>">
                                </p>
                                <p class="item-subtitle">Description: </p>
                                <p class="item-description">
                                    <?php echo $row['s_description'];?><br><br>
                                    <input type="hidden" name="desc" value="<?php echo $row['s_description'];?>">
                                </p>
                                <p class="item-subtitle">Terms: </p>
                                <p class="item-description">
                                    <?php echo $row['s_terms'];?><br><br>
                                    <input type="hidden" name="terms" value="<?php echo $row['s_terms'];?>">
                                </p>
                                <input type="hidden" name="cost" value="<?php echo $row['s_cost'];?>">
                                <input type="hidden" name="pemail" value="<?php echo $row['p_email'];?>">
                                <button class="item-footer item-footer-button"><b>$<?php echo $row['s_cost'];?></b> per Month</button>
                            </form>
                        </div>
                    <?php
                    }
                    ?>

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