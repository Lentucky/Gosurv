<?php
include('partials/header.php');

session_start();
include_once('./config/connection.php');

// Select Details
$selectDetails = $connection -> prepare('SELECT * FROM surveys WHERE id = ?');
$selectDetails -> bind_param('i', $_SESSION['surveyId']);
$selectDetails -> execute();

$getDetails = $selectDetails -> get_result();
$resultDetails = mysqli_fetch_assoc($getDetails);

// Select Deadlines
$selectDeadlines = $connection -> prepare('SELECT * FROM surveyDeadlines WHERE surveyId = ?');
$selectDeadlines -> bind_param('i', $_SESSION['surveyId']);
$selectDeadlines -> execute();

$getDeadline = $selectDeadlines -> get_result();
$resultDeadline = mysqli_fetch_assoc($getDeadline);

?>

<body>
    <h1 class="survey-h1">CREATE A NEW SURVEY</h1>

    <div class="survey-container">
        <table class="table survey-table">
            <tbody>
                <tr>
                    <td>
                        <h1>Survey Title <?php echo $resultDetails['title']; ?></h1>
                        <h2>Description</h2>
                        <p><?php echo $resultDetails['description']; ?></p>
                        <h3>Deadline: <?php if(empty($resultDeadline['deadline'])){ echo "No Deadline"; }else{echo $resultDeadline['deadline'];} ?></h3>

                        <h3>Status: <?php echo $resultDetails['surveySettings']; ?></h3>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="./create-survey.php"><button class="btn btn-new-survey">Edit Details</button></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="survey-container">

        </div>  

        <div class="survey-buttons" id="survey-buttons">
            <button id="add-section" class="btn btn-view">ADD SECTION</button>
            <div class="flex-container">
                <button class="btn btn-new-survey">POST SURVEY</button>
                <a href=""><input type="button" class="btn btn-danger" value="DELETE SURVEY"></a>
            </div>
        </div>
    </div>
</body>
<script src="./js/survey.js" defer></script>
<?php include('partials/footer.php');?>