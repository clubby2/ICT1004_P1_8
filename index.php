
<html>
    <head>
        <title>Flex Out</title>
        <meta charset="UTF-8">
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
  
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script defer src="js/index.js"></script>
<script defer src="js/headnfoot.js"></script>
    </head>
    <body>
    <article>
      <section>

<?php include "header.php" ?>
    </section>



<!--- content 1 Brandon ---->
<section>


<div class="container">
  <h1 class="text-center headerfont">Welcome</h1>
  <p>We design, develop, manufacture in household appliances  inventory and distribute to suppliers such as Flex Seal the founder of the company. In addition we will be supporting those product that have yet to be discovered. We understand and appreciate that many challenges users face regarding accuracy, complexity and deadline. We will support those users and their deadlines to the best of our ability.</p>
</div>
<!--- mission--->
<div class="container-fluid">
  <h1 class="text-center headerfont">Our Mission</h1>
  <div class="row">
    <div class="col-lg-4">
      <center>
  <img src="img/handinhand.jpg"class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140">

        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777">

        </rect><text x="50%" y="50%" fill="#777" dy=".3em">
        </text></svg><center><br>
      <p> To sustain our vision and mission by constantly seeking renewal via continuous education and learning, and the application of new technologies and best business practices.</p>
    </div>
    <div class="col-lg-4">
      <center>
  <img src="img/m2.jpg"class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em"></text></svg><center><br>
      <p> To provide a Solution for household environment which encourages our employees to be highly productive and to grow personally and professionally.</p>
    </div>
    <div class="col-lg-4">
      <center>
  <img src="img/m3.png" class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#777" dy=".3em"></text></svg><center><br>
      <p> To develop diversified markets which provide stability and adequate financial returns which allow us to achieve our vision and to provide opportunity for developing more products</p>
    </div>
  </div>
</div>
</section>
<!---- latest Product--->
<section>
<div class="container-fluid">
    <h1 class="text-center headerfont">Latest Products</h1>
  <div class="row">

    <?php

     require 'config.php';
     $sql = "SELECT * FROM item WHERE item_id > ((select COUNT(*) from item) - 4)";

     // Execute the query
     if ($result = mysqli_query($db, $sql)) {

       if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {

           echo '<div class="col-md-3">';
                   //  echo $row["item_name"];
           $item_id=$row["item_id"];
           $item_name=$row["item_name"];
           $item_image=$row["item_image"];
           //$item_quantity=$row["item_quantity"];
           $item_description=$row["item_description"];
           //$item_features=$row["item_features"];
           //echo $item_image;
           //echo '<img src="'.$item_image.'"width="200"height="150" alt="#"/>';
          echo' <center><h2 class="">'.$item_name.'</h2>
           <img src="'.$item_image.'" alt="" width="200"height="150" ></center>
           <center><a href="product.php#products" class="btn btn-primary btn-rounded btn-lg btn-center">Buy Now!</a></center>
           <br>
             <div class="text-center" >
             <p >'.$item_description.'</p>
             </div>
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
</div>
</section>

<!-- reviews video --->
<section>

<h1 class="text-center headerfont">Reviews
</h1>
<div class="jumbotron text-center " style="background:white;">

<!---  <div class="videocontent">
    <h3>How is flex tape good?Click the button for more information.</h3>
    <a href="review.php">
  <button id="myBtn" class="btn btn-primary btn-rounded btn-lg btn- text-center" onclick="">Click here!</button></a>
</div>--->
<header>


<div class="container h-100 top-reviews-home">
           <div class="d-flex h-100 text-center align-items-center">
             <div class="w-100 text-white">
               <h1 class="display-3">Click here for more information.</h1>
                <a href="review.php">
                 <button id="myBtn" class="btn btn-primary btn-rounded btn-lg btn- text-center" onclick="">Click here!</button> </a>
               <!---<p class="lead mb-0">Adventurer || Entrepreneur || Idealist</p>--->
             </div>
           </div>
         </div>
         <div class="overlay"> </div>
           <video autoplay muted loop id="myVideo">
           <source src="img/flex.mp4"width="320" height="240"class="" type="video/mp4" >
          Your browser does not support HTML5 video.
         </video>
</header>




</div>

</section>
<!--- footer--->
<section>

<?php include "footer.php" ?>
<!--- end footer--->
</section>
</article>

    </body>
</html>
