function checkUsername(username) {
    if (username.length === 0) { //checks if the username field has no input
        document.getElementById('username-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest(); /*XMLHttpRequest = can be used to exchange data with a web server behind the scenes. 
    This means that it is possible to update parts of a web page, without reloading the whole page.*/
    xml.onreadystatechange = function() { //defines a function to be called when the readyState property changes
        if (xml.readyState === 4 && xml.status === 200) { //readyState holds the status of the XMLHttpRequest, status returns the status-number of a request
            document.getElementById('username-message').innerHTML = xml.responseText; //output message, responseText data can be found in check-username.php
            submitButton();
        }
    }
    xml.open("GET","../formhandlers/register/check-username.php?username="+encodeURIComponent(username),true); /*specifies the request, true = asynchronous, Asynchronous requests allow multiple requests to be made simultaneously, 
    improving overall performance and responsiveness of web applications,
    encodeURIComponent is a built-in JavaScript function used to encode a URI (Uniform Resource Identifier) component by escaping special characters.*/
    xml.send(); //sends the request to the server
}

function checkEmail(email) {
    if (email.length === 0) {
        document.getElementById('email-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) {
            document.getElementById('email-message').innerHTML = xml.responseText;
            submitButton();
        }
    }
    xml.open("GET","../formhandlers/register/check-email.php?email="+encodeURIComponent(email),true);
    xml.send();
}

function checkPassword(password) {
    if (password.length === 0) {
        document.getElementById('password-message').innerHTML = '';
        return
    }

    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if (xml.readyState === 4 && xml.status === 200) {
            document.getElementById('password-message').innerHTML = xml.responseText;
            submitButton();
        }
    }
    xml.open('GET','../formhandlers/register/check-password.php?password='+encodeURIComponent(password),true);
    xml.send();
}

document.getElementById('password').addEventListener('input', checkConfirmPassword); /*real-time update of password input,
the first argument, 'input', specifies the type of event to listen for, the 'input' event fires whenever the value of the password field changes, it executes the function to update the value*/
function checkConfirmPassword() {
    const password = document.getElementById('password').value; //retrieve the value in password field
    const confirm_password = document.getElementById('confirm-password').value; //retrieve the value in confirm-password field

    if (confirm_password.length === 0) {
        document.getElementById('confirm-password-message').innerHTML = '';
        return
    }
    else if (confirm_password == password) { //check if confirm_password is the same as password
        document.getElementById('confirm-password-message').innerHTML = 'Password matched!';
        submitButton();
        return
    }
    else {
        document.getElementById('confirm-password-message').innerHTML = 'Password do not matched!';
        submitButton();
        return
    }
}

function submitButton() {
    const submit_button = document.getElementById("submit"); //retrieve the submit button
    const username_message = document.getElementById("username-message").innerText; //retrieve the output
    const email_message = document.getElementById("email-message").innerText;
    const password_message = document.getElementById("password-message").innerText;
    const confirm_password_message = document.getElementById("confirm-password-message").innerText;
    
    submit_button.disabled = (username_message != 'Username is available!' || email_message != 'Email is available!' || password_message != 'Password is strong!' || confirm_password_message != 'Password matched!'); //disable if one of the messages is not equal
}
