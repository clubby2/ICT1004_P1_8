<html lang="en-US">
    <head>
        <title>Flex Out - Register Account</title>
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
        <!-- Bootstrap CSS files -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">  </script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script defer src="js/index.js"></script>
        <script defer src="js/headnfoot.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-light navbar-expand-lg fixed-top" id="mainNav">
            <div class="container">
                <logo class="navbar-brand" href="index.html">
                    <a href="index.php">index.php</a>
                </logo>
                <button data-toggle="collapse" data-target="#navbarResponsive" class="navbar-toggler" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars">
                    </i>
                </button>
                <ul class="nav navbar-nav navbar-right" style="clear: both;">
                    <li>
                        <a href="index.php">
                            <span class="glyphicon glyphicon-user"></span> Sign Up &nbsp;
                        </a>
                        <a href="index.php">
                            <span class="glyphicon glyphicon-log-in"></span> Login &nbsp;
                        </a>
                    </li>
                </ul>
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                    </ul>
            </div>
        </nav>

        <header class="masthead" style="background-image:url('img/gray.png');">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-lg-8 mx-auto">
                        <div class="site-heading">
                            <h2 class="text-monospace text-capitalize">Member Login</h2>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
            define("DBHOST", "localhost");
            define("DBUSER", "root");
            define("DBNAME", "user")
            // set variables to empty string
            $first_name = $last_name = $email = $password = $confirm_password = $terms = $error_message = "";
            $success = true;

            if (empty($_POST["last_name"]))
                {$error_message .= "Last Name is required. <br>";$success = false;}
            if (empty($_POST["email"]))
                {$error_message .= "Email is required. <br>";$success = false;}
            if (empty($_POST["password"]))
                {$error_message .= "Password is required. <br>";$success = false;}
            if (empty($_POST["confirm_password"]))
                {$error_message .= "Confirm your password. <br>";$success = false;}
            else if ($password != $confirm_password)
                {$error_message .= "Password and Confirm Password do not match";$success = false;}
            if (empty($_POST["terms"]))
                {$error_message .= "Please accept the terms and conditions. <br>";$success = false;}
            else
                {$first_name = sanitize_input($_POST["first_name"]);
                $last_name = sanitize_input($_POST["last_name"]);
                $email = sanitize_input($_POST["email"]);
                $password = sanitize_input($_POST["password"]);
                $confirm_password = sanitize_input($_POST["confirm_password"]);
                $terms = sanitize_input($_POST["terms"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {$error_message .= "Invalid email format.";$success = false;}}
            if ($success) {
                echo '<div class="container">"<div class="row"><div class="splitcol"><div class="post-preview">';
                echo "<h3>Registration successful!</h3>";
                echo "<h3>Thank you for signing up, " . $last_name . ". </h4>";
                echo "<p>Email: " . $email;
                echo "<p>Do not forget or disclose your password.<p>";
                echo "<h3><a href = index.php>Return to homepage</a></h3>";
                echo "<h3><a href = login.php>Login</a></h3>";
                echo "</div></div></div></div>";}
            else {
                echo '<div class="container"><div class="row"><div class="splitcol"><div class="post-preview">';
                echo "<h3>Registration failed!</h3><br>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $error_message . "</p>";
                echo "<h3><a href = register.php>Back</a></h3>";
                echo "</div></div></div></div>";}
            function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;}
            // helper function
            function saveMemberToDB() {
                global $first_name, $last_name, $email, $password, $error_message, $success;
                // Create Connection
                require 'config.php';
              //  $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                // Check Connection
                if ($db->connect_error)
                {\$error_message = "Connection failed: " . $db->connect_error;$success = false;}
                else
                    {$sql = "INSERT INTO travel_photo_members (email, password, first_name, last_name)";
                    $sql .= " VALUES ('$email', '$password', '$first_name', '$last_name')";
                    // Execute the Query
                    if (!$db->query($sql)) {
                        $error_message = "Database error: " . $db->error;
                        $success = false;}}
                $db->close();}
            saveMemberToDB();
        ?>
    </body>
    <!--- footer--->
<footer class="own-footer text-center">
    <div class="container-fluid">
    <div class="row ">
        <div class="col-lg-4 text-center">
            <h2>Contact Us</h2>
            <br>
            Email:<br>
            <a href="#" class="link-color">company@gmail.com</a>
            <p></p>
            <p>Phone:<br>
            +65 9876 5432</p>
            <p></p>
            <br>
        </div>
        <div class="col-lg-4 text-center">
            <h2>Find Us</h2>
            <br>
            Address:<br>
            10 Dover Dr, <br> Singapore 138683
            <p></p>
            <p>Phone:<br>\+65 9876 5432</p>
            </div>
                <div class="col-md-4">
                    <img src="img/static-map.png" wdith="100" height="150" class="own-img" alt="">
                </div>
            </div>
        </div>
        <div class="container">
            <ul>
                <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                <a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
                <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                <a class="btn btn-social-icon btn-tumblr"><i class="fa fa-tumblr"></i></a>
            </ul>
        </div>
    <p>Copyright &copy; 2019 . All rights reserved. Created by Company Pte. Ltd.</p>
</footer>
</html>
