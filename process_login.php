<?php
$array = array();
$erroremail="";
$errorpassword="";
$errorbth="";
$data = 0;
require "config.php";
if (isset($_POST['login'])) {

$email=$_POST['email'];
$password=$_POST['password'];
$email = mysqli_real_escape_string($db, $_POST['email']);
$password = mysqli_real_escape_string($db, $_POST['password']);
//$password= password_hash($password, PASSWORD_BCRYPT);

  if (empty($email)) {
      $erroremail ="Email is required";
  }
  else if(!filter_var($email,FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})+$/")))){
  $erroremail = "Email is invalid.";
}
  if (empty($password)) {
  	$errorpassword = "Password is required";
  }

$sql = "SELECT * FROM user WHERE email='$email' LIMIT 1";
$sqlquery= mysqli_query($db,$sql);
$usersql = mysqli_fetch_assoc($sqlquery);


if (empty($usersql) || !password_verify($password, $usersql['password'])) { // if password is not verify show error

  $errorbth="Wrong email/password combination";
}
else{
//  echo $usersql['email'];
//  echo $usersql['password'];
//  echo $usersql['role'];
session_start();
if (empty($usersql['role'])) { // only for user session
  //echo "this is empty";
  $_SESSION['email'] = $email;
  $_SESSION['UID']=$usersql['UID'];
}
else{
  //echo "admin role"; // admin session
  $_SESSION['email'] = $email;
  $_SESSION['role'] = $usersql['role'];
  $_SESSION['UID']=$usersql['UID'];
  }
    //$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
  //  echo   $_SESSION['redirect'];
//  header('Location:index.php');
//  $data =1;
}
//$usersql->free_result();
$json_array = array(
  'errorpassword' => $errorpassword,
  'errorbth' =>$errorbth,
  'erroremail' => $erroremail
  //'data' => $data
);
echo json_encode($json_array);
$db->close();
exit;
}

 ?>
