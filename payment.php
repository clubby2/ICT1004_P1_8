
<?php
session_start();
if (!isset($_SESSION['email'])) {
header ('location:index.php');
}
if(isset($_POST['logout'])){
header ('location:index.php');
}
if (isset($_POST['toPayment'])) {
$userid=$_SESSION['UID'];
require 'config.php';

$idsql= "SELECT * FROM cart WHERE checks = 1 AND UID=$userid"; // query cart item and add
  $sqlitem= mysqli_query($db,$idsql);
  $checkitem = mysqli_fetch_assoc($sqlitem);
  if (empty($checkitem)) {
    echo '<script language="javascript">';
    echo 'alert("Please check out an item!")';
    echo '</script>';
    header ('location:cart.php');
   //echo '<input type="hidden" name="errorcart" value="">
   //<small id="errorcart" class="form-text text-danger" hidden></small>  </form>';
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
<script src="js/bootstrap.min.js"></script>
<script src="js/payment.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
<!---- header --->
<?php  ?>
<?php include "header.php" ?>
<?php include "config.php" ?>


<!--- content here --->
<section>
    <article>

<?php


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
        $visaexpirydate = $visarow['card_expiry'];
        $visaCVV = $visarow['cvv'];
        mysqli_free_result($visaresult);

    }
    $masterresult = mysqli_query($db, $masterquery);
    if(mysqli_num_rows($masterresult) > 0){
        $masterrow = mysqli_fetch_assoc($masterresult);
        $mastercard_type = $masterrow['card_type'];
        $MCcardname = $masterrow['card_name'];
        $MCcardnum = $masterrow['card_number'];
        $MCexpirydate = $masterrow['card_expiry'];
        $MCCVV = $masterrow['cvv'];
        mysqli_free_result($masterresult);

    }

    //if user updates or change card in the modal.
    if (isset($_POST['change']))
    {
        $type = $_POST['cardtype'];
        $visaquery = "SELECT * FROM payment WHERE UID='$_SESSION[login_user]' AND card_type='Visa'";

        $visaresult = mysqli_query($db, $visaquery);
        if(mysqli_num_rows($visaresult) > 0){
            $visarow = mysqli_fetch_assoc($visaresult);
            $visacard_type = $visarow['card_type'];
            mysqli_free_result($visaresult);
        }
        //if user select mastercard
        if ($type == 'Mastercard')
        {
            //query to check if user has mastercard stored in database
            $masterquery = "SELECT * FROM payment WHERE UID='$_SESSION[login_user]' AND card_type='Mastercard'";
            $masterresult = mysqli_query($db, $masterquery);
            if(mysqli_num_rows($masterresult) > 0){
                $masterrow = mysqli_fetch_assoc($masterresult);
                $mastercard_type = $masterrow['card_type'];
                $MCcardname = $masterrow['card_name'];
                $MCcardnum = $masterrow['card_number'];
                $MCexpirydate = $masterrow['card_expiry'];
                $MCCVV = $masterrow['cvv'];
                mysqli_free_result($masterresult);
            }
            //if user have existing mastercard in database
            if (!empty($mastercard_type))
            {
                $MCcardname = sanitize_input($_POST['cardname']);
                $MCcardnum = sanitize_input($_POST['cardnum']);
                $MCexpirydate = sanitize_input($_POST['expiredate']);
                $MCCVV = sanitize_input($_POST['cvv']);
                if (empty($MCcardname) || empty($MCcardnum) || empty($MCexpirydate) || empty($MCCVV))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                }
                else{
                    $updatemaster = "UPDATE payment SET card_name = '$MCcardname', card_number = '$MCcardnum' , cvv='$MCCVV', card_expiry='$MCexpirydate' WHERE UID='$_SESSION[login_user]' AND card_type='Mastercard'";
                    if (mysqli_query($db, $updatemaster)) {
                        echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Card updated successfully! </div>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                    }
                }
                mysqli_close($db);
            }
            else
            {
                $MCcardname = sanitize_input($_POST['cardname']);
                $MCcardnum = sanitize_input($_POST['cardnum']);
                $MCexpirydate = sanitize_input($_POST['expiredate']);
                $MCCVV = sanitize_input($_POST['cvv']);
                if (empty($MCcardname) || empty($MCcardnum) || empty($MCexpirydate) || empty($MCCVV))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                }
                else{
                    $insertmaster = "INSERT INTO payment (UID, card_name, card_number, cvv, card_expiry, card_type) VALUES ('$_SESSION[login_user]', '$MCcardname', '$MCcardnum', '$MCCVV', '$MCexpirydate', '$type')";
                    if (mysqli_query($db, $insertmaster)) {
                        echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New card saved successfully! </div>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                    }
                }
                mysqli_close($db);
            }
        }
        else
        {
            //query to check if user has visa stored in database
            $visaquery = "SELECT * FROM payment WHERE UID = '$_SESSION[login_user]' AND card_type='Visa'";
            $visaresult = mysqli_query($db, $visaquery);
            if(mysqli_num_rows($visaresult) > 0){
                $row = mysqli_fetch_assoc($visaresult);
                $visacard_type = $row['card_type'];
                $visacardname = $row['card_name'];
                $visacardnum = $row['card_number'];
                $visaexpirydate = $row['card_expiry'];
                $visaCVV = $row['cvv'];
                mysqli_free_result($visaresult);
            }

            //if user has existing visa card
            if (!empty($visacard_type))
            {
                $visacardname = sanitize_input($_POST['cardname']);
                $visacardnum = sanitize_input($_POST['cardnum']);
                $visaexpirydate = sanitize_input($_POST['expiredate']);
                $visaCVV = sanitize_input($_POST['cvv']);
                if (empty($visacardname) || empty($visacardnum) || empty($visaexpirydate) || empty($visaCVV))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                }
                else{
                    $updatevisa = "UPDATE payment SET card_name = '$visacardname', card_number = '$visacardnum' , cvv='$visaCVV', card_expiry='$visaexpirydate' WHERE UID='$_SESSION[login_user]' AND card_type='Visa'";
                    if (mysqli_query($db, $updatevisa)) {
                        echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Card updated successfully! </div>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                    }
                }
                mysqli_close($db);
            }
            else{
                $visacardname = sanitize_input($_POST['cardname']);
                $visacardnum = sanitize_input($_POST['cardnum']);
                $visaexpirydate = sanitize_input($_POST['expiredate']);
                $visaCVV = sanitize_input($_POST['cvv']);
                if (empty($visacardname) || empty($visacardnum) || empty($visaexpirydate) || empty($visaCVV))
                {
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                }
                else{
                    $insertvisa = "INSERT INTO payment (UID, card_name, card_number, cvv, card_expiry, card_type) VALUES ('$_SESSION[login_user]', '$visacardname', '$visacardnum', '$visaCVV', '$visaexpirydate', '$type')";
                    if (mysqli_query($db, $insertvisa)) {
                        echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>New card saved successfully! </div>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                    }
                }
                mysqli_close($db);
            }
        }
    }

    //check if address in database is empty
    if (empty($address)){
        echo "<div class='container-fluid'>";
        echo "<form action='process_payment.php' method='POST'>";
        echo "<div class='col-lg-6'>";
        echo "<div class='form-group'>";
        echo "<h2>Billing Address</h2>";
        echo "<label class='form-check-label' for='address'>Street Address</label><br>";
        echo "<input type='text' name='address' id='address' class='form-control' placeholder='Street address, P.O box, unit, floor' required><br>";
        echo "<label class='form-check-label' for='code'>Postal Code</label><br>";
        echo "<input type='text' name='code' id='code' class='form-control' placeholder='Postal Code' required><br>";
        echo "</div></div>";
    }

    else{
        echo "<div class='container-fluid'>";
        echo "<form action='process_payment.php' method='POST'>";
        echo "<div class='col-lg-6'>";
        echo "<div class='form-group'>";
        echo "<h2>Billing Address</h2>";
        echo "<label class='form-check-label' for='address'>Street Address: </label>";
        echo "<input type='text' name='address' id='address' class='form-control' value='". $address . "' placeholder='Street address, P.O box, unit, floor' required><br>";
        echo "<label class='form-check-label' for='code'>Postal Code: </label>";
        echo "<input type='text' name='code' id='code' class='form-control' value='". $postal . "' placeholder='Postal Code' required><br>";
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
        echo "<select class='form-control' name='cardtype' id='cards' onchange='ChangeCard()'>";
        echo "<option value='Visa'>Visa</option>";
        echo "<option value='Mastercard'>MasterCard</option>";
        echo "</select><br>";
        echo "<button type='submit' class='btn btn-primary'>Make Payment</button><br><br>";
        echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
        echo "</div></div></form></div>";
    }
    else
    {
        //if user only has visa card
        if(!empty($visacard_type))
        {
            echo "<div class='col-lg-6'>";
            echo "<div class='form-group'>";
            echo "<h2>Payment <a href='#changecardmodal' data-toggle='modal' data-target='#changecardmodal'><span class='glyphicon glyphicon-pencil'>Edit </span></a></h2>";
            echo "<label for='cards'>Selected Card: </label>";
            echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
            echo "<span class='fa fa-cc-mastercard' style='color:black;'></span> ";
            echo "<select class='form-control' name='cardtype' id='cards'>";
            echo "<option value='Visa'>Visa</option>";
            echo "</select><br>";
            echo "<label class='form-check-label' for='cn'>Name on credit card: </label>";
            echo "<p>" . $visacardname . "</p>";
            echo "<label class='form-check-label' for='num'>Card Number (ending with): </label>";
            echo "<p>" . maskedCardNum($visacardnum) . "</p>";;
            echo "<label class='form-check-label' for='expire'>Expiry Date</label>";
            echo "<p>" . $visaexpirydate . "</p>";
            echo "<button type='submit' class='btn btn-primary'>Make Payment</button><br><br>";
            echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
            echo "</div></div></form></div>";
        }
        else{
            //if user only has mastercard
            if ((!empty($mastercard_type))){
                echo "<div class='col-lg-6'>";
                echo "<div class='form-group'>";
                echo "<h2>Payment <a href='#changecardmodal' data-toggle='modal' data-target='#changecardmodal'><span class='glyphicon glyphicon-pencil'>Edit </span></a></h2>";
                echo "<label for='cards'>Selected Card: </label>";
                echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
                echo "<span class='fa fa-cc-mastercard' style='color:black;'></span> ";
                echo "<select class='form-control' name='cardtype' id='cards'>";
                echo "<option value='Mastercard'>Mastercard</option>";
                echo "</select><br>";
                echo "<label class='form-check-label' for='cn'>Name on credit card: </label>";
                echo "<p>" . $MCcardname . "</p>";
                echo "<label class='form-check-label' for='num'>Card Number: </label>";
                echo "<p>" . maskedCardNum($MCcardnum) . "</p>";;
                echo "<label class='form-check-label' for='expire'>Expiry Date</label>";
                echo "<p>" . $MCexpirydate . "</p>";
                echo "<button type='submit' class='btn btn-primary'>Make Payment</button><br><br>";
                echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
                echo "</div></div></form></div>";
            }
            else
            {
                //if user has no cards stored
                echo "<div class='col-lg-6'>";
                echo "<div class='form-group'>";
                echo "<h2>Payment</h2>";
                echo "<label for='cards'>Accepted Cards: </label>";
                echo " <span class='fa fa-cc-visa' style='color:navy;'></span> ";
                echo "<span class='fa fa-cc-mastercard' style='color:black;'></span>";
                echo "<select class='form-control' name='cardtype' id='cards'>";
                echo "<option value='Visa'>Visa</option>";
                echo "<option value='Mastercard'>MasterCard</option>";
                echo "</select><br>";
                echo "<label class='form-check-label' for='cn'>Name on credit card</label><br>";
                echo "<input type='text' name='cardname' id='cn' class='form-control' placeholder='Full Name on Card' required><br>";
                echo "<label class='form-check-label' for='num'>Card Number</label><br>";
                echo "<input type='text' name='cardnum'id='num' class='form-control' placeholder='Card Number' required><br>";
                echo "<label class='form-check-label' for='expire'>Expiry Date</label><br>";
                echo "<input type='text' name='expiredate' id='expire' class='form-control' placeholder='MM/YY' required><br>";
                echo "<label class='form-check-label' for='cvv'>CVV / CVC *</label><br>";
                echo "<input type='password' name='cvv' id='cvv' class='form-control' placeholder='CVV' required><br>";
                echo "<button type='submit' class='btn btn-primary'>Make Payment</button><br><br>";
                echo "<a href='cart.php'><button type='button' class='btn btn-danger'>Back</button></a>";
                echo "</div></div></form>";
            }
        }
    }

?>

<?php

    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function maskedCardNum($ccnum){
    $masked =  str_pad(substr($ccnum, -4), strlen($ccnum), '*', STR_PAD_LEFT);
    return $masked;
    //return str_replace(range(0,9), "*", substr($cardnum, 0, -4)) .  substr($cardnum, -4);
    }
?>
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
                                    <label for='cards'>Accepted Cards: </label>
                                    <span class='fa fa-cc-visa' style='color:navy;'></span>
                                    <span class='fa fa-cc-mastercard' style='color:black;'></span>

                                    <select class='form-control' name='cardtype' id='cards'>
                                        <option value='Visa'>Visa</option>
                                        <option value='Mastercard'>Mastercard</option>
                                    </select><br>

                                    <label class='form-check-label' for='cn'>Name on credit card</label><br>
                                    <input type='text' name='cardname' id='cn' class='form-control' placeholder='Full Name on Card' required><br>

                                    <label class='form-check-label' for='num'>Card Number</label><br>
                                    <input type='text' name='cardnum'id='num' class='form-control' placeholder='Card Number' required><br>

                                    <label class='form-check-label' for='expire'>Expiry Date</label><br>
                                    <input type='text' name='expiredate' id='expire' class='form-control' placeholder='MM/YY' required><br>

                                    <label class='form-check-label' for='cvv'>CVV / CVC *</label><br>
                                    <input type='password' name='cvv' id='cvv' class='form-control' placeholder='CVV' required><br>
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
<!--- footer--->
<?php include "footer.php" ?>
<!--- end footer--->


</html>
