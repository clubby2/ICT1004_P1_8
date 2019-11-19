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
   $item_image =$img_dir;
  
if (empty($_POST['item_name']))
{
$errorMsg .= "Item_name is required.<br>";
$success = false;
}
else if (!preg_match("/^[a-zA-Z ]*$/",$item_name))
{
 $errorMsg .='Only letters and white space allowed';
 $success = false;
} else{
   $item_name = sanitize_input($_POST['item_name']); 
   // Additional check to make sure input is well-formed.
  }
  
   if (empty($_POST['item_category'])) {
    $errorMsg = "Category is required";
    $success = false;
  } else {
    $item_category = sanitize_input($_POST['item_category']);
  }
  
 $item_quantity = 0;

if (filter_var($item_quantity, FILTER_VALIDATE_INT) === 0 || filter_var($item_quantity, FILTER_VALIDATE_INT)) {
    $item_quantity = sanitize_input($_POST['item_quantity']);
} else {
    echo("Variable is not an integer");
    $success = false;
}
   
   
 $item_price = 0;

if (filter_var($item_price, FILTER_VALIDATE_INT) === 0 || filter_var($item_price, FILTER_VALIDATE_INT)) {
    $item_price = sanitize_input($_POST['item_price']);
} else {
    echo("Variable is not an integer");
    $success = false;
}
   

if (empty($_POST['item_description']))
{
$errorMsg .= "Item_name is required.<br>";
$success = false;
}
else if (!preg_match("/^[a-zA-Z ]*$/",$item_description))
{
 $errorMsg .='Only letters and white space allowed';
 $success = false;
} else{
   $item_description = sanitize_input($_POST['item_description']); 
   // Additional check to make sure input is well-formed.
  }


$item_features = sanitize_input($_POST['item_features']);


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
   
  function sanitize_input($data)
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

   
   ?>