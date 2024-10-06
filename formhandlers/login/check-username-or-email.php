<?php
    require_once '../../config/connection.php'; //include connection.php once

    if (isset($_GET['value'])) { //check if value is submitted
        $value = filter_var(trim($_GET['value']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim value

        if (!empty($value) && filter_var($value,FILTER_VALIDATE_EMAIL)) { //check if the value is an email
            $find_email = $connection -> prepare('SELECT email FROM survey_db.users WHERE email=?'); //prepare statement
            if ($find_email === false) { //check if prepare failed
                echo 'An error occurred! Please try again!';
            }
            else {
                $find_email -> bind_param('s',$value);
                if ($find_email -> execute() === false) { //check if execute failed
                    echo 'An error occurred! Please try again!';
                }
                else {
                    $result_email = $find_email -> get_result();
                    if ($result_email -> num_rows > 0) { //check if there is results
                        echo "Email is registered!";
                    }
                    else {
                        echo "Email is not registered!";
                    }
                }
                $find_email -> close(); //close statement
            }
        }
        else if (!empty($value)) { //check if the value is an username
            $find_username = $connection -> prepare('SELECT username FROM survey_db.users WHERE username=?'); //prepare statement
            if ($find_username === false) { //check if prepare failed
                echo 'An error occurred! Please try again!';
            }
            else {
                $find_username -> bind_param('s',$value);
                if ($find_username -> execute() === false) { //check if execute failed
                    echo 'An error occurred! Please try again!';
                }
                else {
                    $result_username = $find_username -> get_result();
                    if ($result_username -> num_rows > 0) { //check if there is results
                        echo "Username is registered!";
                    }
                    else {
                        echo "Username is not registered!";
                    }
                }
                $find_username -> close(); //close statement
            }
        }
        else {
            echo 'Invalid Input';
        }   
    }
    $connection -> close(); //connection
?>