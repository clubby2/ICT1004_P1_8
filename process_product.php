<?php
Require "config.php";
//$item_name = $item_category = $item_quantity = $item_price = $item_description= $item_features = $item_image = " ";
$errorMsg = "";
$success = true;
if(isset($_FILES['item_image'])){
      $errors= array();
      $file_name = $_FILES['item_image']['name'];
      $file_size =$_FILES['item_image']['size'];
      $file_tmp =$_FILES['item_image']['tmp_name'];
      $file_type=$_FILES['item_image']['type'];
      $tmp = explode('.',$_FILES['item_image']['name']);
    $file_extension = end($tmp);
    $file_ext=strtolower($file_extension);
     // $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
          $img_dir= "img/product/".$file_name;
         move_uploaded_file($file_tmp,$img_dir);
         echo "Success<br>";
       
      }else{
         print_r($errors);
      }
   }
  //echo $img_dir."what is this";

$item_name =$_POST['item_name'];
$item_category =$_POST['item_category'];
$item_quantity =$_POST['item_quantity'];
$item_price =$_POST['item_price'];
$item_description =$_POST['item_description'];
$item_features =$_POST['item_features'];
$item_image =$img_dir;

//exit;
$sql = "INSERT INTO item (item_name,item_category,item_quantity,item_price,item_description,item_features,item_image)";
$sql .= " VALUES ('$item_name', '$item_category', '$item_quantity', '$item_price','$item_description','$item_features','$item_image')";


if ($db->query($sql)=== TRUE){
    echo 'success';
    header('location:productlist.php');
    
    
}else
{
$errorMsg = "Database error: " . $db->error;
echo $errorMsg;
$success = false;
}


$db->close();
   
  
   
   ?>