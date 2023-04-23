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
    require_once '../vendor/autoload.php';
    use League\OAuth2\Client\Provider\Google;

    session_start(); // Remove if session.auto_start=1 in php.ini

    $provider = new Google([
        'clientId'     => '{google-client-id}',
        'clientSecret' => '{google-client-secret}',
        'redirectUri'  => 'http://localhost/MyHome/html/forgotpass.php',
    ]);
    //Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    
    
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
    $mail->SMTPAuth = true;
    //to view proper logging details for success and error messages
    // $mail->SMTPDebug = 1;
    $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
    $mail->Username = 'ian.m.finnigan@gmail.com';   //email
    $mail->Password = '' ;   //16 character obtained from app password created
    $mail->Port = 465;                    //SMTP port
    $mail->SMTPSecure = "ssl";


    if (isset($_REQUEST['email'])) {
        $email = $_REQUEST['email'];
        //$email = mysqli_real_escape_string($mysqli, $email);
        //verify the email is valid
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = $mysqli->query($query);
        if ($result){
            //sender information
            $mail->setFrom('ian.m.finnigan@gmail.com', 'MyHome');

            //receiver email address and name
            $mail->addAddress($email); 

            // Add cc or bcc   
            // $mail->addCC('email@mail.com');  
            // $mail->addBCC('user@mail.com');  
            
            
            $mail->isHTML(true);
            
            $mail->Subject = 'My Home Password Reset';
            $mail->Body    = "
            <b>You are recieving this email because someone requested a password change for your MyHome account.</b>
                <p>If you did not request a change, ignore this email. If you did make this request, please click the following link:</p>
                <a href=\"http://localhost/MyHome/html/passrecovery.php?email='$email'\">Reset Password</a>
                <p>This link will last for 24 hours or until used.</p>";

            // Send mail   
            if (!$mail->send()) {
                echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
            } else {
                $timestamp = date("Y-m-d H:i:s");
                $query = "SELECT * FROM password_resets WHERE email = '$email'";
                $temp = $mysqli->query($query);
                $result = $temp->fetch_assoc();
                if ($result){
                    $query = "UPDATE password_resets SET created_at = '$timestamp' WHERE email = '$email'";
                } else {
                    $query = "INSERT into `password_resets` (email, created_at)
                    VALUES ('$email', '$timestamp')";
                }
                $result = $mysqli->query($query);
                echo 'Message has been sent.';
            }

            $mail->smtpClose();


        } else {
            $mail->smtpClose();
            echo "<div class='form'>
            <h3>There is no account associated with that email.<br>If you believe this to be an error, please contact the site administrator.</h3><br/>
            <p class='link'>Click here to <a href='forgotpass.php'>Try Again</a></p>
            </div>";
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

            <form class="form" action="forgotpass.php" method="post">

                <h1 class="login-title">Forgot Password?</h1>

                <div class="input">
                    <label class="input-header">Enter your email and we will send a recovery link for you to change your password</label>
                </div>

                <div class="input">
                    <label class="input-header" for="email">Email:</label>
                    <input class="input-field" type="email" id="email" name="email" required>
                </div>

                <div class="submit-container">
                    <button class="submit-button">Send Email</button>
                </div>

                <div class="submit-container">
                    <button class="submit-button">Return to Login</button>
                </div>

            </form>

        </main>
    <?php
    }
    ?>


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