<?php
session_start();
if(isset($_SESSION['email'])){

}
if(isset($_POST['logout'])){
  //session_start();
//  echo "HALLLLLO";
session_destroy();
unset($_SESSION['email']);
unset($_SESSION['role']);
unset($_SESSION['UID']);
//header('Location:index.php');
}



 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Header</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <script defer src="js/index.js"></script>

  <!---  <script type="text/javascript">
    var storeusername = localStorage.getItem('username');
  //  alert(storeusername);
    if (storeusername !=null){
      //alert("do something");
      document.getElementById("signinbtn").style.display="none";
      document.getElementById("loginbtn").style.display="none";
      document.getElementById("accbtn").style.display="block";
    }
  </script>--->

  </head>
  <body>



    <!---  <rect width="100%" height="100%" fill="#777">
                  <img src="img/adv1.png" class="img-responsive">
      </rect>--->
              <!--- nav bar--->
            <nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
           <div class="container">
             <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                 <span class="icon-bar burger"></span>
                 <span class="icon-bar burger"></span>
                 <span class="icon-bar burger "></span>
               </button>

        <a href="index.php" class="navbar-brand">
                   <img src="img/LOGOsmall.png"></a>

             </div>
             <div class="collapse navbar-collapse " id="myNavbar">
               <ul class="nav navbar-nav">
              <li><a  href="product.php">Product</a></li>
               <li><a  href="cart.php"><span class="glyphicon glyphicon-shopping-cart
               "></span>Cart

               </a></li>
              <li><a  href="review.php">Reviews</a></li>
               <li><a  href="about.php">About Us</a></li>

               </ul>
               <ul class="nav navbar-nav navbar-right">
<?php if (empty($_SESSION['email'])) { ?>
  <li data-toggle="modal"id="signinbtn"class="hides" data-target="#modal-register"><a href="#modal-register" ><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
              <li  data-toggle="modal" id="loginbtn" data-target="#modal-login"><a href="#modal-login" ><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php } else { ?>
              <li class="dropdown"><a class="dropdown-toggle fa fa-gears" data-toggle="dropdown" href="#">Account <span class="caret"></span></a>
     <ul class="dropdown-menu">

       <li><a href="userprofile.php">Profile</a></li>
       <?php if (!empty($_SESSION['role'])) { ?>
       <li><a href="productlist.php">Admin Product</a></li>
     <?php } ?>
     </ul>

   </li>
  <li><form class="" action="<?php echo $_SERVER['PHP_SELF'];?>" name="detialslogout" method="post"style="padding-top: 12px;">

     <!---<button type="submit" name="logout" class="btn btn-default" style="margin-top: 5px; background-color: transparent; color: #ccc; border: transparent;">--->

    <a  href="javascript: submitform()"><span class="glyphicon glyphicon-log-in " ></span> Log out</a>
     <input type="hidden" name="logout" value="Remove" />
   </form></li>
   <script type="text/javascript">
   function submitform()
   {
     document.detialslogout.submit();
   }
   </script>

               </ul>
<?php } ?>
           </div>

         </nav>


         <!---end nav-->
          <!--- header pic-->
        <header>
          <div class="overlay"></div>
          <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="https://storage.googleapis.com/coverr-main/mp4/Mt_Baker.mp4" type="video/mp4">
          </video>
          <div class="container h-100">
            <div class="d-flex h-100 text-center align-items-center">
              <div class="w-100 text-white">
                <h1 class="display-3">Flex Out</h1>
                <p class="lead mb-0">Adventurer || Entrepreneur || Idealist</p>
              </div>
            </div>
          </div>
      </header>
      <!-- login modal --->
      <?php// echo $_SERVER['PHP_SELF'];?>
    <form action="" method="post" id="userform">
      <div class="modal fade" id="modal-login">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <center> <img src="img/LOGOsmall.png"></center>
              <h1 class="modal-title text-center">Login </h1>

            </div>
            <div class="modal-body">
              <!--- my form--->
              <?php //echo $_SERVER['PHP_SELF'];?>

              <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email"name="email" required id="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <small id="erroremail" class="form-text text-danger" hidden></small>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password"name="password"id="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <small id="errorpassword" class="form-text text-danger" hidden></small>
              </div>
              <small id="errorbth" class="form-text text-danger" hidden></small>


            </div>
            <div class="modal-footer text-center">
              <button onclick="logins()" type="submit"name="login" class="btn btn-primary ">Login </button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      </form>
      <!-- /.modal -->
      <!--- register modal --->
      <div class="modal fade" id="modal-register">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                  <center> <img src="img/LOGOsmall.png"></center>
              <h1 class="modal-title text-center">Register </h1>
            </div>
            <div class="modal-body">
          <!--- my body content--->
          <form class="" action="" method="post" >
            <div class="form-group has-feedback">
              <input type="email" class="form-control"name="setusername" placeholder="Username/Email"id="setusername">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password"name="setpw" id="setpw">

              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Re-enter Password" name="setpw1" id="setpw1">

              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>


          </form>
            </div>
            <div class="modal-footer text-center">
              <button type="submit" onclick="signup()" class="btn btn-primary ">Sign Up </button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>


  </body>
</html>
