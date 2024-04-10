/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file is the js for the login page which handles login functionality for customer seller/bidder.
*/
var xhr = false
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest()
} else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
}

function login() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = getData;
    xhr.send('email=' + email + '&password=' + password);
}

function getData() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        let response = xhr.responseText;
        if (response === 'success') {
            window.location.href = 'bidding.htm';
        } else {
            document.getElementById('loginMessage').innerHTML = response;
        }
    }
}

function resetFields() {
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('loginMessage').innerHTML = '';

}