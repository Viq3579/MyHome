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

        <title>Edit Profile</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/input-form.css">
        <link rel="stylesheet" href="../css/footer.css">
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

        // Varify Phone is Unique
        $sql = sprintf("SELECT *
        FROM customer
        WHERE phone_num = '$phone'",
        $mysqli->real_escape_string($_POST["phone"]));

        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();

        if ($user) {
            echo "<div class='form'>
            <h3>That Phone Number has already been registered. If you believe this to be an error, please contact support</h3><br/>
            <p class='link'>Click here to <a href='changeprofile.php'>Try Again</a></p>
            </div>";
        }
        else
        {
            $query    = "UPDATE customer SET name = '$name', phone_num = '$phone', family_income = '$income', num_cars = '$cars', misc_expenses = '$expense' WHERE email = '$email';";
            $result   = mysqli_query($mysqli, $query);
            if ($result) {
                echo "<div class='form'>
                    <h3>Edited successfully.</h3><br/>
                    <p class='link'>Click here to <a href='profile.php'>Return to Profile</a></p>
                    </div>";
            } else {
                echo "<div class='form'>
                    <h3>Required fields are missing.</h3><br/>
                    <p class='link'>Click here to <a href='changeprofile.php'>Edit Profile</a> again.</p>
                    </div>";
            }
        }
    } else {
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

        <form class="form" action="" method="post">

            <h1 class="login-title">Edit Customer Profile</h1>
            <p> Email: <?php echo $_SESSION['email']?></p>

            <div class="input">
                <label class="input-header" for="name">Your Name:</label>
                <input class="input-field" type="text" id="name" name="name" required>
            </div>

            <div class="input">
                <label class="input-header" for="phone">Phone Number:</label>
                <input class="input-field" type="number" id="phone" name="phone" required>
            </div>
            
            <div class="input">
                <label class="input-header" for="income">Annual Income:</label>
                <input class="input-field" type="number" id="income" name="income" required>
            </div>

            <div class="input">
                <label class="input-header" for="miscexpenses">Non-Service Expenses:</label>
                <input class="input-field" type="number" id="miscexpenses" name="miscexpenses" required>
            </div>

            <div class="input">
                <label class="input-header" for="numbcars">Number of Cars:</label>
                <input class="input-field" type="number" id="numbcars" name="numbcars" required>
            </div>

            <div class="submit-container">
                <button class="submit-button">Update Account</button>
            </div>

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
        <?php
        }
        ?>
    </body>

</html>