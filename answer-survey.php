<?php
include('partials/header.php');
?>

<body>
<h1 class="survey-h1">Survey Name</h1>

<div class="survey-display">
    <div class="survey-details">
        <h1>Survey Name</h1>
        <h2>Created by User name</h2>
        <h3>Description</h3>
        <h3>Deadline</h3>
    </div>

    <div>
        <button class="btn btn-danger">Report</button>
    </div>

</div>



<div class="survey-container">
<h1>Section</h1>

    <table class="table survey-table">
        <tbody>
            <tr>
                <td>
                    <div class="flex-container survey-question">
                        <h2>Question Title</h2>
                        <h3>*Required</h3>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group mb-3 survey-question">
                        <p>Dito lalagay ang Question</p>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="flex-container survey-question">
                        <h2>Question Title</h2>
                        <h3>*Required</h3>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="form-group mb-3 survey-question">
                        <p>Dito lalagay ang Question</p>
                </td>
            </tr>
        </tbody>
    </table>

</div>

</body>
<script src="./js/create-question.js" defer></script>
<?php include('partials/footer.php');?>