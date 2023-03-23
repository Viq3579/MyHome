<?php
include("../php/auth_session.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/adddhome.css"/>
</head>
<body>
    <?php
    require('../php/database.php');
    
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['name'])) {
        // removes backslashes
        $email = ($_SESSION['email']);
        $name = stripslashes($_REQUEST['name']);
        //escapes special characters in a string
        $name = mysqli_real_escape_string($mysqli, $name);
        $phone = stripslashes($_REQUEST['phone']);
        $phone = mysqli_real_escape_string($mysqli, $phone);
        $income = stripslashes($_REQUEST['income']);
        $income = mysqli_real_escape_string($mysqli, $income);
        $expense = stripslashes($_REQUEST['miscexpenses']);
        $expense = mysqli_real_escape_string($mysqli, $expense);
        $cars = stripslashes($_REQUEST['numbcars']);
        $cars = mysqli_real_escape_string($mysqli, $cars);
        $query    = "UPDATE customer SET name = '$name', phone_num = '$phone', family_income = '$income', num_cars = '$cars', misc_expenses = '$expense' WHERE email = '$email';";

        $result   = mysqli_query($mysqli, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Edited successfully.</h3><br/>
                  <p class='link'>Click here to <a href='profile.html'>Return to Profile</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='changeprofile.php'>Edit Profile</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Edit Customer Profile</h1>
        <p> Email: <?php echo $_SESSION['email']?></p>
        <input type="text" class="login-input" name="name" placeholder="Name" required />
        <input type="number" class="login-input" name="phone" placeholder="Phone Number" required/>
        <input type="number" class="login-input" name="income" placeholder="Annual Income" required/>
        <input type="number" class="login-input" name="miscexpenses" placeholder="Non-Service Expenses" required/>
        <input type="number" class="login-input" name="numbcars" placeholder="Number of Cars" required/>
        <button class="login-button">Submit</button>
    </form>
    <?php
}
?>
</body>
</html>