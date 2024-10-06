<?php
    require_once '../../config/connection.php'; //include connection.php once

    if (isset($_GET['username'])) { //check if username is submitted
        $username = filter_var(trim($_GET['username']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim username

        if (strlen($username) < 3) { //check if string has less than 3 characters
            echo "Username is too short!";
        }
        if (empty($username)) { //check if username is empty
            echo 'Invalid Input';
        }

        if (strlen($username) >= 3 && !empty($username)) { //check if username has a valid num of characters and it's not empty
            $unique_username = $connection -> prepare('SELECT username FROM survey_db.users WHERE username=?'); //prepare statement
            if ($unique_username === false) { //check if prepare failed
                echo 'An error occurred! Please try again!';
            }
            else {
                $unique_username -> bind_param('s',$username);
                if ($unique_username -> execute() === false) { //check if execute failed
                    echo 'An error occurred! Please try again!';
                }
                else {
                    $result_username = $unique_username -> get_result();
                    if ($result_username -> num_rows > 0) { //check if there is results
                        echo "Username is taken!";
                    }
                    else {
                        echo "Username is available!";
                    }
                }
                $unique_username -> close(); //close statement
            }
        }
    }
    $connection -> close(); //connection
?>