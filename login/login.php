<?php
    require_once '../config/connection.php'; //include connection.php once

    session_start(); //session start

    $errors = []; //array for storing errors

    if (isset($_SESSION['errors'])) { //check if there is errors stored in session
        $errors = $_SESSION['errors']; //retrieve the errors 
        unset($_SESSION['errors']); //clear the errors in session
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">

    <script src="../js/login.js" defer></script> 
</head>
<body>

    <div class="login-container height-100">
        <img src="../img/survey.webp" alt="login-image">
        <div class="login-form">
            <img src="../img/gosurv_border.png" alt="">
            <h2>LOGIN</h2>
            <form action="../formhandlers/login/login-process.php" method="post">
                <h1>Login</h1>
                <!--display errors-->
                <?php if (count($errors) > 0): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <!--username and email field-->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="text" class="form-control" id="username/email" name="username/email" placeholder="Username/Email" onkeyup="checkUsernameOREmail(this.value)">
                    <span id="username/email-message"></span>
                </div>
                <!--password field-->
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" onkeyup="checkPassword()">
                    <span id="password-message"></span>
                </div>
                <!--keep me logged in checkbox-->
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="keep-me-logged-in" name="keep-me-logged-in">
                    <label for="keep-me-logged-in">Keep Me Logged In</label>
                </div>
                <!--submit button-->
                <input type="submit" class="btn btn-new-survey" id="submit" name="submit" value="Login">
            </form>
            <!--links-->
            <div class="login-links">
                <a href="forgot-password.php">Forgot Your Password?</a>
                <a href="../register/register.php">Don't Have An Account?</a>
            </div>
        </div>
    </div>
</body>
</html>