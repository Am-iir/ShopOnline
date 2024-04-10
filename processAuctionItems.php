<?php

/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file process the Auction items that has crossed the duration
*/


$xmlFile = 'auction.xml';
$xml = new DOMDocument();
$xml->load($xmlFile);


date_default_timezone_set('Australia/Sydney');
$currentDateTime = new DateTime();


$items = $xml->getElementsByTagName("item");

foreach ($items as $item) {
    $status = $item->getElementsByTagName("status")->item(0)->nodeValue;

    if ($status == "in_progress") {
        $duration = $item->getElementsByTagName("duration")->item(0)->nodeValue;

        $endTime = new DateTime($duration);

        if ($currentDateTime > $endTime) {
            $currentBidPrice = $item->getElementsByTagName("bidPrice")->item(0)->nodeValue;
            $reservePrice = $item->getElementsByTagName("reservePrice")->item(0)->nodeValue;

            // Check if the current bid price is higher than the reserve price
            if ($currentBidPrice >= $reservePrice) {
                $item->getElementsByTagName("status")->item(0)->nodeValue = "sold";
            } else {
                $item->getElementsByTagName("status")->item(0)->nodeValue = "failed";
            }
        }
    }
}

$xml->formatOutput = true;
$xml->save($xmlFile);

echo "Processing of auction items complete.";
?>
