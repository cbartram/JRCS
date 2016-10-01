@if(Session::has('is_logged_in'))
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="../../public/css/volunteer_profile.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <!-- Modal open -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Volunteer ID</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        </thead>
                        <tbody id="table-body">
                        @foreach($volunteers as $volunteer)
                            <tr>
                                <td> {{$volunteer->first_name }} </td>
                                <td> {{$volunteer->last_name }} </td>
                                <td> {{$volunteer->id}} </td>
                                <td> {{$volunteer->email}} </td>
                                <td> {{$volunteer->city}} </td>
                                <td> {{$volunteer->state}} </td>
                                <td> {{$volunteer->zip_code}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal close -->
    <!-- Modal Add Volunteer open -->
    <div class="modal fade" id="add-volunteer-modal" tabindex="-1" role="dialog" aria-labelledby="add-volunteer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="myModalLabel">Add a Volunteer</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="../controller/register_controller.php" method="POST">
                        <div class="input-group">
                            <label for="first_name">Add a Volunteer</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                            <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                            <input type="text" name="address" class="form-control" id="address" placeholder="Address">
                            <input type="text" name="city" class="form-control" id="city" placeholder="City">
                            <input type="text" name="state" class="form-control" id="state" placeholder="State">
                            <input type="text" name="zip" class="form-control" id="zip" placeholder="Zip Code">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                            <input type="text" name="volunteer_type" class="form-control" id="volunteer_type" placeholder="Volunteer Type">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        </div><!-- /input-group -->
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary" name="submit" id="submit">Add Volunteer</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Volunteer close -->
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="https://www.gravatar.com/avatar/{{$gravEmail}}?d=http://aeroscripts.x10host.com/images/default.jpg" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        {{$staff->first_name . ' ' . $staff->last_name}}
                    </div>
                    <div class="profile-usertitle-job">
                        Group - {{$defaultGroup}}
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
                            <a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><i class="glyphicon glyphicon-plus"></i>New Volunteer</a>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-flag"></i>Help</a>
                        </li>
                        <li>
                            <a href="/logout"><i class="glyphicon glyphicon-log-out"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <ul class="nav nav-tabs">
                    <li role="presentation" id="add-volunteer"><a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><span class="glyphicon glyphicon-plus"></span> New Volunteer </a></li>
                    <li role="presentation" id="profile"><a href="#"><span class="glyphicon glyphicon-usd"></span> New Donation</a></li>
                    <li role="presentation" id="messages"><a href="#"><span class="glyphicon glyphicon-envelope"></span> New Event</a></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-random"></span>
                            &nbsp; Switch Organizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Organizations</li>
                            @if($groups['BEBCO'] == true)
                                @if($defaultGroup == 'BEBCO')
                                <li class="disabled"><a href="#">BEBCO - Current Organization</a></li>
                                @else
                                    <li><a href="/switch/BEBCO">BEBCO</a></li>
                                @endif
                            @endif
                            @if($groups['JACO'] == true)
                                @if($defaultGroup == 'JACO')
                                    <li class="disabled"><a href="#">JACO - Current Organization</a></li>
                                @else
                                    <li><a href="/switch/JACO">JACO</a></li>
                                @endif
                            @endif
                            @if($groups['JBC'] == true)
                                @if($defaultGroup == 'JBC')
                                    <li class="disabled"><a href="#">JBC - Current Organization</a></li>
                                @else
                                    <li><a href="/switch/JBC">JBC</a></li>
                                @endif
                            @endif
                            @if($groups['BEBCO'] == true && $groups['JACO'] == true && $groups['JBC'] == true)
                                @if($defaultGroup == 'ADMIN')
                                <li class="disabled"><a href="#">ADMIN - Current Organization</a></li>
                                @else
                                <li><a href="/switch/ADMIN">ADMIN</a></li>
                                @endif
                            @endif
                        </ul>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-xs-12" style="height:50px;"></div>
                </div>
                <div id="listing" class="row">
                    <!-- todo Load volunteer profile form -->
                </div>
            </div>
        </div>
        <div class="row profile">
            <div class="col-md-9">
                <br>
                <div class="profile-content" style="float:top;">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 style="color:black;">Volunteer Profiles</h2>
                            <hr>
                        </div>
                        @foreach ($volunteers as $volunteer)
                        <div class="col-lg-4">
                            <div class="well cart-item cart-script">
                                <h4 class="user-name"> {{$volunteer->first_name . ' ' . $volunteer->last_name}}</h4>
                                <div class="descr">
                                    <div class="pull-left icon-script icon-script-combat"></div><span class="vol-id">Volunteer with the ID: {{$volunteer->id}}</span></div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="cart-add btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-info-sign"></span> See more</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="../../public/js/volunteer_profile.js"></script>
</body>
</html>
@else
    <script type="text/javascript">
        //if the user is not logged in dont let them access the staff page
        window.location = "../";
    </script>
@endif