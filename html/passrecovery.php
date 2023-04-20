<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>Forgot Password</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="../css/input-form.css"/>
        <link rel="stylesheet" href="../css/footer.css">
    </head>


    <body>

        <?php
            require('../php/database.php');
            
            if (isset($_POST['email']))
            {
                $email = $_POST['email'];
                echo $email;
                echo "posted";
            } else {
                $email = $_GET['email'];
                echo $email;
                echo "gotten";
            }
            if (isset($_REQUEST['password']))
            {


                echo $email;
                $sanemail = mysqli_real_escape_string($mysqli, $email);
                $timestamp = date("Y-m-d H:i:s");
                $timestamp1 = date_create($timestamp);
                $query = "SELECT created_at FROM password_resets WHERE email = $email";
                $temp = $mysqli->query($query);
                $result = mysqli_fetch_array($temp);
                $result2 = $temp->fetch_assoc();
                echo $result[0];
                echo "We are here3";
                if ($result) {
                    echo "We are here2";
                    $requesttime = $result[0];
                    $requesttime2 = date_create($requesttime);
                    $interval = date_diff($timestamp1, $requesttime2);
                    //$interval = $timestamp->diff($requesttime);
                    //echo $result[0];
                    //echo $interval;
                    if ($interval->format('%H') < 24){
                        echo "We are here";
                        if (empty($_POST["password"])) {
                            echo "<div class='form' action='passrecovery.php' method='get'>
                            <h3> Password is required.</h3><br/>
                            <button class=\"login-button\">Try Again</button>
                            </div>";
                        }
                        elseif (strlen($_POST["password"]) < 8) {
                            echo "<div class='form' action='passrecovery.php' method='get'>
                            <h3> Passwords Must be at least 8 characters.</h3><br/>
                            <button class=\"login-button\">Try Again</button>
                            </div>";
                        }
                        elseif (!preg_match("/[a-z]/i", $_POST["password"])) {
                            echo "<div class='form' action='passrecovery.php' method='get'>
                            <h3> Passwords Must Contain a Lowercase Letter.</h3><br/>
                            <button class=\"login-button\">Try Again</button>
                            </div>";
                        }
                        elseif (!preg_match("/[0-9]/i", $_POST["password"])) {
                            echo "<div class='form' action='passrecovery.php' method='get'>
                            <h3> Password Must Contain a Number.</h3><br/>
                            <button class=\"login-button\">Try Again</button>
                            </div>";
                        }
                        elseif($_POST["password"] != $_POST["password_confirmation"]) {
                            echo "<div class='form' action='passrecovery.php' method='get'>
                            <h3> Passwords Must Match.</h3><br/>
                            <button class=\"login-button\">Try Again</button>
                            </div>";
                        }
                        else{
                            $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                            $query = "UPDATE user SET password_hash = '$hash' WHERE email = $email";
                            $result = $mysqli->query($query);
                            if ($result){
                                $query = "DELETE FROM password_resets WHERE email = $email";
                                $result = $mysqli->query($query);
                                echo "<div class='form'>
                                <h3>Edited successfully.</h3><br/>
                                <p class='link'>Click here to <a href='login.php'>Login</a></p>
                                </div>";
                            } else {
                                echo "<div class='form'>
                                <h3>Unidentified Error.</h3><br/>
                                <p class='link'>Click here to <a href='login.php'>Login</a></p>
                                </div>";
                            }
                        }

                    } else {
                        $query = "DELETE FROM password_resets WHERE email = $email";
                        $result = $mysqli->query($query);
                        echo "<div class='form'>
                        <h3>ERROR: Expired Link.</h3><br/>
                        <p class='link'>Click here to <a href='login.php'>Login</a></p>
                        </div>";
                    }
                }
            } else {
        ?>
        <header class="header">

            <div class="header-container">
                <h1 class="header-logo">MyHome</h1>

                <nav class="header-nav">

                    <a class="header-links" href="../index.php">Home</a>

                </nav>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="../php/logout.php">Log Out</a>
                </div>
            
            </div>

        </header>

        
        <main class="main-content" style="display: flex; flex-direction: column; align-items: center;">

            <form class="form" action="passrecovery.php" method="post">

                <h1 class="login-title">Change Your Password</h1>

                <div class="input">
                    <label class="input-header" for="password">Password:</label>
                    <input class="input-field" type="password" id="password" name="password">
                    <input type="hidden" name="email" value="<?php echo $email;?>">
                </div>

                <div class="input">
                    <label class="input-header" for="password_confirmation">Confirm Password:</label>
                    <input class="input-field" type="password" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="submit-container">
                    <button class="submit-button">Submit Change</button>
                </div>

            </form>

        </main>

        <?php } ?>
        
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