<?xml version="1.0" encoding="UTF-8"?>

<!--
    Student Name: Amir Maharjan
    Student ID: 104088013

   This file is XSL for maintenance report on table, no of sold, failed and total revenue
-->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-top: 20px;">
            <tr style="background-color: #f2f2f2;">
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Starting Price</th>
                <th>Reserve Price</th>
                <th>Bid Price</th>
                <th>Buy It Now Price</th>
                <th>Bidder ID</th>
                <th>Status</th>
            </tr>
            <xsl:apply-templates select="items/item"/>
        </table>
        <p style="font-weight: bold; color: green; font-size: 20px; margin-top: 20px;">
            <p>Total number of sold items:
                <xsl:value-of select="count(items/item[status='sold'])"/>
            </p>
            <p>Total number of failed items:
                <xsl:value-of select="count(items/item[status='failed'])"/>
            </p>
            <p>Total Revenue:
                <xsl:value-of
                        select="0.03 * sum(//item[status='sold']/bidPrice) + 0.01 * sum(//item[status='failed']/reservePrice)"/>
            </p>
        </p>

    </xsl:template>

    <xsl:template match="item">
        <tr>
            <td>
                <xsl:value-of select="itemID"/>
            </td>
            <td>
                <xsl:value-of select="itemName"/>
            </td>
            <td>
                <xsl:value-of select="category"/>
            </td>
            <td>
                <xsl:value-of select="startingPrice"/>
            </td>
            <td>
                <xsl:value-of select="reservePrice"/>
            </td>
            <td>
                <xsl:value-of select="bidPrice"/>
            </td>
            <td>
                <xsl:value-of select="buyItNowPrice"/>
            </td>
            <td>
                <xsl:value-of select="bidderID"/>
            </td>
            <td>
                <xsl:value-of select="status"/>
            </td>
        </tr>
    </xsl:template>

</xsl:stylesheet>
