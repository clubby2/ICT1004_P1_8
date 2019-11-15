<?php
require 'config.php';
if(isset($_POST['c_id'])){
$cids= $_POST['c_id'];
//echo $cids;
$checking= isset($_POST['check']);
//echo $checking;
  if($checking==1){ // if the checkbox  click change it to 1 so that can bill to the history table
    $sqlup="UPDATE cart SET checks=1  WHERE CID= $cids";
    mysqli_query($db, $sqlup);

$db->close();
  }
  else{
  mysqli_query($db, "UPDATE cart SET checks=0  WHERE CID=$cids");
  $db->close();
  }
}


 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Carts</title>
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
<script defer src="js/index.js"></script>
<script defer src="js/headnfoot.js"></script>
 <script defer src="js/product.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
<!---- header --->
<?php include "header.php" ?>

   <!--- content here --->
   <div class="container-fluid text-center" id="cart">
     <h1>Shopping Cart</h1>

     <?php

      require 'config.php';
      if(empty($_SESSION['UID'])){
        echo '<div class="row ">
            <div class="col-lg-12 ">
                <h1>The cart is empty</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                 <a href="product.php"><button type="button" class="btn btn-primary">Shopping</button>
              <a href="index.php">  <button type="button" class="btn btn-info">Home</button></a>
            </div>

       </div>';
     } else{
      $userid = $_SESSION['UID']; // pressfix 1st not yet add session
      $sql = "SELECT a.CID, a.UID, a.item_id,a.checks ,a.item_quantity,a.item_price,a.item_name, b.item_image
FROM cart a left join item b on a.item_id = b.item_id
where a.UID = $userid GROUP BY b.item_id";

      // Execute the query
      if ($result = mysqli_query($db, $sql)) {
        if(mysqli_num_rows($result) > 0){
         while ($row = mysqli_fetch_array($result)) {
           echo'<div class="info-box">
           <div class="row">';
             $cid= $row['CID'];
            $item_price= $row['item_price'];
            $item_name= $row['item_name'];
            $item_quantity= $row['item_quantity'];
              $item_price= $row['item_price'];
            $item_image= $row['item_image'];
            $checks =$row['checks'];

            echo'<div class="col-lg-8">

               <table>
                 <tr>
             <th><img src="'.$item_image.'" alt="">
             </th>
          <th>        <p>'.$item_name.'</p>
                 <p>$'.$item_price.'</p></th>
                 </tr>
             </table>
             </div>
             <div class="col-lg-2">
               <p>Quantity</p>
               <button class="minus-btn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
               <input type="text" class="counter" value="'.$item_quantity.'" size="1" name="val_item">
               <button class="plus-btn" type="button"><span class="glyphicon glyphicon-plus"></span></button><br><br>
               <button type="submit" name="delcartModal"class="btn btn-info btn-md" data-toggle="modal" data-target="#delModal'.$cid.'">
              <span class="glyphicon glyphicon-trash"></span> Remove
                   </button>

             </div>
             <div class="col-lg-2">';
             echo '<form  action="cart.php" method="post">';
             echo '<input type="hidden" name="c_id" value="'.$cid.' "readonly>';
             if ($checks==1) {
               //echo "empty";
               $checked= "checked";
             }
             else{
                $checked= "";
             }
                echo'<div class="checkbox-custom" >
              <label>
             <input type="checkbox"name="check" '.$checked.' onchange="this.form.submit()">  <b></b>Tick to check out
             <span></span></label>';
             echo "</form>";
            echo'</div></div>
             </div></div>';
             // add modal for del
             echo'<div class="modal fade" id="delModal'.$cid.'">';
                echo  '<form action="modal.php" method="post">';
                  echo'<div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                              <h1 class="modal-title">Removing Item </h1>
                          </div>
                      <div class="modal-body ">
                          <input type="hidden" name="getcid" value="'.$cid.' " readonly>
                      <h3>Do you want to remove '.$item_name.'? </h3>
                        <div class="modal-footer">
                            <button type="submit"name="delcart" class="btn btn-danger text-center">Remove</button>
                    <button type="button" class="btn btn-default text-center" data-dismiss="modal">Close</button>
                      </div>
                      </div>
                      </div>
                  </div>
            </form> </div>';


         }
// show when
       echo  '<form action="modal.php" method="post">
      <button type="submit" class="btn btn-primary btn-lg" name="toPayment">Payment</button>
        </form>';
         $result->free_result();
           }
           else{
               //$errorMsg = "No item found!";
               //echo $errorMsg;

               echo '<div class="row ">
                   <div class="col-lg-12 ">
                       <h1>The cart is empty</h1>
                   </div>
               </div>
               <div class="row">
                   <div class="col-lg-12">
                        <a href="product.php"><button type="button" class="btn btn-primary">Shopping</button>
                     <a href="index.php">  <button type="button" class="btn btn-info">Home</button></a>
                   </div>

              </div>';

           }
         } // close sqlite_array_query
       }// lose if statement if id dun have
 $db->close();


      ?>



  </div>
   <!--- footer--->
<?php include "footer.php" ?>
   <!--- end footer--->



  </body>
</html>
