/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file is the js for the listing page which handles categories and duration dropdown and lists the item in auction
*/

var xhr = false
if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest()
} else if (window.ActiveXObject) {
    xhr = new ActiveXObject("Microsoft.XMLHTTP")
}

document.addEventListener('DOMContentLoaded', function () {

    var categoryDropdown = document.getElementById('category');
    var newCategoryInput = document.getElementById('newCategory');
    var newCategoryLabel = document.getElementById('newCategoryLabel');


    // Function to fetch categories from auction.xml
    function fetchCategories() {
        xhr.open('GET', 'categories.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {

                var categories = xhr.responseText.split(','); // Split the response into an array
                if (categories != '') {
                    populateCategories(categories);
                }
            }
        };
        xhr.send();
    }

    // Populate categories dropdown with existing categories
    function populateCategories(categories) {
        for (var i = 0; i < categories.length; i++) {
            var category = categories[i];
            var option = document.createElement('option');
            option.value = category;
            option.textContent = category;
            categoryDropdown.appendChild(option);
        }
    }

    // Show/hide new category input based on selection
    categoryDropdown.addEventListener('change', function () {
        if (categoryDropdown.value === 'other') {
            newCategoryInput.style.display = 'block';
            newCategoryLabel.style.display = 'block';
        } else {
            newCategoryInput.style.display = 'none';
            newCategoryLabel.style.display = 'none';
        }
    });

    function populateDurationDropdowns() {
        var durationDaysSelect = document.getElementById("durationDays");
        var durationHoursSelect = document.getElementById("durationHours");
        var durationMinutesSelect = document.getElementById("durationMinutes");

        // Populate options for days
        for (var i = 0; i <= 30; i++) {
            var option = document.createElement("option");
            option.value = i;
            option.text = i;
            durationDaysSelect.appendChild(option);
        }

        // Populate options for hours (up to 24)
        for (var i = 0; i < 24; i++) {
            var optionHours = document.createElement("option");
            optionHours.value = i;
            optionHours.text = i;
            durationHoursSelect.appendChild(optionHours);
        }

        // Populate options for minutes (up to 60)
        for (var i = 0; i < 60; i++) {
            var optionMinutes = document.createElement("option");
            optionMinutes.value = i;
            optionMinutes.text = i;
            durationMinutesSelect.appendChild(optionMinutes);
        }
    }

    // Fetch categories upon page load
    fetchCategories();

    // Population Days, Hours and Minutes dropdown on page load
    populateDurationDropdowns();
});

function getListingOutput() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        document.getElementById('listingMessage').innerHTML = xhr.responseText;
    }
}

function handleListing(event) {
    var itemName = document.getElementById("itemName").value;
    var category = document.getElementById("category").value;

    if (category === 'other') {
        //If Other is selected then replacing the category value with the newCategory from input field
        category = document.getElementById("newCategory").value;
    }

    var description = document.getElementById("description").value;
    var reservePrice = document.getElementById("reservePrice").value;
    var buyItNowPrice = document.getElementById("buyItNowPrice").value;
    var startPrice = document.getElementById("startPrice").value;
    var durationDays = document.getElementById("durationDays").value;
    var durationHours = document.getElementById("durationHours").value;
    var durationMinutes = document.getElementById("durationMinutes").value;

    xhr.open("POST", "listing.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = getListingOutput;

    var data = "itemName=" + encodeURIComponent(itemName) +
        "&category=" + encodeURIComponent(category) +
        "&description=" + encodeURIComponent(description) +
        "&reservePrice=" + encodeURIComponent(reservePrice) +
        "&buyItNowPrice=" + encodeURIComponent(buyItNowPrice) +
        "&startPrice=" + encodeURIComponent(startPrice) +
        "&durationDays=" + encodeURIComponent(durationDays) +
        "&durationHours=" + encodeURIComponent(durationHours) +
        "&durationMinutes=" + encodeURIComponent(durationMinutes);

    xhr.send(data);
}

function resetFields() {
    document.getElementById('listingForm').reset();
    document.getElementById('listingMessage').innerHTML = '';

}
