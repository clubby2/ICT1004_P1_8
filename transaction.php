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
<section>
    <article>
        <div class="container-fluid">
            <h2>Transaction History</h2>

<?php
$userid =$_SESSION['UID'];
$num = 0;
    $query = "SELECT HID, total_price, item_name, date_purchased FROM history_payment WHERE UID = '$userid' ORDER BY date_purchased DESC;";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 0){
        mysqli_free_result($result);
        mysqli_close($db);
        echo "<h2>No transaction history found.</h2>";
    }
    else{
        echo "<div class='table-responsive'>";
        echo "<table id='history' class='table table-striped table-bordered' width='100%'>";
        echo "<thead><tr><th>#</th>";
        echo "<th>Item</th>";
        echo "<th>Total price</th>";
        echo "<th>Date Purchased</th></tr></thead><tbody>";
        while($row = mysqli_fetch_assoc($result)){
            $num += 1;
            $item = $row['item_name'];
            $total = $row['total_price'];
            $date = $row['date_purchased'];

            echo "<tr><td>" . $num . "</td>";
            echo "<td>" . $item . "</td>";
            echo "<td>" . $total . "</td>";
            echo "<td>" . $date . "</td></tr>";
        }
        mysqli_free_result($result);
        mysqli_close($db);
        echo "</tbody></table>";

    }
?>
            <a href="index.php"/><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-home"> Home</span></button>
            </div>
    </article>
</section>


<!--- footer--->
<?php include "footer.php" ?>
<!--- end footer--->
  </body>
</html>
