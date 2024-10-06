function checkUsernameOREmail(value) {
    if (value.length === 0) { //check if there is no value
        document.getElementById('username/email-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) { //check if xml is ready
            document.getElementById('username/email-message').innerHTML = xml.responseText;
            submitButton(); //call function
        }
    }
    xml.open('GET','../formhandlers/login/check-username-or-email.php?value='+encodeURIComponent(value),true); //open a get request
    xml.send(); //send the request to the server
}

document.getElementById('username/email').addEventListener('input',checkPassword); //update username/email input
function checkPassword() {
    const value = document.getElementById('username/email').value; //retrieve values
    const password = document.getElementById('password').value; 
    
    if (password.length === 0) { //check if there is no value
        document.getElementById('password-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) { //check if xml is ready
            document.getElementById('password-message').innerHTML = xml.responseText;
            submitButton(); //call function
        }
    }
    xml.open('Get','../formhandlers/login/check-password.php?password='+encodeURIComponent(password)+'&value='+encodeURIComponent(value),true); //open a get request
    xml.send(); //send the request to the server
}

function submitButton() {
    const submit_button = document.getElementById('submit'); //retrieve values
    const value_message = document.getElementById('username/email-message').innerText;
    const password_message = document.getElementById('password-message').innerText; 

    const check_value_message = value_message == 'Username is registered!' || value_message == 'Email is registered!'; //check if one of the message if found

    submit_button.disabled = (check_value_message !== true || password_message != 'Password matched!'); //disable if not equal
}