<?php

session_start();
include_once('./config/connection.php');

$selectDetails = $connection -> prepare('SELECT * FROM surveys WHERE id = ?');
$selectDetails -> bind_param('i', $_SESSION['surveyId']);
$selectDetails -> execute();

$getDetails = $selectDetails -> get_result();
$resultDetails = mysqli_fetch_assoc($getDetails);

$selectDeadlines = $connection -> prepare('SELECT * FROM surveyDeadlines WHERE surveyId = ?');
$selectDeadlines -> bind_param('i', $_SESSION['surveyId']);
$selectDeadlines -> execute();

$getDeadline = $selectDeadlines -> get_result();
$resultDeadline = mysqli_fetch_assoc($getDeadline);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $resultDetails['title']; ?></title>
    <link rel="stylesheet" href="./css/createSurveyQuestions.css">
    <script src="./js/createSurveyQuestions.js" defer></script>
</head>
<body>
    <main>
        <div class="header">
            <h1>CREATE A NEW SURVEY</h1>
        </div>
        <div class="detail-holder">
            <div class="detail-header">
                <h1><?php echo $resultDetails['title']; ?></h1>
            </div>
            <div>
                <div class="body">
                    <div class="description">
                        <p>Description:</p>
                        <p><?php echo $resultDetails['description']; ?></p>
                    </div>

                    <div class="survey-settings">
                        <div class="deadline settings">
                            <p>Deadline:</p>
                            <p><?php if(empty($resultDeadline['deadline'])){ echo "No Deadline"; }else{echo $resultDeadline['deadline'];} ?></p>
                        </div>
                        <div class="status settings">
                            <p>Status:</p>
                            <p><?php echo $resultDetails['surveySettings']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <a href="./createSurveyDetails.php"><button>Edit Details</button></a>
                </div>
            </div>
        </div>

        <form action="./formhandlers/createSurveyQuestions.php" method="post">
            <div id="survey-holder"></div>
        </form>

        <div class="buttons">
            <button id="add-section">Add Section</button>
            <button id="add-question">Add Question</button>
            <div class="survey-submit">
                <button>Post Survey</button>
                <button>Delete Survey</button>
            </div>
        </div>
    </main>
</body>
</html>