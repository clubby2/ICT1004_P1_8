<?php
session_start();
require 'config.php';

//Constants for accessing our DB:
define("DBHOST", "161.117.122.252");
define("DBNAME", "p1_8");
define("DBUSER", "p1_8");
define("DBPASS", "1rE4exyIbQ");

// define variables and set to empty values
$addrErrorMsg = $postalcodeErrorMsg = $errorMsg = "";
$addr = $postalcode = "";

$success = true;

//Address validation
if (empty($_POST["addr"])) {
    $addrErrorMsg = "Address is required.<br>";
    $success = false;
} else {
    $addr = sanitize_input($_POST["addr"]);
    //Check address format
    if (!preg_match("/^[A-Za-z0-9\-\(\)#@(\) ]+$/", $addr)) {
        $addrErrorMsg = "Invalid address format.";
        $success = false;
    }
}

//Postal Code validation
if (empty($_POST["postalcode"])) {
    $postalcodeErrorMsg = "Postal code is required.<br>";
    $success = false;
}else {
    $postalcode = sanitize_input($_POST["postalcode"]);
    //Check if postal code only contains numbers
    if (!preg_match("/^[1-9][0-9]{5}$/", $postalcode)) {
        $postalcodeErrorMsg = "Invalid postal code format.";
        $success = false;
    }
}

if ($success) {
    echo "<h4>Shipping address saved!</h4>";
    echo "<br>";
    echo "<a href='index.php'><button>Return to Home</button></a>&nbsp;<a href='userprofile.php'><button>Return to user profile</button></a>";
} else {
    echo "<h1>Oops!</h1>";
    echo "<h4>The following errors were detected:</h4>";
    echo "<p>" . $addrErrorMsg . "</p>";
    echo "<p>" . $postalcodeErrorMsg . "</p>";

    echo "<a href='userprofile.php'><button type='button' class='btn btn-default'>Return User profile</button></a>";
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Helper function to write the data to the DB
global $addr, $postalcode, $errorMsg, $success;

//Create connection
$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

//Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    $sql = "UPDATE p1_8.user SET address = '$addr', postal_code = '$postalcode'";
    $sql .= " WHERE UID='$_SESSION[UID]'";

    //Execute the query
    if (!$conn->query($sql)) {
        $errorMsg = "Database error: " . $conn->error;
        $success = false;
    }
}
$conn->close();
?>