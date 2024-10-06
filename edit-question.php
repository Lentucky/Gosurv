<?php
include('partials/header.php');

?>

<body>
<h1 class="survey-h1">EDIT QUESTION</h1>

<div class="survey-container">
    <form action="./formhandlers/edit-question-survey.php" method="post">
        <input type="hidden" name="surveyQuestion" value="<?php echo $_GET['q_id'] ?>">
        <table class="table survey-table">
            <tbody>
                <tr>
                    <td>
                        <div class="form-group mb-3">
                            <label>Question Title</label>
                            <label class="error-handler question-title"></label>
                            <input class="form-control" type="text" id="question" name="question" placeholder="Question...">
                        </div>
                            
                        <div class="form-group">
                            <label>Question Type</label>
                            <label class="error-handler question-type"></label>
                            <select class="form-select" id="question-selector" name="questionType" aria-label="Default select example">
                                <option id="RatingScale" value="Rating Scale">Rating Scale</option>
                                <option value="CheckBox" id="CheckBox">CheckBox</option>
                                <option value="Multiple Choice" id="MultipleChoice">Multiple Choice</option>
                                <option value="Short Answer" id="ShortAnswer">Short Answer</option>
                                <option value="Paragraph" id="Paragraph">Paragraph</option>
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
                            <a id="delete"><input type="button" value="DELETE" class="btn btn-danger"></a>
                            <div class="form-check form-switch custom-switch">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Required</label>
                                <input class="form-check-input" type="checkbox" name="questionSettings" value="on" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-primary">BACK</button>
    </form>
</div>
</body>
<script src="./js/edit-question-survey.js" defer></script>
<?php include('partials/footer.php');?>