/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file is the js for the logout
*/
var xhr = false
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest()
} else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
}

function logout() {

    xhr.open('GET', 'logout.php', true);
    xhr.onreadystatechange = handleLogout;
    xhr.send();
}

function handleLogout() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        window.location.href = "login.htm"
    }
}