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
</head>
<body>
<div class="login-container height-100">
        
    <img src="../img/survey.webp" alt="login-image">

    <div class="login-form">
        <img src="../img/gosurv_border.png" alt="">
        <h2>LOGIN</h2>

        <form action="../formhandlers/register/register-process.php" method="post">
            <!--display errors-->
            <?php if (count($errors) > 0): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" class="form-control" onkeyup="checkUsername(this.value)">
                <span id="username-message"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="text" id="email" name="email" placeholder="Email" class="form-control" onkeyup="checkEmail(this.value)">
                <span id="email-message"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" onkeyup="checkPassword(this.value)">
                <span id="password-message"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Confirm</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" class="form-control" onkeyup="checkConfirmPassword()">
                <span id="confirm-password-message"></span>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>

            <input type="submit" id="submit" name="submit" value="Register"  class="btn btn-new-survey">
        </form>
        <!--link-->
        <div class="login-links">
                <a href="../login/login.php">ALREADY HAVE AN ACCOUNT</a>
        </div>
    </div>
</div>

</body>
</html>