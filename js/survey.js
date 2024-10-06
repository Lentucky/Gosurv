var i = 1;
var newDivAdded = 0;

const errorAdd = document.createElement('p');
errorAdd.textContent = "Please submit the new section first!";
errorAdd.style.color = 'red';
errorAdd.style.display = 'none';

const addSection = document.querySelector('#add-section');
addSection.addEventListener('click', function(){
    if (newDivAdded === 1)
    {
        let newSectionDiv = document.querySelector('#section-holder-' + i);
        errorAdd.style.display = 'block';
        console.log(i);
        newSectionDiv.appendChild(errorAdd);
    } else {
        newDivAdded++;
        addNewSection();
    }
});

const surveyHolder = document.querySelector('#survey-container');

function addNewSection()
{
    const newSectionDiv = document.createElement('div');
    const sectionInput = document.createElement('input');
    const submitBtn = document.createElement('button');
    const removeBtn = document.createElement('button');

    submitBtn.textContent = "Submit Section";
    removeBtn.textContent = "Remove Section";
    
    newSectionDiv.setAttribute("class", "section-holder");
    newSectionDiv.setAttribute("id", "section-holder-" + i);

    sectionInput.setAttribute("name", "sectionTitle");
    sectionInput.setAttribute("id", "section-title");
    sectionInput.setAttribute("class", "section-input");
    sectionInput.setAttribute("placeholder", "Input Section Title...");
    submitBtn.setAttribute("class", "section-button");
    submitBtn.setAttribute("id", "create-section");
    submitBtn.setAttribute("type", "button");

    surveyHolder.appendChild(newSectionDiv);
    newSectionDiv.appendChild(sectionInput);
    newSectionDiv.appendChild(submitBtn);
    newSectionDiv.appendChild(removeBtn);

    // When the button is clicked create a div input for section title
    submitBtn.addEventListener('click', function()
    {
        const errorLabel = document.createElement('p');
        errorLabel.setAttribute("class", "error-handlers")
        errorLabel.textContent = "*Please fill out the input!";
        // To hide the error handler, much better if it is styled in css
        errorLabel.style.display = 'none';
        errorLabel.style.color = 'red';
        newSectionDiv.appendChild(errorLabel);

        const sectionName = sectionInput.value;

        if (sectionName.trim() !== "")
        {
            $.post('./formhandlers/create-survey-questions.php', {
                sectionTitle: sectionName
            })

            .done(function(response)
            {
                const sections = JSON.parse(response);

                // For Each Created Section, creates div to show each section question
                Object.entries(sections).forEach(([sectionName, id]) => {
                    const sectionDiv = document.createElement('div');
                    const questionDiv = document.createElement('div');
                    const buttonDiv = document.createElement('div');
                    const sectionTitle = document.createElement('h4');
                    const anchor = document.createElement('a');
                    const addQuestion = document.createElement('button');
                    
                    sectionDiv.setAttribute('class', 'section-' + i)
                    sectionDiv.setAttribute('id', 'section-' + i)
                    anchor.setAttribute('href', './create-question.php?id=' + id);
                    
                    addQuestion.textContent = "Add Question";
                    sectionTitle.textContent = sectionName;

                    surveyHolder.appendChild(sectionDiv);
                    sectionDiv.appendChild(sectionTitle);
                    sectionDiv.appendChild(questionDiv);
                    sectionDiv.appendChild(buttonDiv);
                    anchor.appendChild(addQuestion)
                    buttonDiv.appendChild(anchor);
                })
            })
            newSectionDiv.remove();
            newDivAdded--;

            // If the submit section is clicked without input do the code block below
        } else {
            errorLabel.style.display = 'block';
        }
    });

    removeBtn.addEventListener('click', function(){
        newDivAdded--;
        newSectionDiv.remove();
    })
}

document.addEventListener('DOMContentLoaded', function(){
    $.get('./formhandlers/create-survey-sections.php', function(response){
        const sections = JSON.parse(response);

        Object.entries(sections).forEach(([sectionName, id]) => {
            const sectionDiv = document.createElement('div');

            const sectionTitle = document.createElement('h4');
            sectionTitle.textContent = sectionName;

            const addButtonDiv = document.createElement('div');
            addButtonDiv.setAttribute('class', 'button-question-container');

            const addQuestion = document.createElement('button');
            addQuestion.textContent = "Add Question";

            const anchor = document.createElement('a');
            anchor.setAttribute('href', './create-question.php?id=' + id);

            surveyHolder.appendChild(sectionDiv);
            sectionDiv.appendChild(sectionTitle);
            addButtonDiv.appendChild(anchor);
            anchor.appendChild(addQuestion);
            
            $.get('./formhandlers/show-survey-questions.php', {
                sectionId:id
            })
            .done(function(response){
                const questions = JSON.parse(response);

                Object.entries(questions).forEach(([questionId, questionDetails]) => {

                    const questionContainer = document.createElement('div');
                    questionContainer.setAttribute('class', 'question-container');

                    const question = document.createElement('h4');
                    question.textContent = questionDetails['question'];

                    const answerDiv = document.createElement('div');
                    answerDiv.setAttribute('class', 'answer-container-' + questionId);

                    const buttonDiv = document.createElement('div');
                    answerDiv.setAttribute('class', 'button-container-' + questionId);

                    // For each questions Edit and delete button
                    const editButton = document.createElement('button');
                    editButton.textContent = "Edit";
                    editButton.setAttribute('type', 'button');

                    const aEdit = document.createElement('a');
                    aEdit.setAttribute('href', './edit-question.php?q_id=' + questionId)

                    const DeleteButton = document.createElement('button');
                    DeleteButton.textContent = "Delete";
                    DeleteButton.setAttribute('type', 'button');

                    const aDelete = document.createElement('a');
                    aDelete.setAttribute('href', './formhandlers/delete-question.php?q_id=' + questionId)

                    buttonDiv.appendChild(aEdit);
                    aEdit.appendChild(editButton);
                    buttonDiv.appendChild(aDelete);
                    aDelete.appendChild(DeleteButton);

                    // Checks the question type part
                    if (questionDetails['questionType'] === "Multiple Choice" || questionDetails['questionType'] === "CheckBox")
                    {
                        x = 1;

                        // For each loop to create a new element for each options in the multiple choice and checkbox question type
                        questionDetails['options'].forEach(options => {
                            
                            const radioButton = document.createElement('input');
                            radioButton.setAttribute('type', 'radio');
                            radioButton.setAttribute('name', 'radio-button' + questionId);
                            radioButton.setAttribute('id', 'radio-button' + x);

                            const radioLabel = document.createElement('label');
                            radioLabel.textContent = options;
                            radioLabel.setAttribute('for', 'radio-button' + x);

                            answerDiv.appendChild(radioButton);
                            answerDiv.appendChild(radioLabel);
                            x++;
                        })

                    } else if (questionDetails['questionType'] === "Rating Scale") {
                        const labelContainer = document.createElement('div');
                        labelContainer.style.display = 'flex';
                        labelContainer.style.alignItems = 'center';

                        const leftLabel = document.createElement('label');
                        leftLabel.textContent = questionDetails['minText'];

                        const createTable = document.createElement('table');
                        createTable.style.border = 'none';
                        const tHead = document.createElement('thead');
                        const tHeadRow = document.createElement('tr');
                        
                        const tBody = document.createElement('thead');
                        const tBodyRow = document.createElement('tr');
                        
                        for (let i = questionDetails['min']; i <= questionDetails['max']; i++)
                        {
                            const tHeadData = document.createElement('td');
                            tHeadData.textContent = i;

                            const tBodyData = document.createElement('td');
                            
                            const radioButton = document.createElement('input');
                            radioButton.setAttribute('type', 'radio');
                            radioButton.setAttribute('name', 'radio-button' + questionId);
                            radioButton.setAttribute('id', 'radio-button' + i);

                            tHeadRow.appendChild(tHeadData);
                            tBodyRow.appendChild(tBodyData);
                            tBodyData.appendChild(radioButton);
                        }

                        const rightLabel = document.createElement('label');
                        rightLabel.textContent = questionDetails['maxText'];

                        answerDiv.appendChild(labelContainer);
                        labelContainer.appendChild(leftLabel);
                        labelContainer.appendChild(createTable);
                        createTable.appendChild(tHead);
                        createTable.appendChild(tBody);
                        tHead.appendChild(tHeadRow);
                        tBody.appendChild(tBodyRow);
                        labelContainer.appendChild(rightLabel);

                    } else if (questionDetails['questionType'] === "Short Answer") {
                        const textInput = document.createElement('input');
                        textInput.setAttribute('type', 'text');
                        textInput.setAttribute('name', 'text-area' + questionId);
                        textInput.setAttribute('placeholder', 'Short Answer Input...');

                        answerDiv.appendChild(textInput);

                    } else if (questionDetails['questionType'] === "Paragraph") {
                        const textAreaInput = document.createElement('textarea');
                        textAreaInput.setAttribute('name', 'text-area' + questionId);
                        textAreaInput.setAttribute('placeholder', 'Paragraph Answer Input...');

                        answerDiv.appendChild(textAreaInput);
                    }

                    sectionDiv.appendChild(questionContainer);
                    questionContainer.appendChild(question);
                    questionContainer.appendChild(answerDiv);
                    questionContainer.appendChild(buttonDiv);
                })

                sectionDiv.appendChild(addButtonDiv);
            })
        })
    })
})