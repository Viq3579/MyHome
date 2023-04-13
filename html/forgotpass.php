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
    $mail->Password = 'bdxqzraatkmlotpu' ;   //16 character obtained from app password created
    $mail->Port = 465;                    //SMTP port
    $mail->SMTPSecure = "ssl";


    if (isset($_REQUEST['email'])) {
        $email = $_REQUEST['email'];
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
            
            $mail->Subject = 'PHPMailer SMTP test';
            $mail->Body    = "<h4> PHPMailer the awesome Package </h4>
            <b>PHPMailer is working fine for sending mail</b>
                <p> This is a tutorial to guide you on PHPMailer integration</p>";

            // Send mail   
            if (!$mail->send()) {
                echo 'Email not sent an error was encountered: ' . $mail->ErrorInfo;
            } else {
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