<?php
/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file returns items listed for auction from auction.xml
*/

$doc = new DOMDocument();
$doc->load('auction.xml');

$items = $doc->getElementsByTagName('item');

foreach ($items as $item) {

    $itemID = $item->getElementsByTagName('itemID')->item(0)->nodeValue;
    $itemName = $item->getElementsByTagName('itemName')->item(0)->nodeValue;
    $category = $item->getElementsByTagName('category')->item(0)->nodeValue;
    $description = $item->getElementsByTagName('description')->item(0)->nodeValue;
    $startingPrice = $item->getElementsByTagName('startingPrice')->item(0)->nodeValue;
    $buyItNowPrice = $item->getElementsByTagName('buyItNowPrice')->item(0)->nodeValue;
    $duration = $item->getElementsByTagName('duration')->item(0)->nodeValue;
    $status = $item->getElementsByTagName('status')->item(0)->nodeValue;
    $currentBidPrice = $item->getElementsByTagName('bidPrice')->item(0)->nodeValue;


    // Construct HTML for the item
    $html = "<div class='item'>";
    $html .= "<p><label>Item ID:</label> $itemID</p>";
    $html .= "<p><label>Item Name:</label> $itemName</p>";
    $html .= "<p><label>Category:</label> $category</p>";
    $html .= "<p><label>Description:</label> " . substr($description, 0, 30) . "</p>";
    $html .= "<p><label>Buy-It-Now Price:</label> $buyItNowPrice</p>";
    $html .= "<p><label>Current Bid Price:</label> $currentBidPrice</p>";


    // Calculate time left
    date_default_timezone_set('Australia/Sydney');
    $durationDate = new DateTime($duration);
    $currentDateTime = new DateTime();


    if ($currentDateTime < $durationDate) {
        $interval = $currentDateTime->diff($durationDate);

        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        $timeLeft = '';
        if ($days > 0) {
            $timeLeft .= "$days days ";
        }
        if ($hours > 0) {
            $timeLeft .= "$hours hours ";
        }
        if ($minutes > 0) {
            $timeLeft .= "$minutes minutes ";
        }
        $timeLeft .= "$seconds seconds remaining";

        $html .= "<p id='timeLeft'>$timeLeft</p>";
    }


    if ($status == 'in_progress' && $currentDateTime < $durationDate) {
        $html .= "<div class='itemButtonContainer'>";
        $html .= "<button class='place-bid' onclick='placeBidPrompt(\"$itemID\")'>Place Bid</button>";
        $html .= "<button class='buy-now' onclick='buyItem(\"$itemID\")'>Buy It Now</button>";
        $html .= "</div>";
    } else {
        // Item has been sold or time expired
        $html .= "<p id='itemStatus'>";
        if ($status == 'sold') {
            $html .= "Item has been Sold";
        } else {
            $html .= "Time Expired for this Item";
        }
        $html .= "</p>";
    }

    $html .= "</div>";


    echo $html;
}
?>
