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
    <meta name="description" content="a recovery website where existing users change their password">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!--load forgot-password.js-->
    <script src="../js/forgot-password.js" defer></script> 
</head>
<body>
    <form action="../formhandlers/login/forgot-password-process.php" method="post" id="form">
        <h1 id="header">Confirm Email</h1>
        <!--display errors-->
        <?php if (count($errors) > 0): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <!--email field-->
        <input type="text" id="email" name="email" placeholder="Email" onkeyup="checkEmail(this.value)">
        <span id="email-message"></span>
        <!--submit button-->
        <input type="submit" id="submit" name="submit" value="Confirm Email" disabled onclick="enableChangePassword()">
    </form>
    <!--link-->
    <a href="../register/register.php">Don't Have An Account?</a>
</body>
</html>