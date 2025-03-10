<?php
// Start the session to retrieve session data
session_start();

// Retrieve posted form data from the previous page
$name = htmlspecialchars($_POST['first_name']);
$mobile = htmlspecialchars($_POST['mobile']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);
$selectedAddressKey = htmlspecialchars($_POST['selected_address']);
$addressLine1 = htmlspecialchars($_POST['address_line1']);
$addressLandmark = htmlspecialchars($_POST['address_landmark']);
$addressCity = htmlspecialchars($_POST['address_city']);
$addressState = htmlspecialchars($_POST['address_state']);
$addressPin = htmlspecialchars($_POST['address_pin']);

// Display the order details
echo "<h2>Order Details:</h2>";
echo "<p><strong>Name:</strong> $name</p>";
echo "<p><strong>Mobile:</strong> $mobile</p>";
echo "<p><strong>Email:</strong> $email</p>";
echo "<p><strong>Message:</strong> $message</p>";
echo "<p><strong>Selected Address Key:</strong> $selectedAddressKey</p>";

echo "<h3>Address Details:</h3>";
echo "<p><strong>Address Line 1:</strong> $addressLine1</p>";
echo "<p><strong>Landmark:</strong> $addressLandmark</p>";
echo "<p><strong>City:</strong> $addressCity</p>";
echo "<p><strong>State:</strong> $addressState</p>";
echo "<p><strong>Pin Code:</strong> $addressPin</p>";

include "config/send_email_pay.php";
sendConfirmationEmail($name, $email, $mobile);


?>

<button id="payButton" class="btn btn-success">Pay</button>

<script>
    document.getElementById("payButton").addEventListener("click", function() {
        fetch("config/send_email_pay.php", {
                method: "POST",
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Payment successful! Email sent.");
                } else {
                    alert("Payment failed! " + data.message);
                }
            })
            .catch(error => console.error("Error:", error));
    });
</script>