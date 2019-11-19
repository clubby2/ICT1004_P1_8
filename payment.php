<?php

session_start();
if (isset($_POST['toPayment'])) {
$userid=$_SESSION['UID'];
require 'config.php';

$idsql= "SELECT * FROM cart WHERE checks = 1 AND UID=$userid"; // query cart item and add
  $sqlitem= mysqli_query($db,$idsql);
  $checkitem = mysqli_fetch_assoc($sqlitem);
  //echo $idsql;
  //exit;
  if (empty($checkitem)) {
    echo '<script language="javascript">';
   echo 'alert("Please check out an item!")</script>';
      header ('location:cart.php');
  }
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">
    <title>Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="css/index.css" rel="stylesheet" >
     <link href="css/bootstrap.min.css" rel="stylesheet" >
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">  </script>

    <script src="js/index.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
<!-- header -->
<?php
include "header.php";
include "config.php";
include "encrypt.php";

if(isset($_POST['logout'])){
  //session_start();
//  echo "HALLLLLO";
session_destroy();
unset($_SESSION['email']);
unset($_SESSION['role']);
unset($_SESSION['UID']);
//header('Location:index.php');
}
?>
<!-- content here -->
<section>
    <article>
        <div class='container-fluid'>
            <form action='process_payment.php' method='POST' onsubmit='return validateAddrForm()'>
<?php




$success = true;
$insertvisa = false;
$insertmaster = false;
$updatevisa = false;
$updatemaster = false;
$errorMsg = "";
$userid =$_SESSION['UID'];

    //query visa, master and address information from db
    $visaquery = "SELECT * FROM payment WHERE UID= $userid AND card_type='Visa'";
    $masterquery = "SELECT * FROM payment WHERE UID= $userid AND card_type='Mastercard'";
    $addrquery = "SELECT address, postal_code FROM user WHERE UID= $userid";

    $addrresult = mysqli_query($db, $addrquery);
    if(mysqli_num_rows($addrresult) > 0){
        $addressrow = mysqli_fetch_assoc($addrresult);
        $address = $addressrow['address'];
        $postal = $addressrow['postal_code'];
        mysqli_free_result($addrresult);

    }
    $visaresult = mysqli_query($db, $visaquery);
    if(mysqli_num_rows($visaresult) > 0){
        $visarow = mysqli_fetch_assoc($visaresult);
        $visacard_type = $visarow['card_type'];
        $visacardname = $visarow['card_name'];
        $visacardnum = $visarow['card_number'];
        $visacardnum = decrypt($visacardnum, $encryptionkey);
        $visaexpirydate = $visarow['card_expiry'];
        mysqli_free_result($visaresult);

    }
    $masterresult = mysqli_query($db, $masterquery);
    if(mysqli_num_rows($masterresult) > 0){
        $masterrow = mysqli_fetch_assoc($masterresult);
        $mastercard_type = $masterrow['card_type'];
        $MCcardname = $masterrow['card_name'];
        $MCcardnum = $masterrow['card_number'];
        $MCcardnum = decrypt($MCcardnum, $encryptionkey);
        $MCexpirydate = $masterrow['card_expiry'];
        mysqli_free_result($masterresult);

    }

    //if user updates or change card in the modal.
    if (isset($_POST['change']))
    {
        $type = sanitize_input($_POST['cardtype']);

        //if user select mastercard
        if ($type == 'Mastercard')
        {
            //if user has mastercard stored
            if (!empty($mastercard_type))
            {
                $Mcardname = sanitize_input($_POST['cardname']);
                $Mcardnum = sanitize_input($_POST['cardnum']);
                $Mexpirydate = sanitize_input($_POST['expiredate']);

                if (empty($Mcardname) || empty($Mcardnum) || empty($Mexpirydate))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please fill in all fields! </div>";
                    $success = false;

                }
                else
                {
                    if (!preg_match("/^5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}$/", $Mcardnum))
                    {
                        $errorMsg .= "Invalid Card Number<br>";
                        $success = false;
                    }
                    else{
                        $Mcardnum = maskedCardNum($Mcardnum);
                        $Mcardnum = encrypt($Mcardnum, $encryptionkey);

                    }
                    if (!preg_match("/^(0[1-9]|1[012]).([2-9][0-9])+$/", $Mexpirydate))
                    {
                        $errorMsg .= "Invalid card expiry date<br>";
                        $success = false;
                    }
                    else{
                        $updatemaster = true;

                    }
//                    if (!preg_match("/^(?!000)[0-9]{3}$/", $MCVV))
//                    {
//                        $errorMsg .= "Invalid CVV<br>";
//                        $success = false;
//                    }
                    if ($updatemaster){
                        $updatemaster = "UPDATE payment SET card_name = '$Mcardname', card_number = '$Mcardnum' , card_expiry='$Mexpirydate' WHERE UID=$userid AND card_type='Mastercard'";
                        if (mysqli_query($db, $updatemaster)) {
                            echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Card updated successfully! </div>";
                            //update the changes
                            $masterquery = "SELECT * FROM payment WHERE UID = $userid AND card_type='Mastercard'";
                            $masterresult = mysqli_query($db, $masterquery);
                            if(mysqli_num_rows($masterresult) > 0){
                                $row = mysqli_fetch_assoc($masterresult);
                                $mastercard_type = $row['card_type'];
                                $MCcardname = $row['card_name'];
                                $MCcardnum = $row['card_number'];
                                $MCcardnum = decrypt($MCcardnum, $encryptionkey);
                                $MCexpirydate = $row['card_expiry'];
                                mysqli_free_result($masterresult);
                                mysqli_close($db);
                            }
                        }
                        else {
                            echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error! </div>";
                        }
                    }
                }
            }
            else
            {
                //if user does not have mastercard stored
                $Mcardname = sanitize_input($_POST['cardname']);
                $Mcardnum = sanitize_input($_POST['cardnum']);
                $Mexpirydate = sanitize_input($_POST['expiredate']);
                if (empty($Mcardname) || empty($Mcardnum) || empty($Mexpirydate))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please fill in all fields! </div>";
                }
                else
                {
                    if (!preg_match("/^5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}$/", $Mcardnum))
                    {
                        $errorMsg .= "Invalid Card Number<br>";
                        $success = false;
                    }
                    else{
                        $Mcardnum = maskedCardNum($Mcardnum);
                        $Mcardnum = encrypt($Mcardnum, $encryptionkey);

                    }
                    if (!preg_match("/^(0[1-9]|1[012]).([2-9][0-9])+$/", $Mexpirydate))
                    {
                        $errorMsg .= "Invalid card expiry date<br>";
                        $success = false;
                    }
                    else{
                        $insertmaster = true;
                    }
//                    if (!preg_match("/^(?!000)[0-9]{3}$/", $MCVV))
//                    {
//                        $errorMsg .= "Invalid CVV<br>";
//                        $success = false;
//                    }
                    if ($insertmaster){
                        $insertmaster = "INSERT INTO payment (UID, card_name, card_number, card_expiry, card_type) VALUES ('$userid', '$Mcardname', '$Mcardnum', '$Mexpirydate', '$type')";
                        if (mysqli_query($db, $insertmaster)) {
                            echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New card saved successfully! </div>";
                            $masterquery = "SELECT * FROM payment WHERE UID = $userid AND card_type='Mastercard'";
                            $masterresult = mysqli_query($db, $masterquery);
                            if(mysqli_num_rows($masterresult) > 0){
                                $row = mysqli_fetch_assoc($masterresult);
                                $mastercard_type = $row['card_type'];
                                $MCcardname = $row['card_name'];
                                $MCcardnum = $row['card_number'];
                                $MCcardnum = decrypt($MCcardnum, $encryptionkey);
                                $MCexpirydate = $row['card_expiry'];
                                mysqli_free_result($masterresult);
                                mysqli_close($db);
                            }
                        }
                        else {
                            echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error! </div>";
                        }
                    }
                }
            }
        }
        else{
            //if user has existing visa card
            if (!empty($visacard_type))
            {
                //$updatevisa = false;
                $vcardname = sanitize_input($_POST['cardname']);
                $vcardnum = sanitize_input($_POST['cardnum']);
                $vexpirydate = sanitize_input($_POST['expiredate']);
                if (empty($vcardname) || empty($vcardnum) || empty($vexpirydate))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please fill in all fields! </div>";
                    $success = false;

                }
                else{
                    if (!preg_match("/^([4]{1})([0-9]{12,15})$/", $vcardnum))
                    {
                        $errorMsg .= "invalid card number<br>";
                        $success = false;
                    }
                    else{
                        $vcardnum = maskedCardNum($vcardnum);
                        $vcardnum = encrypt($vcardnum, $encryptionkey);

                    }
                    if (!preg_match("/^(0[1-9]|1[012]).([2-9][0-9])+$/", $vexpirydate))
                    {
                        $errorMsg .= "Invalid card expiry date<br>";
                        $success = false;
                    }
                    else{
                        $updatevisa = true;
                    }
//                    if (!preg_match("/^(?!000)[0-9]{3}$/", $vCVV))
//                    {
//                        $errorMsg .= "Invalid card CV<br>";
//                        $success = false;
//                    }

                    if ($updatevisa){
                        $updatevisa = "UPDATE payment SET card_name = '$vcardname', card_number = '$vcardnum' , card_expiry='$vexpirydate' WHERE UID=$userid AND card_type='Visa'";
                        if (mysqli_query($db, $updatevisa)) {
                            echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Card updated successfully! </div>";
                            $visaquery = "SELECT * FROM payment WHERE UID = $userid AND card_type='Visa'";
                            $visaresult = mysqli_query($db, $visaquery);
                            if(mysqli_num_rows($visaresult) > 0){
                                $row = mysqli_fetch_assoc($visaresult);
                                $visacard_type = $row['card_type'];
                                $visacardname = $row['card_name'];
                                $visacardnum = $row['card_number'];
                                $visacardnum = decrypt($visacardnum, $encryptionkey);
                                $visaexpirydate = $row['card_expiry'];
                                mysqli_free_result($visaresult);
                                mysqli_close($db);
                            }
                        }
                        else {
                            echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error! </div>";
                        }
                    }
                }
            }
            else
            {
                //if user has no visa stored
                $vcardname = sanitize_input($_POST['cardname']);
                $vcardnum = sanitize_input($_POST['cardnum']);
                $vexpirydate = sanitize_input($_POST['expiredate']);
                if (empty($vcardname) || empty($vcardnum) || empty($vexpirydate))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please fill in all fields! </div>";
                    $success = false;

                }
                else
                {
                    if (!preg_match("/^([4]{1})([0-9]{12,15})$/", $vcardnum))
                    {
                        $errorMsg .= "Invalid card number <br>";
                        $success = false;
                    }
                    else{
                        $vcardnum = maskedCardNum($vcardnum);
                        $vcardnum = encrypt($vcardnum, $encryptionkey);

                    }
                    if (!preg_match("/^(0[1-9]|1[012]).([2-9][0-9])+$/", $vexpirydate))
                    {
                        $errorMsg .= "Invalid card expiry date <br>";
                        $success = false;
                    }
                    else{
                        $insertvisa = true;
                    }
//                    if (!preg_match("/^(?!000)[0-9]{3}$/", $vCVV))
//                    {
//                        $errorMsg .= "Invalid card CVV <br>";
//                        $success = false;
//                    }

                    if ($insertvisa){
                        $insertvisa = "INSERT INTO payment (UID, card_name, card_number, card_expiry, card_type) VALUES ('$userid', '$vcardname', '$vcardnum', '$vexpirydate', '$type')";
                        if (mysqli_query($db, $insertvisa)) {
                            echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New card saved successfully! </div>";
                            $visaquery = "SELECT * FROM payment WHERE UID = $userid AND card_type='Visa'";
                            $visaresult = mysqli_query($db, $visaquery);
                            if(mysqli_num_rows($visaresult) > 0){
                                $row = mysqli_fetch_assoc($visaresult);
                                $visacard_type = $row['card_type'];
                                $visacardname = $row['card_name'];
                                $visacardnum = $row['card_number'];
                                $visacardnum = decrypt($visacardnum, $encryptionkey);
                                $visaexpirydate = $row['card_expiry'];
                                mysqli_free_result($visaresult);
                                mysqli_close($db);
                            }
                        }

                        else {
                            echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                        }
                    }
                }
            }
        }
    }


    //check if address in database is empty
    if (empty($address)){
        echo "<div class='col-lg-6'>";
        echo "<div class='form-group'>";
        echo "<h2>Billing Address</h2>";
        echo "<label class='form-check-label' for='noaddress'>Street Address</label><br>";
        echo "<input type='text' name='address' id='noaddress' class='form-control' placeholder='Street address, P.O box, unit, floor' pattern='[A-Za-z0-9\-\(\)#@(\) ]+' required><br>";
        echo "<label class='form-check-label' for='nocode'>Postal Code</label><br>";
        echo "<input type='text' name='code' id='nocode' class='form-control' placeholder='Postal Code' pattern='[0-9]{5,6}' required><br>";
        echo "</div></div>";
    }

    else{

        echo "<div class='col-lg-6'>";
        echo "<div class='form-group'>";
        echo "<h2>Billing Address</h2>";
        echo "<label class='form-check-label' for='address'>Street Address: </label>";
        echo "<input type='text' name='address' id='address' class='form-control' value='". $address . "' placeholder='Street address, P.O box, unit, floor' pattern='[A-Za-z0-9\-\(\)#@(\) ]+' required><br>";
        echo "<label class='form-check-label' for='code'>Postal Code: </label>";
        echo "<input type='text' name='code' id='code' class='form-control' value='". $postal . "' placeholder='Postal Code' pattern='[0-9]{5,6}' required><br>";
        echo "</div></div>";
    }
    //if user has two existing cards in database
    if (!empty($visacard_type) && (!empty($mastercard_type)))
    {
        echo "<div class='col-lg-6'>";
        echo "<div class='form-group'>";
        echo "<h2>Payment</h2>";
        echo "<label for='cards'>Selected Card: </label>";
        echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
        echo "<span class='fa fa-cc-mastercard' style='color:black;'></span> ";
        echo "<select class='form-control' name='cardtype' id='cards' onchange='changecard()'>";
        echo "<option value='Visa'>Visa</option>";
        echo "<option value='Mastercard'>MasterCard</option>";
        echo "</select><br>";
        echo "<br><script>
        $('#cards').on('change', function () {
        var value = $(this).val();
        var data = '';
        if (value == 'Mastercard')
        {

          data+='<label >Name on credit card: </label>';
        data+='<p>$MCcardname</p>';
        data+='<label >Card Number (ending with): </label>';
        data+='<p>$MCcardnum </p>'
       data+='<label >Expiry Date</label>';
     data+='<p> $MCexpirydate </p>';


        }
        else
        {
          
            data+='<label >Name on credit card: </label>';
          data+='<p>$visacardname</p>';
          data+='<label >Card Number (ending with): </label>';
          data+='<p>$visacardnum </p>'
         data+='<label >Expiry Date</label>';
       data+='<p> $visaexpirydate </p>';
        }
        $('#display').html(data);
        });
        </script>";
          echo "<div id ='display'></div>";
        echo "<label class='form-check-label' for='cvvs'>CVV / CVC*</label><br>";
        echo "<input type='password' name='cvv' id='cvvs' class='form-control' placeholder='CVV' pattern = '(?!000)[0-9]{3}' required><br>";
        echo "<button type='submit' class='btn btn-primary' name='pay'>Make Payment</button><br><br>";
        echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
        echo "</div></div>";
    }
    else
    {
        //if user only has visa card
        if(!empty($visacard_type))
        {
            echo "<div class='col-lg-6'>";
            echo "<div class='form-group'>";
            echo "<h2>Payment</h2>";
            echo "<label for='vcards'>Selected Card: </label> <a href='#changecardmodal' data-toggle='modal' data-target='#changecardmodal'><span class='glyphicon glyphicon-pencil'>Edit </span></a>";
            echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
            echo "<span class='fa fa-cc-mastercard' style='color:black;'></span> ";
            echo "<select class='form-control' name='cardtype' id='vcards'>";
            echo "<option value='Visa'>Visa</option>";
            echo "</select><br>";
            echo "<label class='form-check-label'>Name on credit card: </label>";
            echo "<p>" . $visacardname . "</p>";
            echo "<label class='form-check-label'>Card Number (ending with): </label>";
            echo "<p>" . $visacardnum . "</p>";
            echo "<label class='form-check-label'>Expiry Date</label>";
            echo "<p>" . $visaexpirydate . "</p>";
            echo "<label class='form-check-label' for='vcvv'>CVV / CVC*</label><br>";
            echo "<input type='password' name='cvv' id='vcvv' class='form-control' placeholder='CVV' pattern = '(?!000)[0-9]{3}' required><br>";
            echo "<button type='submit' class='btn btn-primary' name='pay'>Make Payment</button><br><br>";
            echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
            echo "</div></div>";
        }
        else{
            //if user only has mastercard
            if ((!empty($mastercard_type))){
                echo "<div class='col-lg-6'>";
                echo "<div class='form-group'>";
                echo "<h2>Payment</h2>";
                echo "<label for='mcards'>Selected Card: </label> <a href='#changecardmodal' data-toggle='modal' data-target='#changecardmodal'><span class='glyphicon glyphicon-pencil'>Edit </span></a>";
                echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
                echo "<span class='fa fa-cc-mastercard' style='color:black;'></span> ";
                echo "<select class='form-control' name='cardtype' id='mcards'>";
                echo "<option value='Mastercard'>Mastercard</option>";
                echo "</select><br>";
                echo "<label class='form-check-label'>Name on credit card: </label>";
                echo "<p>" . $MCcardname . "</p>";
                echo "<label class='form-check-label'>Card Number: </label>";
                echo "<p>" . $MCcardnum . "</p>";;
                echo "<label class='form-check-label'>Expiry Date</label>";
                echo "<p>" . $MCexpirydate . "</p>";
                echo "<label class='form-check-label' for='mcvv'>CVV / CVC*</label><br>";
                echo "<input type='password' name='cvv' id='mcvv' class='form-control' placeholder='CVV' pattern = '(?!000)[0-9]{3}' required><br>";
                echo "<button type='submit' class='btn btn-primary' name='pay'>Make Payment</button><br><br>";
                echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
                echo "</div></div>";
            }
            else
            {
                //if user has no cards stored
                echo "<div class='col-lg-6'>";
                echo "<div class='form-group'>";
                echo "<h2>Payment</h2>";
                echo "<label for='nocards'>Accepted Cards:* </label>";
                echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
                echo "<span class='fa fa-cc-mastercard' style='color:black;'></span>";
                echo "<select class='form-control' name='cardtype' id='nocards'>";
                echo "<option value='Visa'>Visa</option>";
                echo "<option value='Mastercard'>MasterCard</option>";
                echo "</select><br>";
                echo "<label class='form-check-label' for='nocn'>Name on credit card*</label><br>";
                echo "<input type='text' name='cardname' id='nocn' class='form-control' placeholder='Full Name on Card' required><br>";
                echo "<label class='form-check-label' for='nonum'>Card Number*</label><br>";
                echo "<input type='text' name='cardnum' id='nonum' class='form-control' placeholder='Card Number' pattern='4[0-9]{15}' required><br>";
                echo "<label class='form-check-label' for='noexpire'>Expiry Date*</label><br>";
                echo "<input type='text' name='expiredate' id='noexpire' class='form-control' placeholder='MM/YY' pattern = '(0[1-9]|1[012])[/]([2-9][0-9])' required><br>";
                echo "<label class='form-check-label' for='cvv'>CVV / CVC*</label><br>";
                echo "<input type='password' name='cvv' id='cvv' class='form-control' placeholder='CVV' pattern = '(?!000)[0-9]{3}' required><br>";
                echo "<button type='submit' class='btn btn-primary' name='pay'>Make Payment</button><br><br>";
                echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
                echo "</div></div>";
            }
        }
    }

    if (!$success){
        echo "<div class='container-fluid'>";
        echo "<div class=row>";
        echo "<div class=col-lg-12>";
        echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Card update was unsuccessful! </div>";
        echo "<h2>The following errors were detected:</h2>";
        echo "<p>" . $errorMsg . "</p>";
        echo "<a href='payment.php'><button class='btn btn-default'>Back to Payment</button></a><br>";
        echo "</div></div></div>";
    }

        function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
    </form>
        </div>

        <div class="modal fade" id="changecardmodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h1 class="modal-title">Change Card Type</h1>
                    </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action='#' method='POST'>
                            <div class='col-lg-6'>
                                <div class='form-group'>
                                    <label for='card'>Accepted Cards: </label>
                                    <span class='fa fa-cc-visa' style='color:navy;'></span>
                                    <span class='fa fa-cc-mastercard' style='color:black;'></span>

                                    <select class="form-control" name="cardtype" id="card" onchange="changecard();">
                                        <option value='Visa'>Visa</option>
                                        <option value='Mastercard'>Mastercard</option>
                                    </select><br>

                                    <label class='form-check-label' for='cn'>Name on credit card</label><br>
                                    <input type='text' name='cardname' id='cn' class='form-control' placeholder='Full Name on Card' required><br>

                                    <label class='form-check-label' for='num'>Card Number</label><br>
                                    <input type='text' name='cardnum' id='num' class='form-control' placeholder='Card Number' pattern="4[0-9]{15}" required><br>
                                    <!--<input type='text' name='cardnum'id='num' class='form-control' placeholder='Card Number' pattern = '5[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11}' required style="display:none"><br>-->

                                    <label class='form-check-label' for='expire'>Expiry Date</label><br>
                                    <input type='text' name='expiredate' id='expire' class='form-control' placeholder='MM/YY' pattern = '(0[1-9]|1[012])[/]([2-9][0-9])' required><br>

                                    <button type='submit' name='change' class='btn btn-primary'>Change</button><br><br>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </article>
</section>
</body>
<!--footer-->
<?php include "footer.php" ?>
<!--end footer-->


</html>
