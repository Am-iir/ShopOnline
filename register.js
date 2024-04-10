/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file is the js for the register page which handles registration functionality for customer seller/bidder.
*/

var xhr = false
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest()
} else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
}

function registerUser() {

    let firstName = document.getElementById('firstName').value;
    let surname = document.getElementById('surname').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirmPassword').value;

    xhr.open('POST', 'register.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = getRegisterData;
    xhr.send(`firstName=${encodeURIComponent(firstName)}&surname=${encodeURIComponent(surname)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirmPassword=${encodeURIComponent(confirmPassword)}`);

}

function getRegisterData() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        let response = xhr.responseText;
        if (response === 'success') {
            window.location.href = 'bidding.htm';
        } else {
            document.getElementById('registrationMessage').innerHTML = response;
        }
    }
}


function resetFields() {
    document.getElementById('registrationForm').reset();
    document.getElementById('registrationMessage').innerHTML = '';
}




