<?php
    session_start();
    if(isset($_SESSION['userLoggedIn'])){
        header('Location: index.php');
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/assets/js/sign_up.js"></script>
</head>

<body>
    <div class="signup-container">
        <div class="signup">
            <div class="message" id="message"></div>
            <h1 class="signup__title">SIGN UP</h1>
            <form action="/ajax/process_signup.php" method="POST" class="signup-form">
                <div class="form-group">
                    <input type="text" class="form-group__input" name="username" id="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-group__input" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-group__input" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="buttons">
                    <a href="index.php">&#10229; Back</a>
                    <button class="signup-form__button" type="submit" name="submit" id="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>