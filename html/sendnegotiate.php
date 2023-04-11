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
            $cemail = ($_SESSION['email']);
            $sname = stripslashes($_REQUEST['servicename']);
            $pemail = stripslashes($_REQUEST['pemail']);


            if (isset($_REQUEST['address'])){
                $address = $_REQUEST['address'];
            } else {
                $address = $_REQUEST['setaddress'];
            }
            
            if (isset($_REQUEST['price'])){
                $cost = $_REQUEST['price'];
            } else {
                $cost = $_REQUEST['setcost'];
            }

            if (isset($_REQUEST['newterms'])){
                $terms = $_REQUEST['newterms'];
            } else {
                $terms = $_REQUEST['setterms'];
            }

            if (isset($_REQUEST['newpenalty'])){
                $penalty = $_REQUEST['newpenalty'];
            } else {
                $penalty = $_REQUEST['setpenalty'];
            }

            //Verify you own the house
            $query = "SELECT * FROM home WHERE owner_email = '$cemail'";
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
                    $query = "UPDATE offers SET cost = '$cost', terms = '$terms', penalty = '$penalty' WHERE sname = '$sname' AND pemail = '$pemail' AND cemail = '$cemail' AND address = '$address'";
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
                    $query    = "INSERT into `offers` (address, cemail, pemail, sname, cost, terms, penalty)
                                VALUES ('$address', '$cemail', '$pemail', '$sname', '$cost', '$terms', '$penalty')";
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

            }
        ?>
    </body>

</html>