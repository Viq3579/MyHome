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
            $query    = "INSERT into `customer` (name, email, phone_num, family_income, num_cars, misc_expenses)
                        VALUES ('$name', '$email', '$phone', '$income', '$cars', '$expense')";
            $result   = mysqli_query($mysqli, $query);
            if ($result) {
                echo "<div class='form'>
                    <h3>You are registered successfully.</h3><br/>
                    <p class='link'>Click here to <a href='home.html'>Login</a></p>
                    </div>";
            } else {
                echo "<div class='form'>
                    <h3>Required fields are missing.</h3><br/>
                    <p class='link'>Click here to <a href='editprofilep2.php'>registration</a> again.</p>
                    </div>";
            }
        } else {
        ?>
        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>

                <nav class="header-nav">

                    <a class="header-links" href="home.html">Dashboard</a>
                    <a class="header-links" href="searchservices.html">Services</a>
                    <a class="header-links" href="profile.html">Profile</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>

            </div>

        </header>


        <main class="main-content" style="display: flex; flex-direction: column; align-items: center;">

            <form class="form" action="" method="post">

                <h1 class="login-title">Edit Customer Profile</h1>

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
<<<<<<< HEAD
        ?>
    </body>

=======
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
>>>>>>> 080135cab7c138a5a58ee811c4219ad18aa64aba
</html>