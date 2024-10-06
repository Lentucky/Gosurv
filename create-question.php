<?php
include('partials/header.php');
?>

<body>
<h1 class="survey-h1">CREATE A NEW QUESTION</h1>

<div class="survey-container">
    <form action="./formhandlers/create-survey-questions.php" method="post">
        <input type="hidden" name="surveySection" value="<?php echo $_GET['id'] ?>">
        <table class="table survey-table">
            <tbody>
                <tr>
                    <td>
                        <div class="form-group mb-3">
                            <p>Question Title</p>
                            <label class="error-handler question-title"></label>
                            <input class="form-control" type="text" id="question" name="question" placeholder="Question...">
                        </div>
                            
                        <div class="form-group">
                            <p>Question Type</p>
                            <label class="error-handler question-type"></label>
                            <select class="form-select" id="question-selector" name="questionType" aria-label="Default select example">
                                <option value="none" selected>Open this select menu</option>
                                <option value="Rating Scale">Rating Scale</option>
                                <option value="CheckBox">CheckBox</option>
                                <option value="Multiple Choice">Multiple Choice</option>
                                <option value="Short Answer">Short Answer</option>
                                <option value="Paragraph">Paragraph</option>
                            </select>
                        </div>

                        <div id="option-container">

                        </div>

                        <input type="submit" id="submit" class="btn btn-new-survey" name="submitButton">
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="flex-container">
                            <a href="./survey.php"><button type="button" class="btn btn-danger">BACK</button></a>
                            <div class="form-check form-switch custom-switch">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Required</label>
                                <input class="form-check-input" type="checkbox" name="questionSettings" role="switch"  value="on" id="flexSwitchCheckDefault">
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
<script src="./js/create-question.js" defer></script>
<?php include('partials/footer.php');?>