<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {

        // Retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Load XML file
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
                // Set session variables
                $_SESSION['customerId'] = $customer->getAttribute('id');
                $_SESSION['firstName'] = $customer->getElementsByTagName('firstName')->item(0)->nodeValue;

                $foundUser = true;
                break;
            }
        }

        if ($foundUser) {
            echo "Okay";

            // Redirect to bidding page or dashboard
            // header("Location: bidding.php"); // Change to appropriate page
            exit();
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo 'Some fields are missing please fill all the required values';
    }
}
?>
