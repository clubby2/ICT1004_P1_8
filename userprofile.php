<?php

if(isset($_POST['logout'])){
  //session_start();
//  echo "HALLLLLO";
session_destroy();
unset($_SESSION['email']);
unset($_SESSION['role']);
unset($_SESSION['UID']);
header('Location:index.php');
}

//session_start();
if (isset($_POST['save_account_details'])) {
  require "config.php";
$errorlastname="";
$erroremail="";
$successmsg="";
//echo "test";
$flag = true;
//$erroremail=$_POST['erroremaill'];
$email=$_POST['account_email'];
$firstname=$_POST['account_first_name'];
$lastname=$_POST['account_last_name'];
$sqlID = "SELECT * FROM user WHERE email='$email' LIMIT 1"; // CHGECK UID
$sqlqueryID= mysqli_query($db,$sqlID);
$usersqlID = mysqli_fetch_assoc($sqlqueryID);

$sql = "SELECT * FROM user WHERE email='$email'AND UID!=$usersqlID[UID] LIMIT 1";
$sqlquery= mysqli_query($db,$sql);
$usersql = mysqli_fetch_assoc($sqlquery);

if ($usersql['email']== $email) {
    $erroremail ="Email already exists";
    $flag = false;
}

if (empty($email)) {
    $erroremail ="Email is required";
    $flag = false;
}
else if(!filter_var($email,FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})+$/")))){
$erroremail = "Email is invalid.";
$flag = false;
}
if (empty($lastname)) {
    $errorlastname ="Last name is required";
    $flag = false;
}
  if ($flag == "true") {
    $sqlup="UPDATE user SET email='$email',last_name='$lastname',first_name='$firstname'  WHERE UID= $usersqlID[UID]";

  //echo "aaa";
    mysqli_query($db, $sqlup);
    $db->close();
    $successmsg="Successfully Updated!";
  }

}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Product</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/index.css" rel="stylesheet" >
        <link href="css/profile.css" rel="stylesheet" >
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script defer src="js/index.js"></script>
        <script defer src="js/pymtshipping.js"></script>
        <script defer src="js/headnfoot.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php

        include "header.php";
        include "config.php";
        include "encrypt.php";

        // to save password using the UID
        if (isset($_POST['save_password_details'])) {
          $checkPWS=true;
          $errorPW="";
          $sqlPW = "SELECT * FROM user WHERE UID=$_SESSION[UID] LIMIT 1";
          $sqlqueryPW= mysqli_query($db,$sqlPW);
          $usersqlpw = mysqli_fetch_assoc($sqlqueryPW);
      // /  echo $sqlPW;
        $oldpw=$_POST['password_current'];
        $newpw1=$_POST['password_new1'];
        $newpw2=$_POST['password_new2'];
      //  echo $newpw1."   ".$newpw2;
        if ($oldpw == "") {
          $errorPW="Password is Required";
        $checkPWS=false;
        }
        if($newpw1 == ""){
          $errorPW="Password is Required";
          $checkPWS=false;
        }
        if ( $newpw2 == "") {
          $errorPW="Password is Required";
          $checkPWS=false;
        }
        if ($newpw1!=$newpw2) {
            $errorPW="Password is not match";
             $checkPWS=false;
              echo $errorPW;
        }

        if (password_verify($oldpw, $usersqlpw['password'])) { // if password is correct
          echo "password correct";
          //echo $oldpw.$usersqlpw['password']);
          $errorPW="Wrong email/password combination";
        }
        else{
            $checkPWS=false;
        }
        if ($checkPWS == false) {
      //    echo " error";

        }
        else{
        //  echo " noerror"; // if no error update password
          $newpw1= password_hash($newpw1, PASSWORD_DEFAULT);
          $sqlupPW="UPDATE user SET password='$newpw1' WHERE UID= $_SESSION[UID] ";
          mysqli_query($db, $sqlupPW);
          $db->close();
        }

        }


        ?>

        <!-- content here -->
        <article class="container">

            <section class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
                    <li><a data-toggle="tab" href="#paymentnshipping">Payment & Shipping</a></li>
                </ul>
            </section>

            <article class="tab-content col-md-6">
              <?php
              $idsql= "SELECT * FROM user WHERE UID=$_SESSION[UID]"; // query cart item and add
                $sqlname= mysqli_query($db,$idsql);
                $listuser = mysqli_fetch_assoc($sqlname);


               ?>
                <!--BRANDON Part-->
                <section id="profile" class="tab-pane fade in active">
                    <h2>Account Details</h2><hr class="line">
                    <form action=" <?php echo  $_SERVER['PHP_SELF'];  ?>" method="post" >
                        <p class="form-group">
                            <label for="account_first_name">First name&nbsp;<span class="required">*</span></label>
                            <input type="text" class="form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo $listuser['first_name']; ?>" required/>

                        </p>
                        <p class="form-group">
                            <label for="account_last_name">Last name&nbsp;<span class="required">*</span></label>
                            <input type="text" class="form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" pattern="[a-zA-Z ]+$" value="<?php echo $listuser['last_name']; ?>" required/>
                                <?php
                                if (!empty($errorlastname)) {
                                  echo $errorlastname;
                                }

                               ?>
                        </p>
                        <p class="form-group">
                            <label for="account_email">Email address&nbsp;<span class="required">*</span></label>
                            <input type="email" class="form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo $listuser['email']; ?>" required/>
                              <?php
                            if (!empty($erroremail)) {
                               echo $erroremail;     } ?>

                        </p>

                      <?php
                        if (!empty($successmsg)) {
                          echo $successmsg;
                          echo '<br>';
                        }
                        ?>
                        <button type="submit" class="btn btn-primary" name="save_account_details" value="Save changes">Save changes</button>

                    </form>

                    <fieldset>
                  <form action=" <?php echo $_SERVER['PHP_SELF'];  ?>" method="post">

                        <legend>Password change</legend>

                        <p class="form-group">
                            <label for="password_current">Current password (leave blank to leave unchanged)</label>
                            <input type="password" class="form-control" name="password_current" id="password_current" autocomplete="off" minlength="5" required/>
                        </p>
                        <p class="form-group">
                            <label for="password_1">New password (leave blank to leave unchanged)</label>
                            <input type="password" class="form-control" name="password_new1" id="password_new1" autocomplete="off" minlength="5" required/>
                        </p>
                        <p class="form-group">
                            <label for="password_2">Confirm new password</label>
                            <input type="password" class="form-control" name="password_new2" id="password_new2" autocomplete="off"  minlength="5" required/>
                        </p>

                  <button type="submit" class="btn btn-primary" name="save_password_details" value="password_change">Change Password</button>
                      </form>
                    </fieldset>
                </section>

                <!--Sinn Fei's Part-->
                <section id="paymentnshipping" name="pymtNshipping" class="tab-pane fade">
                    <h3>Credit/Debit Card</h3><hr class="line">
                    <?php
//                    function maskedCardNum($ccnum) {
//                        $masked = str_pad(substr($ccnum, -4), strlen($ccnum), '*', STR_PAD_LEFT);
//                        return $masked;
//                    }

                    $query = "SELECT address, postal_code FROM p1_8.user WHERE UID='$_SESSION[UID]'";
                    $result = mysqli_query($db, $query);
                  //  echo $query;
                    //exit;
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $addr = $row['address'];
                        $postalcode = $row['postal_code'];
                    }

                    $query2 = "SELECT * FROM p1_8.payment WHERE UID='$_SESSION[UID]'";
                    $result2 = mysqli_query($db, $query2);
                    if (mysqli_num_rows($result2) > 0) {
                        $row2 = mysqli_fetch_assoc($result2);
                        $cardName = $row2['card_name'];
                        $cardNum = $row2['card_number'];
                        $cardNum = decrypt($cardNum, $encryptionkey);
                        $expDate = $row2['card_expiry'];
                        $cardtype = $row2['card_type'];

                        echo "<section id='cardDetails'>";
                        echo "<h5>Name on card: " . $cardName . "</h5>";
                        echo "<h5>Card Type: " . $cardtype . "</h5>";
                        echo "<h5>Card Number: " . $cardNum . "</h5>";
                        echo "<h5>Expiry Date: " . $expDate . "</h5>";
                        echo "</section>";
                    } else {
                        echo "<form name = 'myCardForm' action = 'process_card.php' method = 'post' onsubmit = 'return validateCardForm()'>";
                        echo "<div class = 'form-group'>";
                        echo "<label for = 'cardName'>Name on card*</label>";
                        echo "<input class = 'form-control' type = 'text' id = 'cardName' name = 'cardName' placeholder = 'Full name on card' pattern = '^[a-zA-Z ]*$' required/>";
                        echo "</div>";
                        echo "<div class = 'form-group'>";
                        echo "<label for = 'selectCards'>Card Type* </label>";
                        echo "<span class = 'fa fa-cc-visa' style = 'color:navy;'></span>";
                        echo "<span class = 'fa fa-cc-mastercard' style = 'color:black;'></span>";

                        echo "<select class = 'form-control' name = 'cardtype' id = 'selectCards'>";
                        echo "<option value = 'Visa'>Visa</option>";
                        echo "<option value = 'Mastercard'>MasterCard</option>";
                        echo "</select>";
                        echo "</div>";

                        echo "<div class = 'form-group'>";
                        echo "<label for = 'cardNum'>Card Number*</label>";
                        echo "<section class = 'input-group'>";
                        echo "<input class = 'form-control' type = 'text' id = 'cardNum' name = 'cardNum' placeholder = 'Card Number' pattern = '4[0-9]{15}' required/>";

                        echo "<section class = 'input-group-addon'>";
                        echo "<span id = 'cardIcon' class = 'icon'><i class = 'fa fa-cc-visa'></i></span>";
                        echo "</section>";
                        echo "</section>";
                        echo "</div>";

                        echo "<div class = 'row'>";
                        echo "<div class = 'col-md-3'>";
                        echo "<div class = 'form-group'>";
                        echo "<label for = 'expDate'>Expiry Date*</label>";
                        echo "<input class = 'form-control' type = 'text' id = 'expDate' name = 'expDate' placeholder = 'MM/YY' pattern = '(0[1-9]|1[012])[/]([2-9][0-9])' required />";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<button type = 'submit' class = 'btn btn-primary'>Save</button>";
                        echo "</form>";
                    }
                    ?>
                    <form>

                    </form>


                    <!-- Trigger the modal with a button -->
                    <button type="button" <?php if ((mysqli_num_rows($result2) == 0)) { ?> style='display:none;'<?php } ?> id="ccDelBtn" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Delete</button>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete? </h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the card?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No, Keep It</button>
                                    <form action="process_deleteCard.php" method="post" >
                                        <button type="submit" class="btn btn-danger" >Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <h3>Shipping Address</h3><hr class="line">
                    <form name="myAddrForm" action="process_address.php" method="post" onsubmit="return validateAddrForm()">
                        <p class="form-group">
                            <label for="addr">Street Address*</label>
                            <?php echo "<input class='form-control' type='text' id='addr' name='addr' placeholder='Street address, P.O box, unit, floor' value='" . $addr . "' pattern='[A-Za-z0-9\-\(\)#@(\) ]+' required/>"; ?>
                        </p>

                        <p class="form-group">
                            <label for="postalcode">Postal Code*</label>
                            <?php echo "<input class='form-control' type='text' id='postalcode' name='postalcode' placeholder='######' value='" . $postalcode . "' pattern='[0-9]{5,6}' required/>"; ?>
                        </p>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <br>
                    <p>* required</p>
                </section>
            </article>
            <div class=col-md-3></div>
        </article>

        <!-- footer-->
        <?php include "footer.php" ?>
        <!-- end footer-->



    </body>
</html>
