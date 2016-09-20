<?php
$remember_me_password = false;
$remember_me_email = false;
if(isset($_COOKIE['remember_me_password'])) {$remember_me_password = true;}
if(isset($_COOKIE['remember_me_email'])) {$remember_me_email = true;}
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
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form class="form-signin">
                <h2 class="form-signin-heading">Volunteer Login</h2>
                <div id="alert"></div>
                <?php if(isset($_GET['response'])) { echo '<div class="alert alert-success">' . $_GET['response'] . '</div>';} ?>
                <label for="inputEmail" class="sr-only">Email address or Volunteer ID</label>
                <input type="text" id="inputEmail" class="form-control" placeholder="Email address or Volunteer ID" value="<?php echo $_COOKIE['remember_me_email'] ?>">
                <br>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $_COOKIE['remember_me_password'] ?>">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="remember-me" value="remember-me"> Remember me
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button data-login-type="JACO" class="btn btn-sm btn-primary" type="submit">JACO Login</button>
                    </div>
                    <div class="col-md-4">
                        <button data-login-type="BEBCO" class="btn btn-sm btn-primary" type="submit">BEBCO Login</button>
                    </div>
                    <div class="col-md-4">
                        <button data-login-type="JBC" class="btn btn-sm btn-primary" type="submit">JBC Login</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <button data-login-type="ADMIN" class="btn btn-sm btn-success" type="submit">Admin Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-4"></div>

</div> <!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="../../public/js/global_login.js"></script>
</body>
</html>