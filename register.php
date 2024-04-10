<?php

/*
    Student Name: Amir Maharjan
    Student ID: 104088013

    This file checks customer's input for registering on creates new customer otherwise display error message
*/

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['firstName']) &&
        isset($_POST['surname']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['confirmPassword'])
    ) {

        $firstName = $_POST['firstName'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $emptyErrMsg = "";

        if (empty($firstName)) {
            $emptyErrMsg .= 'First name is required<br>';
        }

        if (empty($surname)) {
            $emptyErrMsg .= 'Surname is required<br>';
        }

        if (empty($email)) {
            $emptyErrMsg .= 'Email is required<br>';
        }

        if (empty($password)) {
            $emptyErrMsg .= 'Password is required<br>';
        }

        if (empty($confirmPassword)) {
            $emptyErrMsg .= 'Confirm password is required<br>';
        }

        if ($emptyErrMsg != "") {
            echo $emptyErrMsg;
        } else {

            $errMsg = "";

            // Validate email format
            if (!preg_match('/^[a-zA-Z0-9!#$%&\'*+\-\/=?^_`{|}~.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email)) {
                $errMsg .= 'Invalid email address<br>';
            }

            if ($password !== $confirmPassword) {
                $errMsg .= 'Passwords do not match<br>';
            }

            // Load existing customers from XML or create a new XML if it doesn't exist
            $xmlFile = 'customer.xml';
            $dom = new DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;

            if (file_exists($xmlFile)) {
                $dom->load($xmlFile);
            } else {
                $customers = $dom->createElement('customers');
                $dom->appendChild($customers);
            }

            // Check if email already exists
            $customersList = $dom->getElementsByTagName('customer');
            foreach ($customersList as $customer) {
                $existingEmail = $customer->getElementsByTagName('email')->item(0)->nodeValue;
                if ($existingEmail === $email) {
                    $errMsg .= 'Email address already exists<br>';
                    break;
                }
            }

            if ($errMsg != "") {
                echo $errMsg;
            } else {

                $customers = $dom->getElementsByTagName('customers')->item(0);

                // Create new customer node
                $customerNode = $dom->createElement('customer');
                $customers->appendChild($customerNode);

                // Generate customer ID
                $customerId = uniqid();

                $idElement = $dom->createElement('id');
                $customerNode->appendChild($idElement);
                $idValue = $dom->createTextNode($customerId);
                $idElement->appendChild($idValue);

                // Create and append firstName element
                $firstNameElement = $dom->createElement('firstName');
                $customerNode->appendChild($firstNameElement);
                $firstNameValue = $dom->createTextNode($firstName);
                $firstNameElement->appendChild($firstNameValue);

                // Create and append surname element
                $surnameElement = $dom->createElement('surname');
                $customerNode->appendChild($surnameElement);
                $surnameValue = $dom->createTextNode($surname);
                $surnameElement->appendChild($surnameValue);

                // Create and append email element
                $emailElement = $dom->createElement('email');
                $customerNode->appendChild($emailElement);
                $emailValue = $dom->createTextNode($email);
                $emailElement->appendChild($emailValue);

                // Create and append password element
                $passwordElement = $dom->createElement('password');
                $customerNode->appendChild($passwordElement);
                $passwordValue = $dom->createTextNode($password);
                $passwordElement->appendChild($passwordValue);

                $dom->save($xmlFile);

                // Store customerId session variables
                $_SESSION['customerId'] = $customerNode;

                $to = $email;
                $subject = 'Welcome to ShopOnline!';
                $message = "Dear $firstName, welcome to use ShopOnline! Your password is $password.";
                $headers = "From: registration@shoponline.com.au\r\n";
             //   mail($to, $subject, $message, $headers, "-r 104088013@student.swin.edu.au");

                echo 'Registration successful';

                //Redirect to bidding page after  successful registration
                // header("Location: bidding.htm");
            }
        }
    } else {
        echo 'Some fields are missing please fill all the required values';
    }
} else {
    echo 'Invalid request';
}
?>
