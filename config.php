<?php
//$db = mysqli_connect("localhost", "root", "","changiusers");
$db = mysqli_connect("161.117.122.252", "p1_8", "1rE4exyIbQ","p1_8");
//$db = mysqli_connect("122.11.149.141", "iot_vogomo", "Admin@123","iot_vogomo");
//$db = new mysqli("iot.vogomo.com", "iot_vogomo", "Admin@123");

if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

 ?>
