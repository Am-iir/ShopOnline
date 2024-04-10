<?php

/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file generates maintenance report
*/

$xmlFile = 'auction.xml';
$xml = new DOMDocument();
$xml->formatOutput = true;
$xml->load($xmlFile);

// Apply XSLT stylesheet
$xsl = new DOMDocument();
$xsl->load('auctionReport.xsl');

$proc = new XSLTProcessor();
$proc->importStyleSheet($xsl);

// Apply XSL transformation
$strXml = $proc->transformToXML($xml);

$items = $xml->getElementsByTagName("item");

$itemsToRemove = [];
foreach ($items as $item) {
    $status = $item->getElementsByTagName("status")->item(0)->nodeValue;

    if ($status === "sold" || $status === "failed") {
        $itemsToRemove[] = $item;
    }
}

// Remove items
foreach ($itemsToRemove as $item) {
    $item->parentNode->removeChild($item);
}

$xml->save($xmlFile);

echo $strXml;

?>
