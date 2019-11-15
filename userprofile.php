<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Product</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/index.css" rel="stylesheet" >
                <link href="css/profile.css" rel="stylesheet" >
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
        <script scr="js/bootstrap.min.js"></script>
        <script defer src="js/index.js"></script>

        <script defer src="js/headnfoot.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
<?php include "header.php" ?>


        <!--- content here --->
        <article class="container">

            <section class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
                    <li><a data-toggle="tab" href="#paymentnshipping">Payment & Shipping</a></li>
                </ul>
            </section>

            <article class="tab-content col-md-6">
                <section id="profile" class="tab-pane fade in active">
                    <h2>Account Details</h2><hr class="line">
                    <form action="" method="post">
                        <p class="form-group">
                            <label for="account_first_name">First name&nbsp;<span class="required">*</span></label>
                            <input type="text" required="true" class="form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="sinnfei" />
                        </p>
                        <p class="form-group">
                            <label for="account_last_name">Last name&nbsp;<span class="required">*</span></label>
                            <input type="text" required="true" class="form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="heng" />
                        </p>
                        <p class="form-group">
                            <label for="account_display_name">Display name&nbsp;<span class="required">*</span></label>
                            <input type="text" required="true" class="form-control" name="account_display_name" id="account_display_name" value="" />
                        </p>
                        <p class="form-group">
                            <label for="account_email">Email address&nbsp;<span class="required">*</span></label>
                            <input type="email" required="true" class="form-control" name="account_email" id="account_email" autocomplete="email" value="sinnfeiheng@gmail.com" />
                        </p>

                        <fieldset>
                            <legend>Password change</legend>

                            <p class="form-group">
                                <label for="password_current">Current password (leave blank to leave unchanged)</label>
                                <input type="password" class="form-control" name="password_current" id="password_current" autocomplete="off" />
                            </p>
                            <p class="form-group">
                                <label for="password_1">New password (leave blank to leave unchanged)</label>
                                <input type="password" class="form-control" name="password_1" id="password_1" autocomplete="off" />
                            </p>
                            <p class="form-group">
                                <label for="password_2">Confirm new password</label>
                                <input type="password" class="form-control" name="password_2" id="password_2" autocomplete="off" />
                            </p>
                        </fieldset>

                        <button type="submit" class="btn btn-primary" name="save_account_details" value="Save changes">Save changes</button>
                    </form>
                </section>
                <section id="paymentnshipping" class="tab-pane fade">
                    <h3>Credit/Debit Card</h3><hr class="line">
                    <form>
                        <p class="form-group">
                            <label>Name on card</label>
                            <input class="form-control" type="text" placeholder="Full name on card"/>
                        </p>

                        <section class="form-group">
                            <label>Card Number</label>
                            <section class="input-group">
                                <input class="form-control" type="text" placeholder="Card Number"/>

                                <section class="input-group-addon">
                                    <i class="fa fa-cc-visa"></i>
                                </section>
                            </section>
                        </section>

                        <section class="row">
                            <div class="col-md-3">
                                <p class="form-group">
                                    <label>Expiration</label>
                                    <input class="form-control" type="text" placeholder="MM/YY"/>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p class="form-group">
                                    <label>CV Code</label>
                                    <input class="form-control" type="text" placeholder="CVC"/>
                                </p>
                            </div>
                        </section>
                        <button type="button" class="btn btn-primary">Add Card</button>
                    </form>

                    <h3>Shipping Address</h3><hr class="line">
                    <form>
                        <p class="form-group">
                            <label>Street address 1</label>
                            <input class="form-control" type="text" placeholder="Street address, P.O box"/>
                        </p>
                        <p class="form-group">
                            <label>Street address 2</label>
                            <input class="form-control" type="text" placeholder="Apartment, unit, building, floor"/>
                        </p>
                        <p class="form-group">
                            <label>Postal Code</label>
                            <input class="form-control" type="text" placeholder="#####"/>
                        </p>
                        <button type="button" class="btn btn-primary">Add Address</button>
                    </form>
                </section>
            </article>
            <div class=col-md-3></div>

        </article>

        <!--- footer--->
<?php include "footer.php" ?>
        <!--- end footer--->



    </body>
</html>
