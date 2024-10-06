<?php

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
    session_start();
    include_once('../config/connection.php');
    $sectionId = $_GET['sectionId'];

    // Select all question in the specific survey section
    $selectQuestion = $connection -> prepare('SELECT * FROM surveyQuestions WHERE surveyId = ? AND surveySectionId = ?');
    $selectQuestion -> bind_param('ii', $_SESSION['surveyId'], $sectionId);
    $selectQuestion -> execute();
    $getQuestion = $selectQuestion -> get_result();

    $questionArray = array();

    while($rowQuestion = mysqli_fetch_assoc($getQuestion))
    {
        if ($rowQuestion['questionType'] === "CheckBox" || $rowQuestion['questionType'] === "Multiple Choice")
        {
            $questionArray[$rowQuestion['id']] = array(
                'question' => $rowQuestion['question'],
                'questionType' => $rowQuestion['questionType'],
                'options' => array()                  );
    
                // Selects all option in its specific question
            $selectOption = $connection -> prepare('SELECT * FROM multipleOptions WHERE questionId = ?');
            $selectOption -> bind_param('i', $rowQuestion['id']);
            $selectOption -> execute();
            $getOption = $selectOption -> get_result();

            while($rowOptions = mysqli_fetch_assoc($getOption))
            {
                $questionArray[$rowQuestion['id']]['options'][] = $rowOptions['options'];
            }

        } else if ($rowQuestion['questionType'] === "Rating Scale") {

            $selectDetails = $connection -> prepare('SELECT * FROM ratingScaleOptions WHERE questionId = ?');
            $selectDetails -> bind_param('i', $rowQuestion['id']);
            $selectDetails -> execute();
            $getDetails = $selectDetails -> get_result();

            while ($rowDetails = mysqli_fetch_assoc($getDetails))
            {
                $questionArray[$rowQuestion['id']] = array(

                    'question' => $rowQuestion['question'],
                    'questionType' => $rowQuestion['questionType'],
                    'min' => $rowDetails['min'],
                    'minText' => $rowDetails['minText'],
                    'max' => $rowDetails['max'],
                    'maxText' => $rowDetails['maxText']
                                                        );
            }

        } else if ($rowQuestion['questionType'] === "Short Answer") {

            $questionArray[$rowQuestion['id']] = array(

                'question' => $rowQuestion['question'],
                'questionType' => $rowQuestion['questionType']
                                                    );

        } else if ($rowQuestion['questionType'] === "Paragraph") {

            $questionArray[$rowQuestion['id']] = array(

                'question' => $rowQuestion['question'],
                'questionType' => $rowQuestion['questionType']
                                                    );

        }
    }
    echo json_encode($questionArray);
    exit();

} else {
    header('Location: ../create-question.php');
    exit();
}