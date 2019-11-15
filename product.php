<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Products</title>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
     <script defer src="js/product.js"></script>
    <script src="js/index.js"></script>
    <script src="js/headnfoot.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    </script>
  </head>
  <body>
<?php include "header.php" ?>

   <!--- content here  --->
   <section >
   <ol class="breadcrumb" >
        <li><a href="#products" onclick="div1()"><i class="fa fa-dashboard"></i> Flex Product</a></li>
       <li><a href="#others" onclick="div2()"><i class="fa fa-dashboard"></i> Others</a></li>
      </ol>

    <div id="products" name="products">
       <div class="container-fluid">
           <div class="row" id="products" >
            <!--- <form class="" action="" method="post">--->
             <?php
               $val_item =1;
              require 'config.php';
              $sql = "SELECT * FROM item WHERE item_category='main'";

              // Execute the query
              if ($result = mysqli_query($db, $sql)) {
                if(mysqli_num_rows($result) > 0){
                 while ($row = mysqli_fetch_array($result)) {

                    echo '<div class="col-lg-4 text-center">';
                            //  echo $row["item_name"];
                    $item_id=$row["item_id"];
                    $item_name=$row["item_name"];
                    $item_image=$row["item_image"];
                    $item_quantity=$row["item_quantity"];
                    //$item_description=$row["item_description"];
                    //$item_features=$row["item_features"];
                    //echo $item_image;
                    echo '<img src="'.$item_image.'" alt="#"/>';
                    echo  "<p>".$item_name."</p>";

                    echo'<button type="submit"  class="btn btn-warning" data-toggle="modal" data-target="#modal'.$item_id.'" >Add to Cart</button>
                    </a>

                    <p>Total Quantity</p>
                    <p>'.$item_quantity.' in stock</p>';

                    echo"</div>";
                }
            $result->free_result();
              }
              else{
                  $errorMsg = "No item found!";
                  echo $errorMsg;
              }
}
  $db->close();
              ?>
          <!---  </form>--->
              </div>
              </div>
              </div>
       <!-- product 1 modal -->


       </form>
       <?php
       require 'config.php';
       $sql = "SELECT * FROM item  WHERE item_category='main'";
       if ($result = mysqli_query($db, $sql)) {
         if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_array($result)) {
              $item_id=$row["item_id"];
              $item_name=$row["item_name"];
              $item_quantity=$row["item_quantity"];// total
                $item_price=$row["item_price"];
              $item_description=$row["item_description"];
              $item_features=$row["item_features"];
                $item_image=$row["item_image"];

            echo'<div class="modal fade" id="modal'.$item_id.'">';
            echo '<form action="process_cart.php?" method="post">';
            echo'<input type="hidden" name="my_pid" value="'.$item_id.' "readonly>';
            echo'<input type="hidden" name="my_itemp" readonly value="'.$item_price.'">';
            echo'<input type="hidden" name="my_itemname" readonly value="'.$item_name.'">';
            echo '<div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span></button>
                               <h4 class="modal-title">'.$item_name.'</h4>
                           </div>
                       <div class="modal-body">
                           <div class="container-fluid">
                               <div class="row">
                                   <img src="'.$item_image.'" alt="#"/>
                               </div>
                               <div class="row">
                                   <div class="table">
                                       <table class="table table-bordered">
                                           <tbody>
                                           <th>Product Description</th>
                                               <tr>
                                                   <td>
                                                   '.$item_description.'
                                                   </td>
                                               </tr>
                                                   <th>Product Features</th>
                                                   <tr>
                                                       <td>
                                                           <ul>';
                                              $featuresArray = explode(',', $item_features);
                                              foreach ($featuresArray as $featuresPoint) {
                                                      echo '<li>'.$featuresPoint.'</li>'; // loop and split the features
                                                       //print_r($featuresPoint);
                                                    }

                                                      echo'</ul>';
                                                      echo '</td>
                                                   </tr>
                                                   <tr>
                                                       <td>
                                                           <p>Price:$'.$item_price.'</p>
                                                           <button class="minus-btn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                                                           <input type="text" class="counter" value="1" size="1" name="val_item">
                                                           <button class="plus-btn" type="button"><span class="glyphicon glyphicon-plus"></span></button><br><br>
                                                       </td>
                                                   </tr>
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary" >Add to Cart</button>
                   </div>
                       </div>
                    </div>
                </form>
                  </div>';

            }
          $result->free_result();
        }
        else{
            $errorMsg = "No item found!";
            echo $errorMsg;
        }
      }
  $db->close();
        ?>


    <div id="others" style="display:none" name="others">
       <div class="container-fluid">
        <div class="row" id="others">
         <?php
          require 'config.php';
          $sql = "SELECT * FROM item WHERE item_category='other'";

          // Execute the query
          if ($result = mysqli_query($db, $sql)) {

            if(mysqli_num_rows($result) > 0){
             while ($row = mysqli_fetch_array($result)) {

                echo '<div class="col-lg-4 text-center">';
                        //  echo $row["item_name"];
                $item_id=$row["item_id"];
                $item_name=$row["item_name"];
                  $item_image=$row["item_image"];
                $item_quantity=$row["item_quantity"];
                //$item_description=$row["item_description"];
                //$item_features=$row["item_features"];
                echo '<img src="'.$item_image.'" alt="#" wdith="150px" height="150px"/>';
                echo  "<p>".$item_name."</p>";
                echo'<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal'.$item_id.'" >Add to cart</button>
                </a>

                <p>Total Quantity</p>
                  <p>'.$item_quantity.' in stock</p>';
                echo"</div>";
            }
        $result->free_result();
          }
          else{
              $errorMsg = "No item found!";
              echo $errorMsg;
          }
}
$db->close();

          ?>
          </div>


       </div> <!---- end contain --->
       <!-- product 1 submodal -->
<?php
require 'config.php';
$sql = "SELECT * FROM item  WHERE item_category='other'";
if ($result = mysqli_query($db, $sql)) {
  if(mysqli_num_rows($result) > 0){
     while ($row = mysqli_fetch_array($result)) {
       $item_id=$row["item_id"];
       $item_name=$row["item_name"];
       $item_quantity=$row["item_quantity"];
       $item_price=$row["item_price"];
       $item_description=$row["item_description"];
       $item_features=$row["item_features"];
       $item_image=$row["item_image"];


     echo'<div class="modal fade" id="modal'.$item_id.'" >';
     echo '<form action="process_cart.php?" method="post">';
     echo'<input type="hidden" name="my_pid" readonly value="'.$item_id.'">';
     echo'<input type="hidden" name="my_itemp"readonly value="'.$item_price.'">';
     echo'<input type="hidden" name="my_itemname" readonly value="'.$item_name.'">';
          echo  '<div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">'.$item_name.'</h4>
                    </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <img src="'.$item_image.'" alt="#"/>
                        </div>
                        <div class="row">
                            <div class="table">
                                <table class="table table-bordered">
                                    <tbody>
                                    <th>Product Description</th>
                                        <tr>
                                            <td>
                                            '.$item_description.'
                                            </td>
                                        </tr>
                                            <th>Product Features</th>
                                            <tr>
                                                <td>
                                                    <ul>';
                                       $featuresArray = explode(',', $item_features);
                                       foreach ($featuresArray as $featuresPoint) {
                                               echo '<li>'.$featuresPoint.'</li>';
                                                //print_r($featuresPoint);
                                             }
                                                    echo'</ul>';
                                                echo '</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Price:$'.$item_price.'</p>
                                                    <button class="minus-btn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                                                    <input type="text" class="counter" value="1" size="1" name="val_item">
                                                    <button class="plus-btn" type="button"><span class="glyphicon glyphicon-plus"></span></button><br><br>
                                                </td>
                                            </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </div>
                </div>
             </div></form>
            </div>';

     }
   $result->free_result();
 }

 else{
     $errorMsg = "No item found!";
     echo $errorMsg;
 }

}
$db->close();
 ?>



    </div>


  </section>

<!--- endc conter here --->

   <!--- footer--->
<?php include "footer.php" ?>
   <!--- end footer--->



  </body>
</html>
