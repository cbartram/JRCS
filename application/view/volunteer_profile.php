<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/14/16
 * Time: 3:35 PM
 */
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

    <title>Volunteer Profile</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../../public/css/volunteer_profile.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="<?php echo $grav_url ?>" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $user->get_name($_SESSION['email']); ?>
                    </div>
                    <div class="profile-usertitle-job">
                        Group - <?php echo $_SESSION['user_group']; ?>
                    </div>
                </div>
                <div class="profile-userbuttons">
                    <button type="button" class="btn btn-success btn-sm">Action One</button>
                    <button type="button" class="btn btn-danger btn-sm">Action Two</button>
                </div>
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-home"></i>Overview</a>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-user"></i>Account Settings</a>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-ok"></i>Tasks</a>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-flag"></i>Help</a>
                        </li>
                        <li>
                            <a href="../controller/global_logout.php"><i class="glyphicon glyphicon-log-out"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#">Home</a></li>
                    <li role="presentation"><a href="#">Profile</a></li>
                    <li role="presentation"><a href="#">Messages</a></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Switch Organizations<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Organizations</li>
                            <?php include '../model/volunteer_profile_model.php' ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row profile">
            <div class="col-md-9">
                <br>
                <div class="profile-content" style="float:top;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>


<!--

  <li>
                        <div class="btn-group-vertical" role="group">
                            <a style="margin-left:15px;" href="#" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-menu-hamburger"></i>Dropdown</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Dropdown header</li>
                                <li><a href="#">Dropdown link</a></li>
                                <li><a href="#">Dropdown link</a></li>
                            </ul>
                        </div>
                    </div>
                     </li>

                 -->