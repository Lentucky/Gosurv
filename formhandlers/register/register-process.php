<?php
    require_once '../../config/connection.php'; //include connection.php once

    session_start(); //start session

    $errors = array(); //array for errors
    
    if (isset($_POST['submit'])) { //check if the form was submitted
        $username = filter_var(trim($_POST['username']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim values
        $email = filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
        $password = filter_var(trim($_POST['password']),FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $hashed_password = password_hash($password,PASSWORD_DEFAULT); //hash password

        $insert = $connection -> prepare('INSERT INTO survey_db.users (username,email,password,userType,image) VALUES (?,?,?,?,?)'); //prepare statement
        if ($insert === false) { //check if prepare failed
            $errors['insert_prepare_error'] = 'An error occurred! Please try again!'; //store error in errors array
            $_SESSION['errors'] = $errors; //store errors array in session
        }
        else {
            $userType = 'user';
            $image_path = '../../img/profile/default.jpg'; //image path
            $image = file_get_contents($image_path); //read image file
            $insert -> bind_param('sssss',$username,$email,$hashed_password,$userType,$image);
            if ($insert -> execute() === false) { //check if execute failed
                $errors['insert_execute_error'] = 'An error occurred! Please try again!'; //store error in errors array
                $_SESSION['errors'] = $errors; //store errors array in session
            }
            else {
                header('location: ../../register/register.php');
                exit(); //stop the script
            }
            $insert -> close(); //close statement
        }
    }
    $connection -> close(); //close connection
?>