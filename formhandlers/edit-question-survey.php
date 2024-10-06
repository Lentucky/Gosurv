<?php

include_once ('../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
    $q_id = $_GET['q_id'];

    $selectTitle = $connection -> prepare('SELECT * FROM surveyQuestions where id = ?;');
    $selectTitle -> bind_param('i', $q_id);
    $selectTitle -> execute();
    $titleObject = $selectTitle -> get_result();

    $questionRow = mysqli_fetch_assoc($titleObject);

    $questionArray = array();

    if ($questionRow['questionType'] === "CheckBox" || $questionRow['questionType'] === "Multiple Choice")
    {
        $questionArray[$questionRow['id']] = array(
            'question' => $questionRow['question'],
            'questionType' => $questionRow['questionType'],
            'questionSettings' => $questionRow['questionSettings'],
            'choices' => array()
        );

        $selectChoices = $connection -> prepare('SELECT * FROM multipleOptions WHERE questionId = ?');
        $selectChoices -> bind_param('i', $q_id);
        $selectChoices -> execute();

        $choicesObject = $selectChoices -> get_result();

        while($choiceRow = mysqli_fetch_assoc($choicesObject))
        {
            $questionArray[$questionRow['id']]['choices'][] = $choiceRow['options'];
        }

        echo json_encode($questionArray);
        $connection -> close();
        exit();

    } else if ($questionRow['questionType'] === "Rating Scale") {

        $selectChoices = $connection -> prepare('SELECT * FROM ratingScaleOptions WHERE questionId = ?');
        $selectChoices -> bind_param('i', $q_id);
        $selectChoices -> execute();

        $choicesObject = $selectChoices -> get_result();
        $choiceRow = mysqli_fetch_assoc($choicesObject);

        $questionArray[$questionRow['id']] = array(
            'question' => $questionRow['question'],
            'questionType' => $questionRow['questionType'],
            'questionSettings' => $questionRow['questionSettings'],
            'min' => $choiceRow['min'],
            'minText' => $choiceRow['minText'],
            'max' => $choiceRow['max'],
            'maxText' => $choiceRow['maxText'],
        );

        echo json_encode($questionArray);
        $connection -> close();
        exit();
    } else {

        $questionArray[$questionRow['id']] = array(
            'question' => $questionRow['question'],
            'questionType' => $questionRow['questionType'],
            'questionSettings' => $questionRow['questionSettings']
        );

        echo json_encode($questionArray);
        $connection -> close();
        exit();
    }

} else if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $q_id = $_POST['surveyQuestion'];
    $question = $_POST['question'];
    $questionType = $_POST['questionType'];

    if (isset($_POST['questionSettings']))
    {
        $questionSettings = true;
    } else {
        $questionSettings = false;
    }

    $selectQuestion = $connection -> prepare('SELECT * FROM surveyQuestions where id = ?;');
    $selectQuestion -> bind_param('i', $q_id);
    $selectQuestion -> execute();
    $getResult = $selectQuestion -> get_result();

    $questionRow = mysqli_fetch_assoc($getResult);

    if ($questionRow['questionType'] === "CheckBox" || $questionRow['questionType'] === "Multiple Choice")
    {
        $deleteChoices = $connection -> prepare('DELETE FROM multipleOptions where questionId = ?');
        $deleteChoices -> bind_param('i', $q_id);
        $deleteChoices -> execute();

    } else if ($questionRow['questionType'] === "Rating Scale") {
        $deleteChoices = $connection -> prepare('DELETE FROM ratingScaleOptions where questionId = ?');
        $deleteChoices -> bind_param('i', $q_id);
        $deleteChoices -> execute();

    }

    $updateDetails = $connection -> prepare('UPDATE surveyQuestions set question = ?, questionType = ?, questionSettings = ? WHERE id = ?;');
    $updateDetails -> bind_param('ssii', $question, $questionType, $questionSettings, $q_id);
    $updateDetails -> execute();

    if ($questionType === "CheckBox" || $questionType === "Multiple Choice")
    {
        $choices = $_POST['choice'];

        foreach ($choices as $choice)
        {
            $insertOptions = $connection -> prepare('INSERT INTO multipleOptions (questionId, options) VALUES (?, ?);');
            $insertOptions -> bind_param('is', $q_id, $choice);
            $insertOptions -> execute();
        }
        $getResult -> close();

    } else if ($questionType === "Rating Scale") {

        $minimumRadio = $_POST['min'];
        $maximumRadio = $_POST['max'];
        $leftLabel = $_POST['minText'];
        $rightLabel = $_POST['maxText'];

        $insertOptions = $connection -> prepare('INSERT INTO ratingScaleOptions (questionId, min, minText, max, maxText) VALUES (?, ?, ?, ?, ?);');
        $insertOptions -> bind_param('iisis', $q_id, $minimumRadio, $leftLabel,$maximumRadio, $rightLabel);
        $insertOptions -> execute();

        $getResult -> close();
    }

    $connection -> close();
    header('Location: ../survey.php');
    exit();
}