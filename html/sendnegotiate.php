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

        <title>Add Home</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/input-form.css">
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

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
            if (isset($_POST["accept"]))
            {
                $accept = $_POST["accept"];
            } else {
                $accept = "NO";
            }


            if ($accept = "Yes"){
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
                    WHERE owner_email = '$cemail' AND service_name = '$sname' AND address = '$address'",
                    $mysqli->real_escape_string($_POST["address"]));
        
                    $result = $mysqli->query($sql);
                    $user = $result->fetch_assoc();
        
                    if ($user) {
                        echo "<div class='form'>
                        <h3>Our records show you already have this service. If you believe this to be an error, please contact the site administrator.</h3><br/>
                        <p class='link'>Click here to <a href='profile.php'>Return to Profile</a></p>
                        </div>";
                    } else {
                        $query = "SELECT custom FROM offers WHERE sname = '$sname' AND pemail = '$pemail' AND cemail = '$cemail' AND cost = '$cost' AND terms = '$terms' AND penalty = '$penalty' AND address = '$address'";
                        $result = mysqli_query($mysqli, $query);
                        $temp = mysqli_fetch_array($result);
                        if (isset($temp[0])){
                            $custom = $temp[0];
                        } else {
                            $custom = 0;
                        }

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
                
                if ($_POST["price"] != NULL){
                    $cost = $_POST["price"];
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
    </body>

</html>