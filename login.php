<?php
/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file checks customer's credentials and on success allows login otherwise display message
*/

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $xmlFile = 'customer.xml';
        $dom = new DOMDocument();
        $dom->load($xmlFile);

        // Get all customer elements
        $customers = $dom->getElementsByTagName('customer');

        $foundUser = false;
        foreach ($customers as $customer) {
            $customerEmail = $customer->getElementsByTagName('email')->item(0)->nodeValue;
            $customerPassword = $customer->getElementsByTagName('password')->item(0)->nodeValue;

            // Check if email and password match
            if ($customerEmail == $email && $customerPassword == $password) {

                // Set customerId session variables
                $_SESSION['customerId'] = $customer->getAttribute('id');

                $foundUser = true;
                break;
            }
        }

        if ($foundUser) {

            //Redirect to bidding page when user is found
            header("Location: bidding.htm");

        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo 'Some fields are missing please fill all the required values';
    }
}
?>
