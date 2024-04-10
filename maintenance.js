/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file is the js for the maintenance page for process auction and generate report.
*/

var xhr = false
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest()
} else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
}

function processAuctionItems() {
    xhr.open("GET", "processAuctionItems.php", true);
    xhr.onreadystatechange = getMaintenanceData;
    xhr.send();
}

function generateReport() {

    xhr.open("GET", "generateReport.php", true);
    xhr.onreadystatechange = getMaintenanceData;
    xhr.send();
}

function getMaintenanceData() {

    if (xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById('maintenanceMessage').innerHTML = xhr.responseText;
    }
}
