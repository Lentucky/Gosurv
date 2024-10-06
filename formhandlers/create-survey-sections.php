<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    session_start();
    include_once('../config/connection.php');
    $sectionName = $_POST['sectionTitle'];

    $insertQuery = $connection -> prepare('INSERT INTO surveySections (surveyId, sectionName) VALUES (?, ?);');
    $insertQuery -> bind_param('is', $_SESSION['surveyId'], $sectionName);
    $insertQuery -> execute();
    $insertQuery -> close();

    $selectSectionId = $connection -> prepare('SELECT max(id) as maxId FROM surveySections WHERE surveyId = ?');
    $selectSectionId -> bind_param('i', $_SESSION['surveyId']);
    $selectSectionId -> execute();
    $getSectionId = $selectSectionId -> get_result();
    $resultSectionId = mysqli_fetch_assoc($getSectionId);

    $selectSectionName = $connection -> prepare('SELECT * FROM surveySections WHERE id = ?');
    $selectSectionName -> bind_param('i', $resultSectionId['maxId']);
    $selectSectionName -> execute();
    $getSectionName = $selectSectionName -> get_result();
    $resultSectionName = mysqli_fetch_assoc($getSectionName);
    
    $section = array();
    $section[$resultSectionName['sectionName']] = $resultSectionId['maxId'];

    echo json_encode($section);
    $connection -> close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    session_start();
    include_once('../config/connection.php');

    $selectSection = $connection -> prepare('SELECT * FROM surveySections WHERE surveyId = ?');
    $selectSection -> bind_param('i', $_SESSION['surveyId']);
    $selectSection -> execute();
    $getSection = $selectSection -> get_result();

    $section = array();

    while ($rowSection = mysqli_fetch_assoc($getSection))
    {
        $section[$rowSection['sectionName']] = $rowSection['id'];
    }

    echo json_encode($section);
    $connection -> close();
    exit();
}