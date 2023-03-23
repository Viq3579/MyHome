<?php
include("../php/auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Add Home</title>
    <link rel="stylesheet" href="../css/adddhome.css">
</head>
<body>
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
            $heattime = stripslashes($_REQUEST['heattime']);
            $heattime = mysqli_real_escape_string($mysqli, $heattime);
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
                echo "<div class='form'>
                <h3>That Address has already been registered. If you believe this to be an error, please contact support</h3><br/>
                <p class='link'>Click here to <a href='addhome.php'>Try Again</a></p>
                </div>";
            }
            else
            {
                $query    = "INSERT into `home` (owner_email, address, lot_size, cooling_type, construction_type, garage_size, year_built, property_type, heating_type, heating_time, num_floors, floor_space, roof, bathrooms)
                            VALUES ('$email', '$address','$lot_size', '$cooltype', '$contype', '$garage', '$year_built', '$proptype', '$heattype', '$heattime', '$floors', '$floorspace', '$rooftype', '$bathrooms')";
                $result   = mysqli_query($mysqli, $query);
                if ($result) {
                    echo "<div class='form'>
                        <h3>Home added successfully.</h3><br/>
                        <p class='link'>Click here to <a href='profile.html'>Dashboard</a></p>
                        </div>";
                } else {
                    echo "<div class='form'>
                        <h3>Required fields are missing.</h3><br/>
                        <p class='link'>Click here to <a href='addhome.php'>Add Home</a> again.</p>
                        </div>";
                }
            }
        } else {
    ?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Add Home</h1>
        <input type="text" class="login-input" name="address" placeholder="Address" required />
        <input type="text" class="login-input" name="year_built" placeholder="Year Built" required/>
        <input type="number" class="login-input" name="lot_size" placeholder="Lot Size (square feet)" required/>
        <input type="text" class="login-input" name="contype" placeholder="Construction Type" required/>
        <input type="number" class="login-input" name="garage" placeholder="Garage Size" required/>
        <input type="number" class="login-input" name="floors" placeholder="Floors" required/>
        <input type="text" class="login-input" name="cooltype" placeholder="Cooling Type" required/>
        <input type="number" class="login-input" name="floorspace" placeholder="Floor Space (square feet)" required />
        <input type="number" class="login-input" name="bathrooms" placeholder="Bathrooms" required/>
        <input type="text" class="login-input" name="heattype" placeholder="Heating Type" required/>
        <input type="number" class="login-input" name="heattime" placeholder="Heating Time (minutes)" required/>
        <input type="number" class="login-input" name="bedrooms" placeholder="Bedrooms" required/>
        <input type="text" class="login-input" name="proptype" placeholder="Property Type" required/>
        <input type="text" class="login-input" name="rooftype" placeholder="Roof Design" required/>
        <input type="text" class="login-input" name="foundation" placeholder="Foundation Type" required/>
        <button class="login-button">Submit</button>
    </form>
<?php
}
?>
</body>
</html>
