/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file is the js for the bidding page which listing the items, placing bid and buying item
*/

var xhr = false
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest()
} else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
}

function fetchItems() {
    // Function to fetch items and display them
    xhr.open('GET', 'items.php', true);
    xhr.onreadystatechange = getList;
    xhr.send();
}

function getList() {

    if (xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById('itemsContainer').innerHTML = xhr.responseText;
    }
}

// Fetch items upon page load
fetchItems();

// Refresh and Fetch items every 5 seconds
setInterval(fetchItems, 5000);


function placeBidPrompt(itemId) {
    // Function to Place Bid with prompt
    const newBidPrice = prompt("Enter your bid price for item ID " + itemId + ":");

    if (newBidPrice !== null) {
        // Check if newBidPrice is a valid number
        if (!isNaN(newBidPrice)) {
            if (newBidPrice > 0) {
                placeBid(itemId, newBidPrice);
            } else {
                alert("Please enter a valid bid price greater than zero.");
            }
        } else {
            alert("Please enter a valid numeric bid price.");
        }
    }
}

function placeBid(itemId, newBidPrice) {

    xhr.open('POST', 'placeBid.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            // Display the bid placed message with alert
            alert(xhr.responseText);

            // Refresh items after bid placement
            fetchItems();

        }
    };

    let data = "itemId=" + encodeURIComponent(itemId) + "&newBidPrice=" + encodeURIComponent(newBidPrice);

    xhr.send(data);
}

function buyItem(itemId) {

    xhr.open('POST', 'buyItem.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            alert(xhr.responseText);

            // Refresh items after purchase
            fetchItems();
        }
    };

    let params = 'itemId=' + encodeURIComponent(itemId);
    xhr.send(params);
}
