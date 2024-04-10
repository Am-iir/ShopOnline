<?php

/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file handles the functionality of placing bid for Item
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if bidder's ID is set in the session
if (isset($_SESSION['customerId'])) {

    $doc = new DOMDocument();
    $xmlFile = 'auction.xml';
    $doc->load($xmlFile);

    if (isset($_POST['itemId']) && isset($_POST['newBidPrice'])) {

        $itemId = $_POST['itemId'];
        $newBidPrice = $_POST['newBidPrice'];

        $bidderID = $_SESSION['customerId'];

        $items = $doc->getElementsByTagName('item');
        $bidIsValid = false;
        $errorMessage = "";

        foreach ($items as $item) {
            $itemID = $item->getElementsByTagName('itemID')->item(0)->nodeValue;
            //Check if item exists in xml
            if ($itemID == $itemId) {

                $currentBidPrice = $item->getElementsByTagName('bidPrice')->item(0)->nodeValue;
                $buyItNowPrice = $item->getElementsByTagName('buyItNowPrice')->item(0)->nodeValue;
                $status = $item->getElementsByTagName('status')->item(0)->nodeValue;

                if ($status == 'in_progress') {

                    if ($newBidPrice > $currentBidPrice) {
                        if ($newBidPrice < $buyItNowPrice) {

                            // Update the item with new bid price
                            $item->getElementsByTagName('bidPrice')->item(0)->nodeValue = $newBidPrice;

                            // Check if the bidderID element exists otherwise create it
                            $bidderIDNode = $item->getElementsByTagName('bidderID')->item(0);
                            if ($bidderIDNode === null) {
                                $bidderIDNode = $doc->createElement('bidderID');
                                $item->appendChild($bidderIDNode);
                            }

                            // Set the bidder's ID
                            $bidderIDNode->nodeValue = $bidderID;

                            $doc->formatOutput = true;
                            $doc->save($xmlFile);
                            $bidIsValid = true;
                            $errorMessage = "";
                        } else {
                            $errorMessage = "Your bid must be lower than Buy It Now Price.";
                        }

                    } else {
                        $errorMessage = "Your bid must be higher than the current bid price.";
                    }
                } else {
                    $errorMessage = "The item is not available for bidding.";
                }
                break;
            }
        }

        if ($bidIsValid) {
            echo "Thank you! Your bid is recorded in ShopOnline.";
        } else {
            if (!empty($errorMessage)) {
                echo "Sorry, your bid is not valid: " . $errorMessage;
            } else {
                echo "Sorry, your bid is not valid.";
            }
        }
    } else {
        echo "Some fields are missing.";
    }
} else {
    echo "Please login first to place the bid";
}
?>
