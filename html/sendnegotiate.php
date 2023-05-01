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

        <title>MyHome - Send Negotiation</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/input-form.css">
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>


        <main class="main-content">

            <div class="container">

                <div class="center-content">

                    <?php
                        require('../php/database.php');
                        
                        // When form submitted, insert values into the database.
                        // removes backslashes
                        $custom = 0;
                        $cemail = ($_SESSION['email']);
                        $description = $_POST["description"];
                        $type = $_POST["type"];
                        $sname = stripslashes($_REQUEST['servicename']);
                        $pemail = stripslashes($_REQUEST['pemail']);
                        $pname = stripslashes($_REQUEST['pname']);
                        if (isset($_POST["accept"]) && $_POST["type"] == 'Yes')
                        {
                            $accept = "Yes";
                            //echo "actually this guy ran";
                        } else {
                            $accept = "NO";
                            //echo "this guy ran";
                        }


                        if ($accept == "Yes"){
                            $address = $_POST["setaddress"];
                            $cost = $_POST["setcost"];
                            $terms = $_POST["setterms"];
                            $penalty = $_POST["setpenalty"];
                                        //Verify you own the house
                            if ($address != "Not Specified") {
                                //echo "this is the one we ran";
                                $query = "SELECT * FROM home WHERE owner_email = '$cemail' AND address = '$address'";
                            } else {
                                //echo "no this is the one we actually ran";
                                $query = "SELECT * FROM customer WHERE email = '$cemail'";
                            }
                            $result = $mysqli->query($query);
                            $owns = $result->fetch_assoc();
                            if ($owns) {

                                // Varify key is Unique
                                $sql = sprintf("SELECT *
                                FROM hasservice
                                WHERE owner_email = '$cemail' AND service_name = '$sname' AND provider_email = '$pemail' AND address = '$address'",
                                $mysqli->real_escape_string($_POST["address"]));
                    
                                $result = $mysqli->query($sql);
                                $user = $result->fetch_assoc();
                    
                                if ($user) {
                                    echo "<div class='form'>
                                    <h3>Our records show you already have this service. If you believe this to be an error, please contact the site administrator.</h3><br/>
                                    <p class='link'>Click here to <a href='profile.php'>Return to Profile</a></p>
                                    </div>";
                                } else {
                                    $sql = sprintf("SELECT *
                                    FROM unverifiedservice
                                    WHERE cemail = '$cemail' AND name = '$sname' AND address = '$address' AND provider = '$pname'",
                                    $mysqli->real_escape_string($_POST["address"]));

                                    $result = $mysqli->query($sql);
                                    $user = $result->fetch_assoc();
                                    if ($user) {
                                        echo "<div class='form'>
                                        <h3>Our records show you already have an active request for this service. If you believe this to be an error, please contact the site administrator.</h3><br/>
                                        <p class='link'>Click here to <a href='profile.php'>Return to Profile</a></p>
                                        </div>";
                                    } else {
                                        
                                        $query = "INSERT into `unverifiedservice` (name, provider, cemail, address, type, description, terms, penalty, custom, cost)
                                        VALUES ('$sname', '$pname', '$cemail', '$address', '$type', '$description', '$terms', '$penalty', '$custom', '$cost')";
                                        $result   = mysqli_query($mysqli, $query);
                                        
                                        // if ($custom == 1){
                                        //     $query = "INSERT into `customservice` (sname, pemail, cemail, address, cost, terms, penalty, description)
                                        //     VALUES ('$sname', '$pemail', '$cemail', '$address', '$cost', '$terms', '$penalty', '$description')";
                                        //     $result   = mysqli_query($mysqli, $query);
                                        // }
                                        if ($result) {
                                            $query = "SELECT pay_link FROM provider WHERE email = '$pemail'";
                                            $result = mysqli_query($mysqli, $query);
                                            $temp = mysqli_fetch_array($result);
                                            $pay_link = $temp[0];

                                            echo "<div class='form'>
                                                <h3></h3><br/>
                                                <p class='link'>Click here to <a href='https://$pay_link'>Fill out payment information</a></p>
                                                </div>";
                                        } else {
                                            echo "<div class='form'>
                                                <h3>Required fields are missing.</h3><br/>
                                                <p class='link'>Click here to <a href='negotiate.php'>Try Again</a> again.</p>
                                                </div>";
                                        }
                                    }

                                    $query = "SELECT custom FROM offers WHERE sname = '$sname' AND pemail = '$pemail' AND cemail = '$cemail' AND cost = '$cost' AND terms = '$terms' AND penalty = '$penalty' AND address = '$address'";
                                    $result = mysqli_query($mysqli, $query);
                                    $temp = mysqli_fetch_array($result);
                                    if (isset($temp[0])){
                                        $custom = $temp[0];
                                    } else {
                                        $custom = 0;
                                    }

                                }
                            } else {
                                echo "<div class='form'>
                                    <h3>We have no record of you in that address.</h3><br/>
                                    <p class='link'>Click here to return to<a href='profile.php'>Dashboard</a></p>
                                    </div>";
                            }
                        }
                        else {
                            if ($_POST["address"] != NULL){
                                $address = $_POST["address"];
                                $custom = 1;
                            } else {
                                $address = $_POST["setaddress"];
                            }
                            
                            if ($_POST["newcost"] != NULL){
                                $cost = $_POST["newcost"];
                                $custom = 1;
                            } else {
                                $cost = $_POST["setcost"];
                            }

                            if ($_POST["newterms"] != NULL){
                                $terms = $_POST["newterms"];
                                $custom = 1;
                            } else {
                                $terms = $_POST["setterms"];
                            }

                            if ($_POST["newpenalty"] != NULL){
                                $penalty = $_POST["newpenalty"];
                                $custom = 1;
                            } else {
                                $penalty = $_POST["setpenalty"];
                            }

                            //Verify you own the house
                            if ($address != "Not Specified"){
                                $query = "SELECT * FROM home WHERE owner_email = '$cemail' AND address = '$address'";
                            } else{
                                $query = "SELECT * FROM home WHERE owner_email = '$cemail'";
                            }
                            $result = $mysqli->query($query);
                            $owns = $result->fetch_assoc();
                            if ($owns) {

                                // Varify key is Unique
                                $sql = sprintf("SELECT *
                                FROM offers
                                WHERE cemail = '$cemail' AND pemail = '$pemail' AND sname = '$sname' AND address = '$address'",
                                $mysqli->real_escape_string($_POST["address"]));
                    
                                $result = $mysqli->query($sql);
                                $user = $result->fetch_assoc();
                    
                                if ($user) {
                                    if ($custom = 1){
                                        $query = "UPDATE offers SET custom = '$custom', cost = '$cost', terms = '$terms', penalty = '$penalty' WHERE sname = '$sname' AND pemail = '$pemail' AND cemail = '$cemail' AND address = '$address'";
                                    }
                                    else
                                    {
                                        $query = "UPDATE offers SET cost = '$cost', terms = '$terms', penalty = '$penalty' WHERE sname = '$sname' AND pemail = '$pemail' AND cemail = '$cemail' AND address = '$address'";
                                    }
                                    
                                    $result   = mysqli_query($mysqli, $query);
                                    if ($result) {
                                        echo "<div class='form'>
                                            <h3>Requested successfully.</h3><br/>
                                            <p class='link'>Click here to <a href='profile.php'>Return to Profile</a></p>
                                            </div>";
                                    } else {
                                        echo "<div class='form'>
                                            <h3>Required fields are missing.</h3><br/>
                                            <p class='link'>Click here to <a href='negotiate.php'>Try Again</a> again.</p>
                                            </div>";
                                    }
                                }
                                else
                                {
                                    $query    = "INSERT into `offers` (custom, address, cemail, pemail, sname, cost, terms, penalty)
                                                VALUES ('$custom', '$address', '$cemail', '$pemail', '$sname', '$cost', '$terms', '$penalty')";
                                    $result   = mysqli_query($mysqli, $query);
                                    if ($result) {
                                        echo "<div class='form'>
                                            <h3>Offer senty successfully.</h3><br/>
                                            <p class='link'>Click here to return to<a href='profile.php'>Dashboard</a></p>
                                            </div>";
                                    } else {
                                        echo "<div class='form'>
                                            <h3>Required fields are missing.</h3><br/>
                                            <p class='link'>Click here to <a href='negotiate.php'>Try Again</a> again.</p>
                                            </div>";
                                    }
                                }

                            } else {
                                echo $address;
                                echo "<div class='form'>
                                    <h3> :We have no record of you in that address.</h3><br/>
                                    <p class='link'>Click here to return to<a href='profile.php'>Dashboard</a></p>
                                    </div>";
                            }
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