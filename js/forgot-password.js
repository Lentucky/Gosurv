function checkEmail(email) {
    if (email.length === 0) { //check if value is empty
        document.getElementById('email-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) { //check if xml is ready
            document.getElementById('email-message').innerHTML = xml.responseText;
            submitButton();
        }
    }
    xml.open("GET","../formhandlers/login/check-email.php?email="+encodeURIComponent(email),true); //open a get request
    xml.send(); //send the request to the server
}

function submitButton() {
    const submit_button = document.getElementById('submit'); //retrieve values
    const email_message = document.getElementById('email-message').innerText;

    submit_button.disabled = (email_message != 'Email is registered!'); //disable if not equal
}

document.getElementById('form').addEventListener('submit', handleSubmit); //add event listener for form submission
function handleSubmit(event) {
    event.preventDefault(); //prevent the default behavior
}

function enableChangePassword() {
    document.getElementById('header').innerHTML = 'Enter New Password'; //change text
    
    const email_field = document.getElementById('email'); //retrieve elements
    const email_message = document.getElementById('email-message');
    const submit_button = document.getElementById('submit');
    email_field.style.display = 'none'; //hide email field
    email_message.remove(); //remove elements
    submit_button.remove();

    const password_field = document.createElement('input'); //create input element
    password_field.type = 'password'; 
    password_field.id = 'password';
    password_field.name = 'password';
    password_field.placeholder = 'New Password';
    password_field.onkeyup = function() { //create event handler
        checkPassword(this.value);
    }
    document.getElementById('form').appendChild(password_field); //include the created element in form

    const password_message = document.createElement('span'); //create span element
    password_message.id = 'password-message';
    document.getElementById('form').appendChild(password_message); //include the created element in form

    const form = document.getElementById('form'); //retrieve element
    form.insertBefore(password_message, password_field.nextSibling); //move the created element

    const confirm_password_field = document.createElement('input'); //create input element
    confirm_password_field.type = 'password';
    confirm_password_field.id = 'confirm-password';
    confirm_password_field.name = 'confirm-password';
    confirm_password_field.placeholder = 'Confirm New Password'
    confirm_password_field.onkeyup = function() { //create event handler
        document.getElementById('password').addEventListener('input', checkConfirmPassword); //create event handler for function checkConfirmPassword
        checkConfirmPassword();
    }
    document.getElementById('form').appendChild(confirm_password_field); //include the created element in form

    form.insertBefore(confirm_password_field, password_message.nextSibling); //move the created element

    const confirm_password_message = document.createElement('span'); //create span element
    confirm_password_message.id = 'confirm-password-message'; 
    document.getElementById('form').appendChild(confirm_password_message); //include the created element in form

    form.insertBefore(confirm_password_message, confirm_password_field.nextSibling); //move the created element

    const change_password_button = document.createElement('input'); //create input element
    change_password_button.type = 'submit';
    change_password_button.id = 'change-password-button';
    change_password_button.name = 'change-password-button';
    change_password_button.value = 'Change Password';
    change_password_button.disabled = true; //disable the created element
    change_password_button.onclick = function() { //create event handler
        changePassword();
    }
    document.getElementById('form').appendChild(change_password_button); //include the created element in form

    form.insertBefore(change_password_button, confirm_password_message.nextSibling); //move the created element
}

function checkPassword(password) {
    if (password.length === 0) { //check if password has no value
        document.getElementById('password-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) { //check if xml is ready
            document.getElementById('password-message').innerHTML = xml.responseText;
            changePasswordButton();
        }
    }
    xml.open('GET','../formhandlers/register/check-password.php?password='+encodeURIComponent(password),true); //open get request
    xml.send(); //send the request to the server
}

function checkConfirmPassword() {
    const password = document.getElementById('password').value; //retrieve the value in password field
    const confirm_password = document.getElementById('confirm-password').value; //retrieve the value in confirm-password field

    if (confirm_password.length === 0) { //check if there is no value
        document.getElementById('confirm-password-message').innerHTML = '';
        changePasswordButton();
        return
    }
    else if (confirm_password == password) { //check if confirm_password is the same as password
        document.getElementById('confirm-password-message').innerHTML = 'Password matched!';
        changePasswordButton();
        return
    }
    else {
        document.getElementById('confirm-password-message').innerHTML = 'Password do not matched!';
        changePasswordButton();
        return
    }
}

function changePasswordButton () {
    const change_password_button = document.getElementById('change-password-button'); //retrieve element
    const password_message = document.getElementById('password-message').innerText; //retrieve texts
    const confirm_password_message = document.getElementById('confirm-password-message').innerText;

    change_password_button.disabled = (password_message != 'Password is strong!' || confirm_password_message != 'Password matched!'); //disable if not equal
}

function changePassword() {
    document.getElementById('form').removeEventListener('submit', handleSubmit); //remove event listener for form submission
}