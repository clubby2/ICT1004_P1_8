<?php

session_start();

include 'encrypt.php';
//Constants for accessing our DB:
/*
define("DBHOST", "161.117.122.252");
define("DBNAME", "p1_8");
define("DBUSER", "p1_8");
define("DBPASS", "1rE4exyIbQ");
*/
//Define variables and set to empty values
$cardNameErrorMsg = $cardtypeErrorMsg = $cardNumErrorMsg = $expDateErrorMsg = $cvcErrorMsg = $errorMsg = "";
$cardName = $cardtype = $cardNum = $expDate = $cvc = $selectCards = "";

$success = true;

//Card name validation
if (empty($_POST["cardName"])) {
    $cardNameErrorMsg = "Card Name is required.<br>";
    $success = false;
} else {
    $cardName = sanitize_input($_POST["cardName"]);

    //Check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]+$/", $cardName)) {
        $cardNameErrorMsg = "First name is invalid. Only letters and white space allowed.";
        $success = false;
    }
}

//Card Type
if (empty($_POST["cardtype"])) {
    $cardtypeErrorMsg = "Card type is required.<br>";
    $success = false;
} else {
    $cardtype = sanitize_input($_POST["cardtype"]);
}

//Card number validation
if (empty($_POST["cardNum"])) {
    $cardNumErrorMsg = "Card number is required.<br>";
    $success = false;
} else {
    $cardNum = sanitize_input($_POST["cardNum"]);
    $cardtype = sanitize_input($_POST["cardtype"]);

    if ($cardtype == "Visa") {
          if (!preg_match('/^4[0-9]{15}$/', $cardNum)) {
            echo $cardNum;
            $cardNumErrorMsg = "Visa card invalid. Please ensure that you have entered the correct format.";
            $success = false;
        }
    } else if ($cardtype == "Mastercard") {
        if (!preg_match("/^5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}$/", $cardNum)) {
            $cardNumErrorMsg = "Mastercard invalid. Please ensure that you have entered the correct format.";
            $success = false;
        }
    }
    $cardNum = maskedCardNum($cardNum);
    $cardNum = encrypt($cardNum, $encryptionkey);
}

//Card expiry date validation
if (empty($_POST["expDate"])) {
    $expDateErrorMsg = "Expiry date is required.";
    $success = false;
} else {
    $expDate = sanitize_input($_POST["expDate"]);

    //Check if date only contains numbers
    if (!preg_match("/^(0[1-9]|1[012]).([2-9][0-9])+$/", $expDate)) {
        $expDateErrorMsg = "Expiry date is invalid. Please input the correct format MM/YY.";
        $success = false;
    }
}

// CVV code validation
if (empty($_POST["cvc"])) {
    $cvcErrorMsg = "CVV code is required.";
    $success = false;
} else {
    $cvc = sanitize_input($_POST["cvc"]);
    //Check if date only contains numbers and /
    if (!preg_match("/^(?!000)[0-9]{3}$/", $cvc)) {
        $cvcErrorMsg = "CVV code is invalid. Please ensure cvv code has 3 digits and does not contain more than 2 zeroes.";
        $success = false;
    }
}

if ($success) {
    echo "<h4>Card details saved!</h4>";
//    echo "<p>" . $cardName . "</p>";
//    echo "<p>" . $cardtype . "</p>";
//    echo "<p>" . $cardNum . "</p>";
//    echo "<p>" . $expDate . "</p>";
//    echo "<p>" . $cvc . "</p>";

    echo "<br>";
    echo "<a href='index.php'><button>Return to Home</button></a>";
    echo "<a href='userprofile.php'><button type='button' class='btn btn-default'>Return User profile</button></a>";
} else {
    echo "<h1>Oops!</h1>";
    echo "<h4>The following errors were detected:</h4>";
    echo "<p>" . $cardNameErrorMsg . "</p>";
    echo "<p>" . $cardtypeErrorMsg . "</p>";
    echo "<p>" . $cardNumErrorMsg . "</p>";
    echo "<p>" . $expDateErrorMsg . "</p>";
    echo "<p>" . $cvcErrorMsg . "</p>";
    echo "<p>" . $errorMsg . "</p>";
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
global $cardName, $cardtype, $cardNum, $expDate, $cvc, $errorMsg, $success;
require 'config.php';
//Create connection
//$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

//Check connection
if ($db->connect_error) {
    $errorMsg = "Connection failed: " . $db->connect_error;
    $success = false;
} else {
    $cardinfoQuery = "SELECT * FROM p1_8.payment WHERE UID ='$_SESSION[UID]]'";

    //Execute query and store the result set
    $result = mysqli_query($db, $cardinfoQuery);

    if ($result) {
        //Return number of rows in the table
        $row = mysqli_num_rows($result);

        if ($row > 0) {
            $cardinfoQuery = "UPDATE p1_8.payment SET UID ='$_SESSION[UID]]', card_name = '$cardName', card_number = '$cardNum', cvv = '$cvc', card_expiry = '$expDate', card_type = '$cardtype' WHERE UID='$_SESSION[UID]' ";
            if (!$db->query($cardinfoQuery)) {
                $errorMsg = "Database error: " . $db->error;
                $success = false;
            }
        } else {
            $cardinfoQuery = "INSERT INTO p1_8.payment(UID, card_name, card_number, cvv, card_expiry, card_type) VALUES((SELECT UID FROM p1_8.user WHERE UID = '$_SESSION[UID]]'), '$cardName', '$cardNum', '$cvc', '$expDate', '$cardtype')";

            //Execute the query
            if (!$db->query($cardinfoQuery)) {
                $errorMsg = "Database error: " . $db->error;
                $success = false;
            }
        }
    }

    if(!$success){
        $cardinfoQuery = 0;
    }
}

$db->close();
