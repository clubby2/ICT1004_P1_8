<?php
session_start();
if(empty($_SESSION['role'])){
//echo "empty";
header('Location:index.php');
exit;
}
if(isset($_POST['logout'])){
  //session_start();
//  echo "HALLLLLO";
session_destroy();
unset($_SESSION['email']);
unset($_SESSION['role']);
header('Location:index.php');
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
        <link href="css/dasboard.css" rel="stylesheet" >
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
<?php include "header.php";?>
   <!--- content here --->
   <div class="container-fluid">
     <ol class="breadcrumb" >
          <li><a href="#adminProducts" onclick="adminproduct()"><i class="fa fa-dashboard"></i>Product</a></li>
         <li><a href="#others" onclick="admincustomers()"><i class="fa fa-dashboard"></i> Customers</a></li>
        </ol>
     <div class="row" id="adminProducts">

         <div class="row" >
         	<div class="col-lg-10">

         		<h2>Product List</h2>
         	</div>
         	<div class="col-lg-4">
         		<a href="#" data-toggle="modal" data-target="#add_product_modal" class="btn btn-primary btn-sm">Add Product</a>
         	</div>
         </div>
         <div class="table-responsive">
           <table class="table table-striped table-sm">
             <thead>
               <tr>

                 <th>Name</th>
                 <th>Price</th>
                 <th>Quantity</th>
                 <th>Category</th>
                 <th>Action</th>
               </tr>
             </thead>
              <tbody id="product_list">
         <?php
          require 'config.php';
            $sql = "SELECT * FROM item ";

            if ($result = mysqli_query($db, $sql)) {
              if(mysqli_num_rows($result) > 0){
               while ($row = mysqli_fetch_array($result)) {

                  echo '<div class="col-lg-4 text-center">';
                          //  echo $row["item_name"];
                  $item_id=$row["item_id"];
                  $item_name=$row["item_name"];
                  //$item_image=$row["item_image"];
                  $item_category=$row["item_category"];
                  $item_quantity=$row["item_quantity"];
                  $item_price=$row["item_price"];
                  //$item_description=$row["item_description"];
                  //$item_features=$row["item_features"];
                  //echo $item_image;
                    echo'<tr>

                    <td>'.$item_name.'</td>
                    <td>$'.$item_price.'</td>
                    <td>'.$item_quantity.'</td>
                    <td>'.$item_category.'</td>
                    <td>';

                    echo'<a class="btn btn-sm btn-danger"name="delproducts" data-toggle="modal" data-target="#delModalproduct'.$item_id.'">Delete</a>
                    </td>
                </tr>';

                echo'<div class="modal fade" id="delModalproduct'.$item_id.'">';
                   echo  '<form action="modal.php" method="post">';
                     echo '<input type="hidden" name="getitemid" value="'.$item_id.' " readonly>';
                     echo'<div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span></button>
                                 <h1 class="modal-title">Removing Item </h1>
                             </div>
                         <div class="modal-body ">

                         <h3>Do you want to remove '.$item_name.'? </h3>
                           <div class="modal-footer">
                               <button type="submit"name="delproducts" class="btn btn-danger text-center">Remove</button>
                       <button type="button" class="btn btn-default text-center" data-dismiss="modal">Close</button>
                         </div>
                         </div>
                         </div>
                     </div>
               </form> </div>';
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



             </tbody>
           </table>
         </div>
         <!---table end --->
       </main>
     </div>
   </div>
   <!--- customer div--->
   <div class="row" id="adminCustomers" style="display:none;">

       <div class="row">
        <div class="col-lg-10 "style="padding-left: 30px;">

          <h2>Customers</h2>
        </div>

       </div>
       <div class="table-responsive">
         <table class="table table-striped table-sm">
           <thead>
             <tr>

               <th>Name</th>
               <th>Email</th>
               <th>/item</th>
               <th>Price</th>
               <th>total_price</th>
               <th>date_purchase</th>
             </tr>
           </thead>
           <?php
               require 'config.php';
$sqlcustomer = "SELECT a.UID,a.item_name, a.item_price, a.total_price, a.date_purchased, b.email ,b.first_name
FROM history_payment a left join user b on a.UID =b.UID";
          if ($result = mysqli_query($db, $sqlcustomer)) {
            if(mysqli_num_rows($result) > 0){
              while ($row = mysqli_fetch_array($result)) {

                echo '<div class="col-lg-4 text-center">';
                      //echo $row["item_name"];
                      $name=$row["first_name"];
                      $item_email=$row["email"];
                      $item_name=$row["item_name"];
                      $item_price=$row["item_price"];
                      $item_total=$row["total_price"];
                      $item_date=$row["date_purchased"];

                        echo'<tr>
                        <td>'.$name.'</td>
                        <td>'.$item_email.'</td>
                        <td>'.$item_name.'</td>
                        <td>'.$item_price.'</td>
                        <td>'.$item_total.'</td>
                        <td>'.$item_date.'</td>

                        </tr>';


                           }
                           $result->free_result();
                           }
                           else{
                               $errorMsg = "No Customer found!";
                               echo $errorMsg;
                         }
               }
                 $db->close();
                  ?>
           </div>


           </table>
         </div>



</div>

   <!-- Add Product Modal start -->
   <div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body">
             <form id="add-product-form" action="process_product.php" method="post" enctype="multipart/form-data">
           	<div class="row">
           		<div class="col-lg-12">
           			<div class="form-group">
   		        		<label>Product Name</label>
   		        		<input type="text" name="item_name" class="form-control" placeholder="Enter Product Name">
   		        	</div>
           		</div>
           		<div class="col-lg-12">
           			<div class="form-group">
   		        		<label>Category Name</label>
   		        		<select class="form-control category_list" name="item_category">
   		        			<option value="main">Flex Product</option>
                                                   <option value="other">Others</option>
   		        		</select>
   		        	</div>
           		</div>
           		<div class="col-lg-12">
           			<div class="form-group">
   		        		<label>Product Description</label>
   		        		<textarea class="form-control" name="item_description" placeholder="Enter product desc"></textarea>
   		        	</div>
           		</div>
               <div class="col-lg-12">
                 <div class="form-group">
                   <label>Product Qty</label>
                   <input type="number" name="item_quantity" class="form-control" placeholder="Enter Product Quantity">
                 </div>
               </div>
           		<div class="col-lg-12">
           			<div class="form-group">
   		        		<label>Product Price</label>
   		        		<input type="number" name="item_price" class="form-control" placeholder="Enter Product Price">
   		        	</div>
           		</div>
           		<div class="col-lg-12">
           			<div class="form-group">
   		        		<label>Product Feature <small>(eg: Strong, adhesive, environment friendly)</small></label>
   		        		<input type="text" name="item_features" class="form-control" placeholder="Enter Product Keywords">
   		        	</div>
           		</div>
           		<div class="col-lg-12">
           			<div class="form-group">
   		        		<label>Product Image <small>(format: jpg, jpeg, png)</small></label>
   		        		<input type="file" name="item_image" class="form-control">
   		        	</div>
           		</div>
           		<input type="hidden" name="add_product" value="1">
           		<div class="col-lg-12">
           			<button type="submit" class="btn btn-primary add-product">Add Product</button>
           		</div>
           	</div>

           </form>
         </div>
       </div>
     </div>
   </div>
   <!-- Add Product Modal end -->

   
   
   
   
   

   
   
   

   <!--- footer--->
  <?php include "footer.php" ?>
   <!--- end footer--->



  </body>
</html>
