function login() {
    // Get input values
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    // Send login request to server
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('email=' + email + '&password=' + password);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('loginMessage').innerHTML = xhr.responseText;
                // Handle successful registration response
            } else {
                document.getElementById('loginMessage').innerHTML = xhr.responseText;
            }
        }
    };

}