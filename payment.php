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

     <script defer src="js/product.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">  </script>
<script scr="js/bootstrap.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
<!---- header --->
<?php include "header.php" ?>

<div class="container-fluid">
  <h1>Shopping Cart</h1>
  <div class="info-box">
  <div class="row">
    <div class="col-4 col-md-1 ">
      <div class="checkbox-custom" >
        <label>
<input type="checkbox">  <b></b>
<span></span>
</label>
      </div>
    </div>
    <div class="col-4 col-md-8 ">
      <table>
        <tr>

    <th><img src="img/product/FlexSealSpray.PNG" alt="">
    </th>
<th>        <p>item name</p>
        <p>item price</p></th>
        </tr>
    </table>
    </div>
    <div class="col-4 col-md-2">
      <p>Quantity</p>
      <button class="minus-btn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
      <input type="text" class="counter" value="1" size="1" name="val_item'.$item_id.'">
      <button class="plus-btn" type="button"><span class="glyphicon glyphicon-plus"></span></button><br><br>
      <button type="submit" name="delcart"class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-trash"></span> Trash
          </button>

    </div>
    <div class="col-4 col-md-1 ">
      <div class="checkbox-custom" >
        <label>
<input type="checkbox">  <b></b>
<span></span>
</label>
      </div>
    </div>
    <div class="col-4 col-md-8 ">
      <table>
        <tr>
    <th><img src="img/product/FlexSealSpray.PNG" alt="">
    </th>
<th>        <p>item name</p>
        <p>item price</p></th>
        </tr>
    </table>
    </div>
    <div class="col-4 col-md-2">
      <p>Quantity</p>
      <button class="minus-btn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
      <input type="text" class="counter" value="1" size="1" name="val_item'.$item_id.'">
      <button class="plus-btn" type="button"><span class="glyphicon glyphicon-plus"></span></button><br><br>
      <button type="submit" name="delcart"class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-trash"></span> Trash
          </button>

    </div>

  </div>
</div>
  </div>
   <!--- content here --->

   <!--- footer--->
  <?php include "footer.php" ?>
   <!--- end footer--->



  </body>
</html>
