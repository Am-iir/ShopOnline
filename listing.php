<?php

/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file creates the listing based on the given item data and adds to auction.xml
*/

session_start();

// Check if the user is logged in
if (!isset($_SESSION['customerId'])) {

    echo "Please login first to add items";

} else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $itemName = $_POST["itemName"];
        $category = $_POST["category"];
        $description = $_POST["description"];
        $reservePrice = $_POST["reservePrice"];
        $buyItNowPrice = $_POST["buyItNowPrice"];
        $startPrice = $_POST["startPrice"];
        $durationDays = $_POST["durationDays"];
        $durationHours = $_POST["durationHours"];
        $durationMinutes = $_POST["durationMinutes"];

        $emptyErrMsg = "";

        if (empty($itemName)) {
            $emptyErrMsg .= "Item name is required. <br>";
        }
        if (empty($category)) {
            $emptyErrMsg .= "Category is required. <br>";
        }
        if (empty($description)) {
            $emptyErrMsg .= "Description is required. <br>";
        }
        if (empty($reservePrice)) {
            $emptyErrMsg .= "Reserve price is required. <br>";
        }
        if (empty($buyItNowPrice)) {
            $emptyErrMsg .= "Buy It Now price is required. <br>";
        }
        if (empty($startPrice)) {
            $emptyErrMsg .= "Start Price is required. <br>";
        }
        if ($durationDays == "") {
            $emptyErrMsg .= "Duration Days are required. <br>";
        }
        if ($durationHours == "") {
            $emptyErrMsg .= "Duration Hours are required. <br>";
        }
        if ($durationMinutes == "") {
            $emptyErrMsg .= "Duration Minutes are required. <br>";
        }

        if ($emptyErrMsg != "") {
            echo $emptyErrMsg;
        } else {

            $errMsg = '';

            if ($_POST["reservePrice"] < 0) {
                $errMsg .= "Reserve Price cannot be negative.<br>";
            }
            if ($_POST["buyItNowPrice"] < 0) {
                $errMsg .= "Buy It Now Price cannot be negative.<br>";
            }
            if ($_POST["startPrice"] < 0) {
                $errMsg .= "Start Price cannot be negative.<br>";
            }
            if ($_POST["startPrice"] > $_POST["reservePrice"]) {
                $errMsg .= "Start Price cannot be greater than Reserve Price.<br>";
            }
            if ($_POST["reservePrice"] > $_POST["buyItNowPrice"]) {
                $errMsg .= "Reserve Price cannot be greater than Buy It Now Price.<br>";
            }
            if ($durationDays == 0 && $durationHours == 0 && $durationMinutes == 0) {
                $errMsg .= "The duration date must be greater than the current date.<br>";
            }

            if (!empty($errMsg)) {
                echo $errMsg;

            } else {

                $xmlFile = 'auction.xml';
                $dom = new DOMDocument();
                $dom->preserveWhiteSpace = false;

                date_default_timezone_set('Australia/Sydney');

                // Load existing items from XML or create a new XML if it doesn't exist
                if (file_exists($xmlFile)) {
                    $dom->load($xmlFile);
                } else {
                    $items = $dom->createElement('items');
                    $dom->appendChild($items);
                }

                $items = $dom->getElementsByTagName('items')->item(0);

                // Create new item node
                $itemNode = $dom->createElement('item');
                $items->appendChild($itemNode);

                $customerId = $_SESSION['customerId'];
                // Create customerID node
                $customerIdElement = $dom->createElement('customerID');
                $itemNode->appendChild($customerIdElement);
                $customerIdValue = $dom->createTextNode($customerId);
                $customerIdElement->appendChild($customerIdValue);

                //Create unique item ID
                $itemID = uniqid();

                // Create customerID node
                $itemIdElement = $dom->createElement('itemID');
                $itemNode->appendChild($itemIdElement);
                $itemIdValue = $dom->createTextNode($itemID);
                $itemIdElement->appendChild($itemIdValue);

                // Create itemName node
                $itemNameElement = $dom->createElement('itemName');
                $itemNode->appendChild($itemNameElement);
                $itemNameValue = $dom->createTextNode($itemName);
                $itemNameElement->appendChild($itemNameValue);

                // Create category node
                $categoryElement = $dom->createElement('category');
                $itemNode->appendChild($categoryElement);
                $categoryValue = $dom->createTextNode($category);
                $categoryElement->appendChild($categoryValue);

                // Create description node
                $descriptionElement = $dom->createElement('description');
                $itemNode->appendChild($descriptionElement);
                $descriptionValue = $dom->createTextNode($description);
                $descriptionElement->appendChild($descriptionValue);

                // Create startingPrice node
                $startingPriceElement = $dom->createElement('startingPrice');
                $itemNode->appendChild($startingPriceElement);
                $startingPriceValue = $dom->createTextNode($startPrice);
                $startingPriceElement->appendChild($startingPriceValue);

                // Create reservePrice node
                $reservePriceElement = $dom->createElement('reservePrice');
                $itemNode->appendChild($reservePriceElement);
                $reservePriceValue = $dom->createTextNode($reservePrice);
                $reservePriceElement->appendChild($reservePriceValue);

                // Create buyItNowPrice node
                $buyItNowPriceElement = $dom->createElement('buyItNowPrice');
                $itemNode->appendChild($buyItNowPriceElement);
                $buyItNowPriceValue = $dom->createTextNode($buyItNowPrice);
                $buyItNowPriceElement->appendChild($buyItNowPriceValue);

                //Construct duration from Days,Hours and Minutes
                $duration = constructDuration($durationDays, $durationHours, $durationMinutes);

                // Create duration node
                $durationElement = $dom->createElement('duration');
                $itemNode->appendChild($durationElement);
                $durationValue = $dom->createTextNode($duration);
                $durationElement->appendChild($durationValue);

                $status = 'in_progress'; //Default value for status

                // Create status node
                $statusElement = $dom->createElement('status');
                $itemNode->appendChild($statusElement);
                $statusValue = $dom->createTextNode($status);
                $statusElement->appendChild($statusValue);

                // Get current date and time
                $currentDate = date("Y-m-d");

                // Create currentDate node
                $currentDateElement = $dom->createElement('currentDate');
                $itemNode->appendChild($currentDateElement);
                $currentDateValue = $dom->createTextNode($currentDate);
                $currentDateElement->appendChild($currentDateValue);

                $currentTime = date("H:i:s");

                // Create currentTime node
                $currentTimeElement = $dom->createElement('currentTime');
                $itemNode->appendChild($currentTimeElement);
                $currentTimeValue = $dom->createTextNode($currentTime);
                $currentTimeElement->appendChild($currentTimeValue);

                // Create bidPrice node
                $bidPriceElement = $dom->createElement('bidPrice');
                $itemNode->appendChild($bidPriceElement);
                $bidPriceValue = $dom->createTextNode($startPrice);
                $bidPriceElement->appendChild($bidPriceValue);

                $dom->formatOutput = true;
                $dom->save($xmlFile);

                $responseMessage = "Thank you! Your item has been listed in ShopOnline. The item number is $itemID, and the bidding starts now: $currentTime on $currentDate.";

                echo $responseMessage;
            }
        }
    } else {

        echo "Method Not Allowed";
    }
}

function constructDuration($days, $hours, $minutes)
{
    $durationToAdd = "P" . $days . "D" . "T" . "$hours" . "H" . $minutes . "M";
    $result = new DateTime(date('Y-m-d H:i:s'));
    $result->add(new DateInterval($durationToAdd));

    $result = $result->format('Y-m-d H:i:s');
    return $result;
}


?>
