<?php
    require_once '../../config/connection.php'; //include connection.php once

    if (isset($_GET['email'])) { //check if email is submitted
        $email = filter_var(trim($_GET['email']),FILTER_SANITIZE_EMAIL); //sanitize and filter email

        if (empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)) { //check if email is empty or is not an email
            echo 'Invalid Input!';
        }

        if (!empty($email) && filter_var($email,FILTER_VALIDATE_EMAIL)) { //check if email is not empty and an email
            $unique_email = $connection -> prepare('SELECT email FROM survey_db.users WHERE email =?'); //prepare statement
            if ($unique_email === false) { //check if prepare failed
                echo 'An error occurred! Please try again!';
            }
            else {
                $unique_email -> bind_param('s',$email);
                if ($unique_email -> execute() === false) { //check if execute failed
                    echo 'An error occurred! Please try again!';
                }
                else {
                    $result_email = $unique_email -> get_result(); 
                    if ($result_email -> num_rows > 0) { //check if there is results
                        echo 'Email is taken!';
                    }
                    else {
                        echo 'Email is available!';
                    }
                }
                $unique_email -> close(); //close statement
            }
        }
    }
    $connection -> close(); //close connection
?>