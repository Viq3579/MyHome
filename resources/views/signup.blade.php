<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/07a7f1d094.js" crossorigin="anonymous"></script>

        <title>MyHome - Signup</title>
        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        <link rel="stylesheet" href="{{ asset('css/login-signup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    </head>


    <body>

        <header class="header">

            <div class="header-container">
                <h1><a class="header-logo" href="{{ url('/') }}">MyHome</a></h1>
                
                
                <div class="header-cta">
                    <a class="header-login login" href="login">Log In</a>
                    <a class="header-signup signup" href="signup">Sign Up</a>
                </div>
            
            </div>

        </header>

        
        <main class="main-content">

            <form class="form">

                <h2 class="form-header">Create Account</h2>

                <div class="input">
                    <label class="input-header" for="first_name">First Name:</label>
                    <input class="input-field" type="text" id="first_name" name="first_name">
                </div>

                <div class="input">
                    <label class="input-header" for="last_name">Last Name:</label>
                    <input class="input-field" type="text" id="last_name" name="last_name">
                </div>

                <div class="input">
                    <label class="input-header" for="email">Email:</label>
                    <input class="input-field" type="email" id="email" name="email">
                </div>

                <div class="input">
                    <label class="input-header" for="password">Password:</label>
                    <input class="input-field" type="password" id="password" name="password">
                </div>

                <div class="input">
                    <label class="input-header" for="password_confirmation">Confirm Password:</label>
                    <input class="input-field" type="password" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="submit-container">
                    <a class="input-header" href="login">Already have an account?</a>
                    <a class="submit-button" href="home">Add Account</a>
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
    </body>

</html>