<?php
    require_once '../../config/connection.php'; //include connection.php once

    if (isset($_GET['password']) && isset($_GET['value'])) { //check if password is submitted
        $password = filter_var(trim($_GET['password']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim password
        $value = filter_var(trim($_GET['value']),FILTER_SANITIZE_FULL_SPECIAL_CHARS); //sanitize and trim value
        
        $find_password = $connection -> prepare('SELECT password FROM survey_db.users WHERE username=? OR email=?'); //prepare statement
        if ($find_password === false) { //check if prepare failed
            echo 'An error occurred! Please try again!';
        }
        else {
            $find_password -> bind_param('ss',$value,$value);
            if ($find_password -> execute() === false) { //check if execute failed
                echo 'An error occurred! Please try again!';
            }
            else {
                $result_password = $find_password -> get_result();
                if ($result_password -> num_rows > 0) { //check if there is more than 0 result
                    $row = mysqli_fetch_assoc($result_password);

                    if (password_verify($password,$row['password'])) { //verify password
                        echo 'Password matched!';
                    }
                    else {
                        echo 'Password do not matched!';
                    }   
                }
            }
            $find_password -> close(); //close statement
        }
    }
    $connection -> close(); //close connection
?>