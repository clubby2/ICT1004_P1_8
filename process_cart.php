<?php
session_start();
require 'config.php';
$flag = false;
if (isset($_POST['my_pid'])) {
  $item_price= $_POST['my_itemp'];
  $item_name=$_POST['my_itemname'];
  $item_id = $_POST['my_pid'];
  $item_quantity=$_POST['val_item'];
  if (empty($_SESSION['UID'])) {
    echo "<script type='text/javascript'>alert('Please Register or login to add cart!!');
window.location='product.php';
</script>";
    //header('location: product.php#modal-register');
  }
  else{ // start here to add cart if id is not empty
$userid =$_SESSION['UID'];// prefix for now


//echo $userid.$item_price.$item_name.$item_id.$item_quantity;
$idsql= "SELECT * FROM cart WHERE item_id = $item_id AND UID=$userid"; // query cart item and add
  $sqlitem= mysqli_query($db,$idsql);
  $checkitem = mysqli_fetch_assoc($sqlitem);
  $mainsql= "SELECT * FROM item WHERE item_id = $item_id"; // query cart item and - current stock
    $mainitem= mysqli_query($db,$mainsql);
    $item = mysqli_fetch_assoc($mainitem);
  if (!empty($checkitem['item_id'])){
  //echo  $checkitem['item_quantity'];
  $checkid=$checkitem['item_id'];
  $totalquantity= $item_quantity+$checkitem['item_quantity']; //current item + db item to cart
  $maintotalquantity=$item['item_quantity']-$item_quantity; // db item  - current item to item db
  //if got the item update and add valule to the cart
  mysqli_query($db, "UPDATE item SET item_quantity=$maintotalquantity WHERE item_id=$checkid");//minus the stock
 mysqli_query($db, "UPDATE cart SET item_quantity='$totalquantity' WHERE item_id=$checkid");// add the item to cart
    $flag=true;
    $db->close();
  }
  else{
  //  echo "can add";
  $newitemid=$item['item_id'];
  $maintotalquantity=$item['item_quantity']-$item_quantity;
echo $newitemid;
    $sql = "INSERT INTO cart (UID,item_id,item_quantity,item_price,item_name) VALUES ($userid,$item_id,'$item_quantity','$item_price','$item_name')";
  mysqli_query($db, $sql);  // add sql
  $subsql ="UPDATE item SET item_quantity=$maintotalquantity WHERE item_id=$newitemid";
//mysqli_query($db, "UPDATE item SET item_quantity=$maintotalquantity WHERE item_id=$checkid");

    if ($db->query($subsql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $subsql . "<br>" . $db->error;
    }

    $db->close(); // done close it
    //header("location: product.php");
    }
  }
}
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Adding to cart</title>
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

    <!--- content here --->
    <div class="container-fluid  text-center" id="cart">
               <div class="row ">
                   <div class="col-lg-12 ">
                           <?php if ($flag == false){ ?>
                       <h1>Successfully added to cart!</h1>
                   </div>
               </div>
               <div class="row">
                   <div class="col-lg-12">

                        <a href="product.php#products"><button type="button" class="btn btn-primary">Contiune Shopping!</button></a>
                     <a href="cart.php"> <button type="button" class="btn btn-info">View Cart</button></a>
                   </div>
               </div>
             <?php } else { ?>
               <h1>You have added exists item to cart!</h1>
           </div>
       </div>
       <div class="row">
           <div class="col-lg-12">

             <a href="product.php#products"><button type="button" class="btn btn-primary">Contiune Shopping!</button></a>
          <a href="cart.php"> <button type="button" class="btn btn-info">View Cart</button></a>

           </div>
       </div>
             <?php } ?>
       </div>
    <!--- footer-
    <!--- footer--->
   <?php include "footer.php" ?>
    <!--- end footer--->



   </body>
 </html>
