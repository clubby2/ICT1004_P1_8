<?php
require 'config.php';
// del cart where the table is not inside
if (isset($_POST['delcart'])) {

$cid= $_POST['getcid'];
echo $cid;
$cartsql= "SELECT * FROM cart WHERE CID = $cid"; // query cart item
$cartitem= mysqli_query($db,$cartsql);
$cart = mysqli_fetch_assoc($cartitem); // value of the cart

//echo $cart['item_quantity']; // get cart Quantity
$cartitem_id=$cart['item_id'];
$mainsql= "SELECT * FROM item WHERE item_id = $cartitem_id"; // query cart item and - current stock
$mainitem= mysqli_query($db,$mainsql);
$item = mysqli_fetch_assoc($mainitem); // value of the item
$newQuantity=$item['item_quantity']+$cart['item_quantity'];
mysqli_query($db, "UPDATE item SET item_quantity=$newQuantity WHERE item_id=$cartitem_id");
//echo $newQuantity;
$sql = "DELETE FROM cart WHERE CID=$cid";
mysqli_query($db, $sql);
  $db->close();
  header("location: cart.php");
}
if(isset($_POST['delproducts'])){

$delitemid= $_POST['getitemid'];
//echo $delitemid;
$sqlcartdel = "DELETE FROM item WHERE item_id=$delitemid";
mysqli_query($db, $sqlcartdel);
$sqlcartdel = "DELETE FROM cart WHERE item_id=$delitemid";
mysqli_query($db, $sqlcartdel);
  header("location: productlist.php");
  $db->close();

}





 ?>
