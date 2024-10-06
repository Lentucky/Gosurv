<?php
session_start();

if (isset($_SESSION['surveyId']))
{
    include_once('./config/connection.php');

    $selectDetails = $connection -> prepare('SELECT * FROM surveys where id = ?');
    $selectDetails -> bind_param('i', $_SESSION['surveyId']);
    $selectDetails -> execute();

    $getDetails = $selectDetails -> get_result();
    $rowDetails = mysqli_fetch_assoc($getDetails);

    $selectDeadlines = $connection -> prepare('SELECT * FROM surveyDeadlines where surveyId = ?');
    $selectDeadlines -> bind_param('i', $_SESSION['surveyId']);
    $selectDeadlines -> execute();

    $getDeadlines = $selectDeadlines -> get_result();
    $rowDeadline = mysqli_fetch_assoc($getDeadlines);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Surve Create Survey</title>
    <link rel="stylesheet" href="./css/createSurvey.css">
    <script src="./js/createSurveyDetails.js" defer></script>
</head>
<body>
    <main>
        <form action="./formhandlers/createSurveyDetails.php" method="post">
            <label for="title">SURVEY TITLE</label>

            <div class="card-holder">
                <p class="errors-handlers" id="survey-title-label"></p>
                <input type="text" id="title" name="surveyTitle" placeholder="Enter Title..." value="<?php if(isset($_SESSION['surveyId'])){echo $rowDetails['title'];} ?>">
            </div>

            <label id="label-description" for="description">DESCRIPTION</label>

            <div class="card-holder">
                <textarea name="surveyDesc" id="description" placeholder="Enter Description..."><?php if(isset($_SESSION['surveyId'])){echo $rowDetails['description'];} ?></textarea>
            </div>

            <div class="survey-status">
                <div class="deadline">
                    <div class="header-deadline">
                        <h1>SURVEY DEADLINE</h1>
                        <p class="errors-handlers" id="survey-deadline-label"></p>
                    </div>

                    <input type="radio" id="yes" name="surveyDeadline" value="true" <?php if(isset($_SESSION['surveyId'])){if($rowDeadline['deadline'] !== null){echo "checked";}} ?>>
                    <label for="yes">YES</label>

                    <input type="radio" id="no" name="surveyDeadline" value="false" <?php if(isset($_SESSION['surveyId'])){if($rowDeadline['deadline'] === null){echo "checked";}} ?>>
                    <label for="no">NO</label>
                </div>

                <div class="status">
                    <div class="header-status">
                        <h1>SURVEY STATUS</h1>
                        <p class="errors-handlers" id="survey-status-label"></p>
                    </div>

                    <input type="radio" id="public" name="surveyStatus" value="PUBLIC" <?php if(isset($_SESSION['surveyId'])){if($rowDetails['surveySettings'] === "PUBLIC"){echo "checked";}} ?>>
                    <label for="public">PUBLIC</label>

                    <input type="radio" id="private" name="surveyStatus" value="PRIVATE" <?php if(isset($_SESSION['surveyId'])){if($rowDetails['surveySettings'] === "PRIVATE"){echo "checked";}} ?>>
                    <label for="private">PRIVATE</label>
                </div>
            </div>

            <div class="survey-deadline" id="survey-deadline">
                <h1>SURVEY DEADLINE</h1>
                <input type="date" name="surveyDate" value="<?php if(isset($_SESSION['surveyId'])){echo $rowDeadline['deadline'];} ?>">
            </div>

            <button id="submit" type="submit">Submit</button>
        </form>
    </main>
</body>
</html>