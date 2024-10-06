<?php

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    session_start();
    include_once('../config/connection.php');
    // 1 for now but will get it using session/cookie
    $uId = 1;
    $surveyTitle = $_POST['surveyTitle'];
    $surveyDesc = $_POST['surveyDesc'];
    $surveyDeadline = $_POST['surveyDeadline'];
    $surveyStatus = $_POST['surveyStatus'];

    // If Survey title and Survey status is empty then redirect to create survey details
    if (!empty($surveyTitle) && !empty($surveyStatus))
    {
        // If surveyId session exists update the values
        // If not create a new values
        if (isset($_SESSION['surveyId']))
        {
            $updateQuery = $connection -> prepare('UPDATE surveys set surveySettings = ?, title = ?, description = ? WHERE id = ?;');
            $updateQuery -> bind_param('sssi', $surveyStatus, $surveyTitle, $surveyDesc, $_SESSION['surveyId']);
            $updateQuery -> execute();
            $updateQuery -> close();

            // If it has a deadline update, if not update to null
            if ($surveyDeadline === "true")
            {
                $surveyDate = $_POST['surveyDate'];

                $updateQuery = $connection -> prepare("UPDATE surveyDeadlines set deadline = ? WHERE surveyId = ?;");
                $updateQuery -> bind_param('si', $surveyDate, $_SESSION['surveyId']);
                $updateQuery -> execute();
                $updateQuery -> close();
                
            } else {
                $null = null;

                $deleteQuery = $connection -> prepare('UPDATE surveyDeadlines set deadline = ? WHERE surveyId = ?');
                $deleteQuery -> bind_param('si', $null, $_SESSION['surveyId']);
                $deleteQuery -> execute();
                $deleteQuery -> close();
            }

        // If sessions has not been created, create a new survey
        } else {
            
            $insertQuery = $connection -> prepare("INSERT INTO surveys (userId, title, description, surveySettings) VALUES (?, ?, ?, ?)");
            $insertQuery -> bind_param('isss', $uId, $surveyTitle, $surveyDesc, $surveyStatus);
            $insertQuery -> execute();
            $insertQuery -> close();

            $selectQuery = $connection -> prepare("SELECT MAX(id) as maxID FROM surveys where userId = ?;");
            $selectQuery -> bind_param('i', $uId);
            $selectQuery -> execute();

            $getResult = $selectQuery -> get_result();
            $row = mysqli_fetch_assoc($getResult);

            $_SESSION['surveyId'] = $row['maxID'];
            $selectQuery -> close();

            if ($surveyDeadline === "true")
            {
                $surveyDate = $_POST['surveyDate'];

                $insertQuery = $connection -> prepare("INSERT INTO surveyDeadlines (surveyId, deadline) VALUES (?, ?)");
                $insertQuery -> bind_param('is', $_SESSION['surveyId'], $surveyDate);
                $insertQuery -> execute();
                $insertQuery -> close();

            } else {
                $surveyDate = null;

                $insertQuery = $connection -> prepare("INSERT INTO surveyDeadlines (surveyId, deadline) VALUES (?, ?)");
                $insertQuery -> bind_param('is', $_SESSION['surveyId'], $surveyDate);
                $insertQuery -> execute();
                $insertQuery -> close();
            }
        }

        $connection -> close();
        header('Location: ../survey.php');
        exit();
    }
    else {
    header("Location: ../create-survey.php");
    }

} else {
    header("Location: ../create-survey.php");
}