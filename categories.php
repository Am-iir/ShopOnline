<?php
/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file returns unique categories from auction.xml for dropdown in listing.html
*/


$doc = new DOMDocument();
$doc->load('auction.xml');

$categories = [];

$items = $doc->getElementsByTagName('item');

foreach ($items as $item) {
    $category = $item->getElementsByTagName('category')->item(0)->nodeValue;
    // Check if category already exists in the array
    if (!in_array($category, $categories)) {

        // If not add category  to the array
        $categories[] = $category;
    }
}

// Convert array to comma-separated string
$categoryString = implode(',', $categories);

echo $categoryString;
?>
