<?php

session_start();
require 'config.php';

//Constants for accessing our DB:
define("DBHOST", "161.117.122.252");
define("DBNAME", "p1_8");
define("DBUSER", "p1_8");
define("DBPASS", "1rE4exyIbQ");

//Define variables and set to empty values
$errorMsg = "";


$success = true;

if ($success) {
    echo "<h4>Successfully Deleted!</h4>";

    echo "<br>";
    echo "<a href='index.php'><button>Return to Home</button></a>";
    echo "<a href='userprofile.php'><button type='button' class='btn btn-default'>Return User profile</button></a>";
} else {
    echo "<h1>Oops!</h1>";
    echo "<h4>The following errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
    echo "<a href='userprofile.php'><button type='button' class='btn btn-default'>Return User profile</button></a>";
}

//Helper function to write the data to the DB
global $errorMsg, $success;

//Create connection
$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

//Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    $deleteQuery = "DELETE FROM p1_8.payment WHERE UID = '$_SESSION[UID]]'";

    //Execute the query
    if (!$conn->query($deleteQuery)) {
        $errorMsg = "Database error: " . $conn->error;
        $success = false;
    }
}

$conn->close();
