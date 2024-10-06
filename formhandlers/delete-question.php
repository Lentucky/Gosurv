<?php

if (isset($_GET['q_id']))
{
    include_once('../config/connection.php');
    session_start();
    
    $questionId = $_GET['q_id'];

    $selectQuery = $connection -> prepare("SELECT * FROM surveyQuestions WHERE id = ?");
    $selectQuery -> bind_param('i', $questionId);
    $selectQuery -> execute();
    $getResult = $selectQuery -> get_result();

    while ($row = mysqli_fetch_assoc($getResult))
    {

        $selectResults = $connection -> prepare("SELECT * FROM surveyReports WHERE surveyId = ? and questionId = ? limit 1;");
        $selectResults -> bind_param('ii', $_SESSION['surveyId'], $questionId);
        $selectResults -> execute();
        $getQuestionResults = $selectResults -> get_result();

        $rowResults = mysqli_fetch_assoc($getQuestionResults);

        if (mysqli_num_rows($getQuestionResults) > 0)
        {
            $deleteResults = $connection -> prepare("DELETE FROM surveyReports where questionId = ?");
            $deleteResults -> bind_param('i', $questionId);
            $deleteResults -> execute();
        }

        if ($row['questionType'] === "Rating Scale") {

            $deleteOptions = $connection -> prepare('DELETE FROM ratingScaleOptions where questionId = ?');
            $deleteOptions -> bind_param('i', $questionId);
            $deleteOptions -> execute();

        } else if ($row['questionType'] === "Multiple Choice" || $row['questionType'] === "CheckBox") {

            $deleteOptions = $connection -> prepare('DELETE FROM multipleOptions where questionId = ?');
            $deleteOptions -> bind_param('i', $questionId);
            $deleteOptions -> execute();
        }

        $deleteQuestions = $connection -> prepare('DELETE FROM surveyQuestions where surveySectionId = ? and id = ? and surveyId = ?');
        $deleteQuestions -> bind_param('iii', $row['surveySectionId'] ,$questionId, $_SESSION['surveyId']);
        $deleteQuestions -> execute();

        $getResult -> close();
        $getQuestionResults -> close();
        $connection -> close();

        header('Location: ../survey.php');
        exit();
    }
}