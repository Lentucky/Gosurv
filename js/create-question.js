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

questionSelector.addEventListener('change', function(){

    const selectedType = document.querySelector('#question-selector').value;

    if (oldDiv != null)
        {
            oldDiv.remove();
            oldDiv = null;
            i = 1;
        }

    if (selectedType === 'CheckBox' || selectedType === 'Multiple Choice')
    {
        const optionHolder = document.createElement('div');

        const choiceContainer = document.createElement('div');
        choiceContainer.setAttribute('class', 'choice-container');
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

const optionsErrorHandler = document.createElement('p');
optionsErrorHandler.textContent = "Please fill all the inputs!";
optionsErrorHandler.style.color = "red";
optionsErrorHandler.style.display = "none";

submit.addEventListener('click', function(event){

    const titleValue = questionTitle.value;
    const selectorValue = questionSelector.value;

    if (titleValue === '')
    {
        questionTitleLabel.style.display = 'block'
        event.preventDefault();

    } else {
        questionTitleLabel.style.display = 'none'
    }

    if (selectorValue === 'none') {
        questionTypeLabel.style.display = 'block'
        event.preventDefault();

    } else {
        questionTypeLabel.style.display = 'none'
    }

    const choiceContainer = document.querySelector('.choice-container');
    
    if (selectorValue === 'CheckBox' || selectorValue === 'Multiple Choice') {
    
        choiceContainer.appendChild(optionsErrorHandler);

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

    } else if (selectorValue === "Rating Scale") {

        choiceContainer.appendChild(optionsErrorHandler);
        
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