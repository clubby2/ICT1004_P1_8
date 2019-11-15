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
<script scr="js/bootstrap.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
      
<!---- header --->
<?php include "header.php" ?>
<?php include "config.php" ?>

<!--- content here --->
<?php
//pattern='/^[0-9]{3}$/' CVV pattern

$address = $postal = $card = $cardname = $cardnum = $expirydate = $CVV = "";
$total = 0;
$subtotal = 0;
$date = date("Y-m-d");
$errorMsg = "";
$success = false;
    
    if (empty(sanitize_input($_POST["address"])) || empty(sanitize_input($_POST["code"])))
    {
        $errorMsg .= "Please enter addreses and postal code. <br>";
    }
    else
    {
        $address = sanitize_input($_POST["address"]);
        $postal = sanitize_input($_POST["code"]);
        $cardtype = $_POST['cardtype'];
        if ((isset($_POST["cardname"])))
        {
            if (empty(sanitize_input($_POST["cardname"])) || empty(sanitize_input($_POST["cardnum"])) || empty(sanitize_input($_POST["expiredate"])) || empty(sanitize_input($_POST["cvv"])))
            {
                $errorMsg .= "Please fill up all the relevant fields.<br>";
            }
            else
            {
                $cardname = sanitize_input($_POST["cardname"]);
                $cardnum = sanitize_input($_POST["cardnum"]);
                $expirydate = sanitize_input($_POST["expiredate"]);
                $CVV = sanitize_input($_POST["cvv"]);
                $payquery = "INSERT into payment (UID, card_name, card_number, cvv, card_expiry, card_type) VALUES ('$_SESSION[login_user]', '$cardname', '$cardnum', '$CVV', '$expirydate', '$cardtype')";
                $addrquery = "UPDATE user SET address='$address', postal_code='$postal' WHERE UID='$_SESSION[login_user]'";
                
                //update card and address details in database
                if (mysqli_query($db, $payquery))
                {
                    echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Card saved successfully! </div>";
                    $success = true;
                }
                else{
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Transaction unsuccessful! </div>";
                    $success = false;
                    
                }
                
                if (mysqli_query($db, $addrquery))
                {
                    echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Card saved successfully! </div>";
                }
                else{
                    echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                    $success = false;
                }
                
            }
        }
        else
        {
            //select card details based on select option ($card type)
            $addrquery = "UPDATE user SET address='$address', postal_code='$postal' WHERE UID='$_SESSION[login_user]'";
            if (mysqli_query($db, $addrquery))
            {
                $success = true;
            }
            else{
                echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error, unsuccessful! </div>";
                $success = false;
            }
        }
    }

    if ($success)
    {
        //get relevant data from cart and add to history payment table.
        $query = "SELECT * FROM cart WHERE UID='$_SESSION[login_user]' AND checks='1'";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0)
        {
            echo "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Your payment was successful!</div>";
            echo "<div class=container-fluid>";
            echo "<div class=row>";
            echo "<div class=col-lg-12>";
            echo "<h2>Thank you for your purchase!</h2>";
            echo "<table border=0 width=50%>";
            echo "<thead><tr><th colspan='5'>Items</th>";
            echo "<th colspan='2' align='center'>Quantity</th>";
            echo "<th colspan='2' align='center'>Item Price</th></tr></thead><tbody>";
            while($row = mysqli_fetch_assoc($result))
            {
                
                $item = $row['item_name'];
                $price = $row['item_price'];
                $quantity = $row['item_quantity'];
                $total = ($quantity * $price);
                $subtotal += $total;
                $transaction = "INSERT INTO history_payment (UID, item_price, item_name, total_price, date_purchased) VALUES ('$_SESSION[login_user]', '$price', '$item', '$total', '$date')";
                $paymentresult = mysqli_query($db, $transaction);
                echo "<tr><td colspan='5'>" . $item . "</td>";
                echo "<td colspan='2'>" . $quantity . "</td>";
                echo "<td colspan='2'>$ " . $price . "</td></tr>";
                
            }
            echo "<tr style='border-top: 1px solid black'><td colspan='7' rowspan='1' align='left'>Subtotal: </td>";
            echo "<td> $" . $subtotal . "</td></tr>";
            echo "</body></table><br>";
            mysqli_free_result($result);
            mysqli_close($db);
            
            
            echo "<a href='transaction.php'><button class='btn btn-default'>View Transaction History</button></a> ";
            echo "<a href='index.php'><button class='btn btn-default'>Home</button></a><br>";
            echo "</div></div></div>";
        }
        
    }
    else
    {
        echo "<div class='container-fluid'>";
        echo "<div class=row>";
        echo "<div class=col-lg-12>";
        echo "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Oops! Payment was unsuccessful! </div>";
        echo "<h2>The following errors were detected:</h2>";
        echo "<p>" . $errorMsg . "</p>";
        echo "<a href='payment.php'><button class='btn btn-default'>Back to Payment</button></a><br>";
        echo "</div></div></div>";
    }



//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function luhn_check($number) {

  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
  $number=preg_replace('/\D/', '', $number);

  // Set the string length and parity
  $number_length=strlen($number);
  $parity=$number_length % 2;

  // Loop through each digit and do the maths
  $total=0;
  for ($i=0; $i<$number_length; $i++) {
    $digit=$number[$i];
    // Multiply alternate digits by two
    if ($i % 2 == $parity) {
      $digit*=2;
      // If the sum is two digits, add them together (in effect)
      if ($digit > 9) {
        $digit-=9;
      }
    }
    // Total up the digits
    $total+=$digit;
  }

  // If the total mod 10 equals 0, the number is valid
  return ($total % 10 == 0) ? TRUE : FALSE;

}
?>

</body>
<!--- footer--->
<?php include "footer.php" ?>
<!--- end footer--->

</html>