<?php

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    session_start();
    include_once('../config/connection.php');
    $surveySectionId = $_POST['surveySection'];
    $question = $_POST['question'];
    $questionType = $_POST['questionType'];
    $questionSettings = null;

    if (isset($_POST['questionSettings']))
    {
        $questionSettings = true;
    } else {
        $questionSettings = false;
    }

    $insertQuestion = $connection -> prepare('INSERT INTO surveyQuestions (surveySectionId, surveyId, question, questionType, questionSettings) VALUES (?, ?, ?, ?, ?);');
    $insertQuestion -> bind_param('iissi', $surveySectionId,$_SESSION['surveyId'], $question, $questionType, $questionSettings);
    $insertQuestion -> execute();

    $insertQuestion ->  close();

    $selectQuestion = $connection -> prepare('SELECT MAX(id) as maxId FROM surveyQuestions WHERE surveySectionId = ? and surveyId = ?;');
    $selectQuestion -> bind_param('ii', $surveySectionId, $_SESSION['surveyId']);
    $selectQuestion -> execute();
    $getResult = $selectQuestion -> get_result();
    $rowResult = mysqli_fetch_assoc($getResult);

    if ($questionType === "CheckBox" || $questionType === "Multiple Choice")
    {
        $choices = $_POST['choice'];

        foreach ($choices as $choice)
        {
            $insertOptions = $connection -> prepare('INSERT INTO multipleOptions (questionId, options) VALUES (?, ?);');
            $insertOptions -> bind_param('is', $rowResult['maxId'], $choice);
            $insertOptions -> execute();
        }
        $getResult -> close();

    } else if ($questionType === "Rating Scale") {

        $minimumRadio = $_POST['min'];
        $maximumRadio = $_POST['max'];
        $leftLabel = $_POST['minText'];
        $rightLabel = $_POST['maxText'];

        $insertOptions = $connection -> prepare('INSERT INTO ratingScaleOptions (questionId, min, minText, max, maxText) VALUES (?, ?, ?, ?, ?);');
        $insertOptions -> bind_param('iisis', $rowResult['maxId'], $minimumRadio, $leftLabel,$maximumRadio, $rightLabel);
        $insertOptions -> execute();

        $getResult -> close();
    }

    $connection -> close();
    header('Location: ../survey.php');
    exit();
} else {
    header('Location: ../create-question.php');
    exit();
}

