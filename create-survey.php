<?php
include('partials/header.php');
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

<h1 class="form-h1">CREATE A NEW SURVEY</h1>
<div class="form-container">
    <form action="./formhandlers/createSurveyDetails.php" method="post">
        <div class="form-group mb-5">
        <label>SURVEY TITLE</label>
            <p class="error-handlers" id="survey-title-label"></p>
            <input class="form-control" type="text" id="title" name="surveyTitle" placeholder="Enter Title..." value="<?php if(isset($_SESSION['surveyId'])){echo $rowDetails['title'];} ?>">
        </div>
        
        <div class="form-group mb-5">
            <label>DESCRIPTION</label>
            <textarea class="form-control" name="surveyDesc"  id="description" rows="3" placeholder="Enter Description..."><?php if(isset($_SESSION['surveyId'])){echo $rowDetails['description'];} ?></textarea>
        </div>
    
        <div class="form-group flex-container mb-7">
            <!-- First Radio Button Group -->
            <div class="radio-des">
                <label>ADD A DEADLINE</label>
                <p class="error-handlers" id="survey-deadline-label"></p>
                <div class="form-check form-check-inline radio-check">
                    <input class="form-check-input custom-radio" type="radio" name="surveyDeadline" id="yes" value="true" <?php if(isset($_SESSION['surveyId'])){if($rowDeadline['deadline'] !== null){echo "checked";}} ?>>
                    <label for="yes" class="form-check-label">Yes</label>

                    <input class="form-check-input custom-radio" type="radio" name="surveyDeadline" id="no" value="false" <?php if(isset($_SESSION['surveyId'])){if($rowDeadline['deadline'] === null){echo "checked";}} ?>>
                    <label for="no" class="form-check-label">No</label>
                </div>
            </div>

            <!-- Second Radio Button Group -->
            <div class="radio-des">
                <label>SURVEY STATUS</label>
                <p class="error-handlers" id="survey-status-label"></p>
                <div class="form-check form-check-inline radio-check">
                    <input class="form-check-input custom-radio" type="radio" name="surveyStatus" id="public" value="PUBLIC" <?php if(isset($_SESSION['surveyId'])){if($rowDetails['surveySettings'] === "PUBLIC"){echo "checked";}} ?>>
                    <label for="public" class="form-check-label">PUBLIC</label>

                    <input class="form-check-input custom-radio" type="radio" name="surveyStatus" id="private" value="PRIVATE" <?php if(isset($_SESSION['surveyId'])){if($rowDetails['surveySettings'] === "PRIVATE"){echo "checked";}} ?>>
                    <label class="form-check-label">PRIVATE</label>
                </div>
            </div>
        </div>
    
        <div class="form-group mb-5"  id="survey-deadline">
            <label>SURVEY DEADLINE</label>
            <p class="error-handlers" id="survey-date-label"></p>
            <input type="datetime-local" id="surveyDeadline" name="surveyDate"  value="<?php if(isset($_SESSION['surveyId'])){echo $rowDeadline['deadline'];} ?>">
        </div>
        
        <input type="submit" id="submit" class="btn btn-new-survey">
    
    </form>
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'L LT' // 'L' is the date format, 'LT' is the time format
        });
    });
</script>
<script src="./js/create-survey.js" defer></script>
<?php include('partials/footer.php');?>