document.querySelector('#title').addEventListener('input', function(){

    let titleInput = document.querySelector('#title').value

    if (titleInput !== "")
    {
        hideLabels("title")
    } else {
        document.querySelector('#survey-title-label').innerHTML = "*Required"
    }
})

// Calls the hide label function and
// shows the deadline div
showDeadline()

function showDeadline(){
    let surveyDeadline = document.querySelector('#survey-deadline')

    // If it still does not have a value or when creating a new survey
    if(!document.querySelector("input[name='surveyDeadline']:checked"))
    {
        document.querySelector('#yes').addEventListener('click', function(){
            surveyDeadline.style.display = "block"
        })

        document.querySelector('#no').addEventListener('click', function(){
            surveyDeadline.style.display = "none"
        })

        // If it has already a value or editing the survey
    } else {
        let showDeadline = document.querySelector("input[name='surveyDeadline']:checked").value
        
        document.querySelector('#yes').addEventListener('click', function(){
            surveyDeadline.style.display = "block"
        })
        document.querySelector('#no').addEventListener('click', function(){
            surveyDeadline.style.display = "none"
        })
    
        if (showDeadline === 'true')
        {
            surveyDeadline.style.display = "block"
        }

        if (showDeadline === 'false')
        {
            surveyDeadline.style.display = "none"

            document.querySelector('#no').addEventListener('click', function(){
                surveyDeadline.style.display = "none"
            })
        }

        let showDeadlineLabel = document.querySelector('#survey-deadline-label').innerHTML
        let surveyDate = document.querySelector('#surveyDeadline').value

        if (showDeadlineLabel !== "")
        {
            hideLabels("deadline")

            if (showDeadlineLabel === "true" && surveyDate !== null)
            {
                hideLabels("date")
            }
        }
    }
}

// Hides the required label if the user chose an option

document.querySelector('#private').addEventListener('click', function(){
    hideLabels("status")
})

document.querySelector('#public').addEventListener('click', function(){
    hideLabels("status")
})

function hideLabels(label)
{
    if (label === "title")
    {
        document.querySelector('#survey-title-label').innerHTML = ""
    }

    if (label === "deadline")
    {
        document.querySelector('#survey-deadline-label').innerHTML = ""
    }

    if (label === "status")
    {
        let statusLabel = document.querySelector('#survey-status-label').innerHTML

        if (statusLabel !== "")
        {
            document.querySelector('#survey-status-label').innerHTML = ""
        }
    }

    if (label === "status")
    {
        let dateLabel = document.querySelector('#survey-status-label').innerHTML

        if (dateLabel !== "")
        {
            document.querySelector('#survey-date-label').innerHTML = ""
        }
    }
}

// Checks if every required inputs has value
// if null, stops the form submition and shows labels 
document.querySelector('#submit').addEventListener('click', function(event){
    formChecker(event)
})

function formChecker(event)
{
    let surveyTitle = document.querySelector('#title').value
    let surveyDeadlineChecker = document.querySelector('input[name="surveyDeadline"]:checked')
    let surveyDate = document.querySelector('#surveyDeadline').value
    let surveyStatus = document.querySelector('input[name="surveyStatus"]:checked')

    if (surveyTitle === "")
    {
        document.querySelector('#survey-title-label').innerHTML = "*Required"
        event.preventDefault();
    }

    if (surveyDeadlineChecker === null)
    {
        document.getElementById("survey-deadline-label").innerText = "*Required"
        event.preventDefault();
    }

    if (surveyDeadlineChecker.value === 'true' && surveyDate === '')
    {
        document.getElementById("survey-date-label").innerText = "*Required"
        event.preventDefault();
    }

    if (surveyStatus === null)
    {
        document.getElementById("survey-status-label").innerText = "*Required"
        event.preventDefault();
    }
}