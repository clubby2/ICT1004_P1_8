<?php
session_start();

//Constants for accessing our DB:
//define("DBHOST", "161.117.122.252");
//define("DBNAME", "p1_8");
//define("DBUSER", "p1_8");
//define("DBPASS", "1rE4exyIbQ");
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
require 'config.php';
global $errorMsg, $success;
//Create connection

//Check connection
if ($db->connect_error) {
    $errorMsg = "Connection failed: " . $db->connect_error;
    $success = false;
} else {
    $deleteQuery = "DELETE FROM p1_8.payment WHERE UID = '$_SESSION[UID]]'";
    //Execute the query
    if (!$db->query($deleteQuery)) {
        $errorMsg = "Database error: " . $db->error;
        $success = false;
    }
}
$db->close();
