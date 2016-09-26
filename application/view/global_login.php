<?php
//$remember_me_password = false;
//$remember_me_email = false;
//if(isset($_COOKIE['remember_me_password'])) {$remember_me_password = true;}
//if(isset($_COOKIE['remember_me_email'])) {$remember_me_email = true;}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Login</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../../public/css/global_login.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="btn-group btn-group-justified" role="group">
        <div class="btn-group" role="group">
            <button type="button" id="staff-login-btn" class="btn btn-md btn-primary">Staff Login</button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="volunteer-login-btn" class="btn btn-md btn-primary">Volunteer Check In</button>
        </div>
    </div>
    <!-- Start Staff/Admin Login -->
    <div class="row" id="staff-login">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form class="form-signin">
                <h2 class="form-signin-heading" align="center">Staff Login</h2>
                <div id="alert"></div>
                <?php if(isset($_GET['response'])) { echo '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> You have been successfully logged out!</div>';} ?>
                <label for="inputEmail" class="sr-only">Email address or Staff ID</label>
                <input type="text" id="inputEmail" class="form-control" placeholder="Email address or Volunteer ID" >
                <br>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="remember-me" value="remember-me"> Remember me
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button data-login-type="JACO" id="jaco" class="btn btn-sm btn-primary" type="submit">JACO Login</button>
                    </div>
                    <div class="col-md-4">
                        <button data-login-type="BEBCO" id="bebco" class="btn btn-sm btn-primary" type="submit">BEBCO Login</button>
                    </div>
                    <div class="col-md-4">
                        <button data-login-type="JBC" id="jbc" class="btn btn-sm btn-primary" type="submit">JBC Login</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <button data-login-type="ADMIN" id="admin" class="btn btn-sm btn-success" type="submit">Admin Login</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <!-- End Staff Login -->

    <!-- Volunteer Login -->
    <div class="row" id="volunteer-login">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form class="form-signin">
                <h2 class="form-signin-heading" align="center">Volunteer Login</h2>
                <div id="alert-volunteer"></div>
                <?php if(isset($_GET['response-volunteer'])) { echo '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> You have been successfully logged out!</div>';} ?>
                <label for="volunteer-email" class="sr-only">Email address or Volunteer ID</label>
                <input type="text" id="volunteer-email" class="form-control" placeholder="Email address or Volunteer ID">
                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <button id="volunteer-login-submit" class="btn btn-sm btn-success" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <!-- Volunteer Login end -->

    <!-- Volunteer CICO -->
    <div class="row" id="volunteer-cico">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form class="form-signin">
                <h2 class="form-signin-heading" align="center">Volunteer Check-in</h2>
                <div id="alert-cico"></div>
                <div class="form-group">
                    <select class="form-control" id="volunteer-type">
                        <option name="default" selected>Select Volunteer Type</option>
                        <option name="program">Program</option>
                        <option name="board">Board</option>
                        <option name="general">General</option>
                    </select>
                </div>

                <!-- Hidden form only visible to program volunteers -->
                <div class="form-group" id="volunteer-program">
                    <label for="program">Select Volunteer Program</label>
                    <select class="form-control" id="program">
                        <option name="default" selected>Select Program</option>
                        <option name="SAT">SAT Prep</option>
                        <option name="ACT">ACT Prep</option>
                        <option name="Career">Career Counseling</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <button id="volunteer-cico-submit" class="btn btn-success" type="submit">Check-in</button>
                    </div>
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <button class="btn btn-danger" type="button">Back</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <!-- Volunteer CICO end -->
</div> <!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="../../public/js/global_login.js"></script>
</body>
</html>