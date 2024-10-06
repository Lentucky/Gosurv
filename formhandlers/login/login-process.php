<?php
    require_once '../../config/connection.php'; //include connection.php once

    session_start(); //start session

    $errors = array(); //make array for storing errors

    if (isset($_POST['submit'])) { //check if submit was submitted
        $value = filter_var(trim($_POST['username/email']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim value
        
        $find_id = $connection -> prepare('SELECT id FROM survey_db.users WHERE username=? OR email=?'); //prepare statement
        if ($find_id === false) { //check if prepare failed
            $errors['find_id_prepare_error'] = 'An error occurred! Please try again!';
            $_SESSION['errors'] = $errors;
        }
        else {
            $find_id -> bind_param('ss',$value,$value);
            if ($find_id -> execute() === false) { //check if execute failed
                $errors['find_id_execute_error'] = 'An error occurred! Please try again!';
                $_SESSION['errors'] = $errors;
            }
            else {
                $result_id = $find_id -> get_result();
                if ($result_id -> num_rows > 0) { //check if result has more then 0 result
                    $row = mysqli_fetch_assoc($result_id);

                    if (isset($_POST['keep-me-logged-in'])) { //check if checkbox was submitted
                        setcookie('auto_login',$row['id'],time()+60*60*24*30,'/','',false,true); //create cookie with 30 days expiration
                        header('location: ../../index.php'); //redirect to login.php
                        exit(); //stop the script
                    }
                    else {
                        header('location: ../../index.php'); //redirect to login.php
                        exit(); //stop the script
                    }
                }
            }
            $find_id -> close(); //close statement
        }
    }
    $connection -> close(); //close connection
?>