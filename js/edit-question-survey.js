// Gets the option div container in the html document
const optionContainer = document.querySelector('#option-container');

// Gets the question title input element container in the html document
const questionTitle = document.querySelector('#question');

// Gets the question label input element container in the html document
const questionSelector = document.querySelector('#question-selector');
const submit = document.querySelector('#submit');

const questionTitleLabel = document.querySelector('.question-title');
questionTitleLabel.textContent = "*Please fill up this field!"
questionTitleLabel.style.color = 'red'
questionTitleLabel.style.display = 'none'

const questionTypeLabel = document.querySelector('.question-type');
questionTypeLabel.textContent = "*Please choose an appropriate question type!"
questionTypeLabel.style.color = 'red'
questionTypeLabel.style.display = 'none'

var i = 1;
let oldDiv = null;

// When the content is loaded, get the details of the question
addEventListener('DOMContentLoaded', function(){

    // Gets the id in the url
    const getUrl = this.window.location.href;
    const objectUrl = new URL(getUrl);
    const q_id = objectUrl.searchParams.get('q_id');

    $.get('./formhandlers/edit-question-survey.php', {q_id:q_id},
        function(response){

            const questionChoices = JSON.parse(response);

            Object.entries(questionChoices).forEach(([q_id, questionDetails]) => {
                previousChoice(q_id, questionDetails);

                window.q_id = q_id;
                window.questionDetails = questionDetails;
            })
        }
    )

    // When the select value is changed, do this
    questionSelector.addEventListener('change', function(){

        const selectedType = document.querySelector('#question-selector').value;

        if (oldDiv != null)
            {
                oldDiv.remove();
                oldDiv = null;
                i = 1;
            }

        // Shows the previous Options if the previous question type is picked
        if (window.questionDetails['questionType'] === questionSelector.value)
        {
            previousChoice(window.q_id, window.questionDetails);

        }
        // Else create a new one
        else if (selectedType === 'CheckBox' || selectedType === 'Multiple Choice')
        {
            const optionHolder = document.createElement('div');
            
            const choiceContainer = document.createElement('div');
            oldDiv = optionHolder;

            const choice = document.createElement('input');
            choice.setAttribute('name', 'choice[]');
            choice.setAttribute('placeholder', 'Choice ' + i + '...');

            const addButtonDiv = document.createElement('div')

            const addButton = document.createElement('button');
            addButton.textContent = "Add New Option";
            addButton.setAttribute('type', 'button');
            addButtonDiv.setAttribute('id', 'add-question-div');

            optionContainer.appendChild(optionHolder);
            optionHolder.appendChild(choiceContainer);
            choiceContainer.appendChild(choice);
            optionHolder.appendChild(addButtonDiv);
            addButtonDiv.appendChild(addButton);

            addButton.addEventListener('click', function(){
                i++;
                const newDiv = document.createElement('div');
                const newChoice = document.createElement('input');
                const newDeleteButton = document.createElement('button');
                const newCloseImage = document.createElement('img');

                newChoice.setAttribute('name', 'choice[]');
                newChoice.setAttribute('placeholder', 'Choice ' + i + '...');
                newCloseImage.setAttribute('src', './img/cross.png');
                newCloseImage.setAttribute('alt', 'delete button');
                newDeleteButton.setAttribute('id', 'questionId-' + i);
                newDeleteButton.setAttribute('type', 'button');

                choiceContainer.appendChild(newDiv);
                newDiv.appendChild(newChoice);
                newDeleteButton.appendChild(newCloseImage);
                newDiv.appendChild(newDeleteButton);

                newDeleteButton.addEventListener('click', function(){
                    newDiv.remove();
                })
            })

        } else if (selectedType === "Rating Scale") {
            const choiceContainer = document.createElement('div');
            choiceContainer.setAttribute('class', 'choice-container');
            oldDiv = choiceContainer;

            const newDiv = document.createElement('div');
            
            const min = document.createElement('input');
            min.setAttribute('type', 'number');
            min.setAttribute('min', 1);
            min.setAttribute('value', 1);
            min.setAttribute('name', 'min');

            const numberLabel = document.createElement('label');
            numberLabel.textContent = "To";

            const max = document.createElement('input');
            max.setAttribute('max', 10);
            max.setAttribute('value', 2);
            max.setAttribute('type', 'number');
            max.setAttribute('name', 'max');

            const divLabel = document.createElement('div');

            const firstLabelDiv = document.createElement('div');
            const firstLabel = document.createElement('input');
            firstLabel.setAttribute('name', 'minText');
            firstLabel.setAttribute('placeholder', 'Start Label...');

            const secondLabelDiv = document.createElement('div');
            const secondLabel = document.createElement('input');
            secondLabel.setAttribute('name', 'maxText');
            secondLabel.setAttribute('placeholder', 'Second Label...');

            optionContainer.appendChild(choiceContainer);
            choiceContainer.appendChild(newDiv);
            newDiv.appendChild(min);
            newDiv.appendChild(numberLabel);
            newDiv.appendChild(max);
            choiceContainer.appendChild(divLabel);
            divLabel.appendChild(firstLabelDiv);
            divLabel.appendChild(secondLabelDiv);
            firstLabelDiv.appendChild(firstLabel);
            secondLabelDiv.appendChild(secondLabel);
        }
    })
})

function previousChoice(q_id, questionDetails)
{
    questionTitle.value = questionDetails['question'];

    const questionSettings = document.querySelector('#flexSwitchCheckDefault');

    const questionDelete = document.querySelector('#delete');
    questionDelete.setAttribute('href', './formhandlers/delete-question.php?q_id=' + q_id)

    if (questionDetails['questionSettings'] == true)
    {
        questionSettings.checked = true;
    }

    if (questionDetails['questionType'] === "Rating Scale")
    {
        const ratingScale = document.querySelector('#RatingScale');
        ratingScale.setAttribute('selected', 'selected');

    } else if (questionDetails['questionType'] === "CheckBox") {
        const CheckBox = document.querySelector('#CheckBox');
        CheckBox.setAttribute('selected', 'selected');

    } else if (questionDetails['questionType'] === "Multiple Choice") {
        const multipleChoice = document.querySelector('#MultipleChoice');
        multipleChoice.setAttribute('selected', 'selected');

    } else if (questionDetails['questionType'] === "Short Answer") {
        const shortAnswer = document.querySelector('#ShortAnswer');
        shortAnswer.setAttribute('selected', 'selected');

    } else if (questionDetails['questionType'] === "Paragraph") {
        const paragraph = document.querySelector('#Paragraph');
        paragraph.setAttribute('selected', 'selected');
    }

    const optionHolder = document.createElement('div');
    oldDiv = optionHolder;

    const choiceContainer = document.createElement('div');
    choiceContainer.setAttribute('class', 'choice-container');

    if (questionDetails['questionType'] === "CheckBox" || questionDetails['questionType'] === "Multiple Choice")
    {
        z = 0;
        questionDetails['choices'].forEach((choices) => {

            if (z === 0)
            {
                const choice = document.createElement('input');
                choice.setAttribute('name', 'choice[]');
                choice.setAttribute('value', choices);
                choiceContainer.appendChild(choice);
                z++;

            } else {
                z++;
                const newDiv = document.createElement('div');
                const choice = document.createElement('input');
                const deleteButton = document.createElement('button');
                const closeImage = document.createElement('img');

                choice.setAttribute('name', 'choice[]');
                choice.setAttribute('value', choices);
                closeImage.setAttribute('src', './img/cross.png');
                closeImage.setAttribute('alt', 'delete button');
                deleteButton.setAttribute('id', 'questionId-' + i);
                deleteButton.setAttribute('type', 'button');

                choiceContainer.appendChild(newDiv);
                newDiv.appendChild(choice);
                deleteButton.appendChild(closeImage);
                newDiv.appendChild(deleteButton);

                deleteButton.addEventListener('click', function(){
                    newDiv.remove();
                })
            }
        })

        const addButtonDiv = document.createElement('div')

        const addButton = document.createElement('button');
        addButton.textContent = "Add New Option";
        addButton.setAttribute('type', 'button');
        addButtonDiv.setAttribute('id', 'add-question-div');
    
        optionContainer.appendChild(optionHolder);
        optionHolder.appendChild(choiceContainer);
        optionHolder.appendChild(addButtonDiv);
        addButtonDiv.appendChild(addButton);
    
        addButton.addEventListener('click', function(){
            i++;
            const newDiv = document.createElement('div');
            const newChoice = document.createElement('input');
            const newDeleteButton = document.createElement('button');
            const newCloseImage = document.createElement('img');
    
            newChoice.setAttribute('name', 'choice[]');
            newChoice.setAttribute('placeholder', 'Choice ' + i + '...');
            newCloseImage.setAttribute('src', './img/cross.png');
            newCloseImage.setAttribute('alt', 'delete button');
            newDeleteButton.setAttribute('id', 'questionId-' + i);
            newDeleteButton.setAttribute('type', 'button');
    
            choiceContainer.appendChild(newDiv);
            newDiv.appendChild(newChoice);
            newDeleteButton.appendChild(newCloseImage);
            newDiv.appendChild(newDeleteButton);
    
            newDeleteButton.addEventListener('click', function(){
                newDiv.remove();
            })
        })

    } else if (questionDetails['questionType'] === "Rating Scale") {

        const newDiv = document.createElement('div');
        
        const min = document.createElement('input');
        min.setAttribute('type', 'number');
        min.setAttribute('min', 1);
        min.setAttribute('value', questionDetails['min']);
        min.setAttribute('name', 'min');

        const numberLabel = document.createElement('label');
        numberLabel.textContent = "To";

        const max = document.createElement('input');
        max.setAttribute('type', 'number');
        max.setAttribute('max', 10);
        max.setAttribute('value', questionDetails['max']);
        max.setAttribute('name', 'max');

        const divLabel = document.createElement('div');

        const firstLabelDiv = document.createElement('div');
        const firstLabel = document.createElement('input');
        firstLabel.setAttribute('name', 'minText');
        firstLabel.setAttribute('placeholder', 'Start Label...');
        firstLabel.setAttribute('value', questionDetails['minText']);

        const secondLabelDiv = document.createElement('div');
        const secondLabel = document.createElement('input');
        secondLabel.setAttribute('name', 'maxText');
        secondLabel.setAttribute('placeholder', 'Second Label...');
        secondLabel.setAttribute('value', questionDetails['maxText']);

        optionContainer.appendChild(optionHolder);
        optionHolder.appendChild(choiceContainer);
        choiceContainer.appendChild(newDiv);
        newDiv.appendChild(min);
        newDiv.appendChild(numberLabel);
        newDiv.appendChild(max);
        choiceContainer.appendChild(divLabel);
        divLabel.appendChild(firstLabelDiv);
        divLabel.appendChild(secondLabelDiv);
        firstLabelDiv.appendChild(firstLabel);
        secondLabelDiv.appendChild(secondLabel);

    }
}

const optionsErrorHandler = document.createElement('p');
optionsErrorHandler.textContent = "Please fill all the inputs!";
optionsErrorHandler.style.color = "red";
optionsErrorHandler.style.display = "none";

submit.addEventListener('click', function(event){

    const selectedType = document.querySelector('#question-selector').value;

    const titleValue = questionTitle.value;
    const selectorValue = questionSelector.value;

    const choiceContainer = document.querySelector('.choice-container');

    choiceContainer.appendChild(optionsErrorHandler);

    if (titleValue === '')
    {
        questionTitleLabel.style.display = 'block'
        event.preventDefault();

    } else {
        questionTitleLabel.style.display = 'none'
    }
    
    if (selectedType === 'CheckBox' || selectedType === 'Multiple Choice')
    {
        const getEmptyChoiceInput = document.querySelectorAll('input[name="choice[]"]');
        let isEmpty = false

        getEmptyChoiceInput.forEach((input) => {
            if (input.value.trim() === "")
            {
                isEmpty = true;
            }
        });

        if (isEmpty === true)
        {
            optionsErrorHandler.style.display = "block";
            event.preventDefault();
        } else {
            optionsErrorHandler.style.display = "none";
        }

    } else if (selectedType === "Rating Scale") {
        const max = document.querySelector('input[name="max"]').value;
        const min = document.querySelector('input[name="min"]').value;
        const minText = document.querySelector('input[name="minText"]').value;
        const maxText = document.querySelector('input[name="maxText"]').value;

        if (max === "" || min === "" || minText === "" || maxText === "")
        {
            optionsErrorHandler.style.display = "block";
            event.preventDefault();
        } else {
            optionsErrorHandler.style.display = "none";
        }
    }
})