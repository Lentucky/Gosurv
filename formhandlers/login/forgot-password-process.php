<?php
    require_once '../../config/connection.php'; //include connection.php once

    session_start(); //start session

    $errors = array(); //array for errors
    
    if (isset($_POST['change-password-button'])) { //check if the form was submitted
        $email = filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
        $password = filter_var(trim($_POST['password']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $hashed_password = password_hash($password,PASSWORD_DEFAULT); //hash password

        $insert = $connection -> prepare('UPDATE survey_db.users SET password = ? WHERE email = ?'); //prepare statement
        if ($insert === false) { //check if prepare failed
            $errors['insert_prepare_error'] = 'An error occurred! Please try again!'; //store error in errors array
            $_SESSION['errors'] = $errors; //store errors array in session
        }
        else {
            $insert -> bind_param('ss',$hashed_password, $email,);
            if ($insert -> execute() === false) { //check if execute failed
                $errors['insert_execute_error'] = 'An error occurred! Please try again!'; //store error in errors array
                $_SESSION['errors'] = $errors; //store errors array in session
            }
            else {
                header('location: ../../login/login.php');
                exit(); //stop the script
            }
            $insert -> close(); //close statement
        }
    }
    $connection -> close(); //close connection
?>