<?php
    require_once '../../config/connection.php'; //include connection.php once

    if (isset($_GET['password'])) { //check if password is submitted
        $password = filter_var(trim($_GET['password']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim password

        if (strlen($password) < 8) { //check if the characters is less than 8
            echo 'Password is weak!';
        }
        else {
            echo 'Password is strong!';
        }
    }
    $connection -> close(); //close connection
?>