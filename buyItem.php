<?php

/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file handles the functionality of buy Item
*/

session_start();

// Check if bidder's ID is set in the session
if (isset($_SESSION['customerId'])) {

    $doc = new DOMDocument();
    $xmlFile = 'auction.xml';
    $doc->load($xmlFile);

    if (isset($_POST['itemId'])) {

        $itemId = $_POST['itemId'];

        $bidderID = $_SESSION['customerId']; // Retrieve customer ID from session

        $items = $doc->getElementsByTagName('item');
        $itemFound = false;
        $errorMessage = "";

        foreach ($items as $item) {
            $itemID = $item->getElementsByTagName('itemID')->item(0)->nodeValue;
            if ($itemID == $itemId) {
                $status = $item->getElementsByTagName('status')->item(0)->nodeValue;

                // Check if the item is available for buy
                if ($status == 'in_progress') {

                    $buyItNowPrice = $item->getElementsByTagName('buyItNowPrice')->item(0)->nodeValue;
                    $item->getElementsByTagName('bidPrice')->item(0)->nodeValue = $buyItNowPrice;

                    // Check if the bidderID element exists otherwise create it
                    $bidderIDNode = $item->getElementsByTagName('bidderID')->item(0);
                    if ($bidderIDNode === null) {
                        $bidderIDNode = $doc->createElement('bidderID');
                        $item->appendChild($bidderIDNode);
                    }

                    // Set the bidder's ID
                    $bidderIDNode->nodeValue = $bidderID;

                    $item->getElementsByTagName('status')->item(0)->nodeValue = 'sold';
                    $doc->formatOutput = true;
                    $doc->save($xmlFile);

                    $itemFound = true;
                    break;
                } else {
                    $errorMessage = "The item is not available for purchase.";
                    break;
                }
            }
        }

        if ($itemFound) {
            echo "Thank you for purchasing this item.";
        } else {
            if (!empty($errorMessage)) {
                echo "Sorry, your purchase request is not valid: " . $errorMessage;
            } else {
                echo "Sorry, your purchase request is not valid.";
            }
        }
    } else {

        echo "Some fields are missing.";
    }
} else {

    echo "Error: Customer is not logged in.";
}
?>
