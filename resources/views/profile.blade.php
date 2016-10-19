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
    <link href="../../public/css/Profile.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                JRCS
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            @if(!Auth::guest())
                <ul class="nav navbar-nav">
                    <li role="presentation" id="add-volunteer"><a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><span class="glyphicon glyphicon-plus"></span> New Volunteer </a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="profile"><a href="#"><span class="glyphicon glyphicon-usd"></span> Pending Donations</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="messages"><a href="#"><i class="fa fa-calendar"></i> New Event</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li role="presentation" id="checkout-volunteer"><a href="#"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
                </ul>
        @endif

        <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li role="presentation" id="add-volunteer"><a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><span class="fa fa-user-plus"></span> New Volunteer </a></li>
                    <li role="presentation" id="profile"><a href="#" data-toggle="modal" data-target="#pending-donations"><span class="glyphicon glyphicon-usd"></span> Pending Donations</a></li>
                    <li role="presentation" id="messages"><a  href="#"><span class="fa fa-calendar"></span> New Event</a></li>
                    <li role="presentation" id="checkout-volunteer"><a href="#"><span class="glyphicon glyphicon-log-out"></span> Checkout</a></li>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-random"></span>
                            &nbsp; Switch Organizations <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Organizations</li>
                            @foreach($groups as $k => $v)
                                @if($groups[$k] == true)
                                    @if($defaultGroup == $k)
                                        <li class="disabled"><a href="#">{{$k}} - Current Organization</a></li>
                                    @else
                                        <li><a href="/switch/{{$k}}">{{$k}}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/availability') }}"><i class="fa fa-btn fa-bed"></i>Availability</a></li>
                            <li><a href="{{ url('/home') }}"><i class="fa fa-btn fa-tachometer"></i>Dashboard</a></li>
                            <li><a href="{{ url('/search') }}"><i class="fa fa-btn fa-search"></i>Search</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>


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
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        </thead>
                        <tbody id="table-body">
                        <!-- Load Volunteer Demographic info -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal close -->

    <!-- Modal open -->
    <div class="modal fade" id="pending-donations" tabindex="-1" role="dialog" aria-labelledby="pending-donations">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="myModalLabel">Pending Donations</h4>
                </div>
                <div class="modal-body">

                    <!-- Donation Table -->
                        <table class="table table-striped">
                            <thead>
                            <th>Donation ID</th>
                            <th>Volunteer Name</th>
                            <th>Group Donation</th>
                            <th>Donation Type</th>
                            <th>Donation Value</th>
                            <th>Donation Description</th>
                            <th>Status</th>
                            <th>Donation Date</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <td>{{$donation->donation_id}}</td>
                                    <td>{{$donation->first_name . " " . $donation->last_name}}</td>
                                    <td>{{$donation->group_name}}</td>
                                    <td>{{$donation->donation_type}}</td>
                                    @if($donation->donation_value != 'null')
                                        <td>{{$donation->donation_value}}</td>
                                    @else
                                        <td>$0.00</td>
                                    @endif
                                    <td>{{$donation->donation_description}}</td>
                                    <td><span class="label label-warning">{{$donation->status}}</span></td>
                                    <td><span class="label label-primary">{{$donation->date}}</span></td>
                                    <td>
                                        <a href="/donation/approve/{{$donation->donation_id}}"><button type="button" class="btn btn-success">Approve</button></a>
                                        <a href="/donation/deny/{{$donation->donation_id}}"><button type="button" class="btn btn-danger">Deny</button></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal close -->


    <!-- Modal open -->
    <div class="modal fade" id="account-settings-modal" tabindex="-1" role="dialog" aria-labelledby="account-settings-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="myModalLabel">Account Settings</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Select your Default group</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{Form::open(array('url' => '/settings', 'method' => 'post'))}}
                            @if (Helpers::hasAccessTo('BEBCO', Session::get('id')))
                                <div class="checkbox">
                                    <label>{{ Form::radio('group-radio', 'BEBCO') }} Set BEBCO as Default</label>
                                </div>
                            @endif
                            @if (Helpers::hasAccessTo('JACO', Session::get('id')))
                                <div class="checkbox">
                                    <label>{{ Form::radio('group-radio', 'JACO') }} Set JACO as Default</label>

                                </div>
                            @endif
                            @if (Helpers::hasAccessTo('JBC', Session::get('id')))
                                <div class="checkbox disabled">
                                    <label>{{ Form::radio('group-radio', 'JBC') }} Set JBC as Default</label>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                            {{Form::close()}}
                        </div>
                    </div>


                    <!-- Start of the staff member view themselves part of the modal -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>View yourself in the Volunteer Cards</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{Form::open(array('url' => '/settings/self', 'method' => 'post'))}}
                            @if(Session::has('volunteer_id'))
                                @if(Session::has('show-self'))
                                    <div class="checkbox">
                                        <label>{{Form::checkbox('self-checkbox', 'true', true) }} Show Yourself</label>
                                    </div>
                                @else
                            <div class="checkbox">
                                <label>{{Form::checkbox('self-checkbox', 'true', false) }} Show Yourself</label>
                            </div>
                                @endif
                            @else
                                <div class="checkbox disabled">
                                    <label>{{Form::checkbox('self-checkbox', 'true', false, array('disabled')) }} Show Yourself</label>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                            {{Form::close()}}
                        </div>
                    </div>
                    <!-- Start of the password reset option -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Reset your Password</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{Form::open(array('url' => '/password', 'method' => 'post'))}}
                            {{Form::password('password-text', Input::old('email'), array('placeholder' => 'New Password', 'class' => 'form-control'))}}
                            {{Form::password('password-confirm', Input::old('email'), array('placeholder' => 'Confirm Password', 'class' => 'form-control'))}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{Form::submit('Reset Password', array('class' => 'btn btn-primary')) }}
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
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
                    {{ Form::open(array('url' => '/add', 'method' => 'post')) }}
                        <div class="input-group">
                            <label for="first_name">Add a Volunteer</label>
                            <p>{{ Form::text('first_name', Input::old('email'), array('placeholder' => 'First Name', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('last_name', Input::old('email'), array('placeholder' => 'Last Name', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('address', Input::old('email'), array('placeholder' => 'Address', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('city', Input::old('email'), array('placeholder' => 'City', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('state', Input::old('email'), array('placeholder' => 'State', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('zip', Input::old('email'), array('placeholder' => 'Zip Code', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::text('phone', Input::old('email'), array('placeholder' => 'Phone', 'class' => 'form-control')) }}</p>
                            <p>{{ Form::select('volunteer_type', array('General' => 'General', 'Program' => 'Program', 'Board' => 'Board'), 'General'), array('class' => 'form-control')}}</p>

                        @if (Helpers::hasAccessTo('BEBCO', Session::get('id')))
                                <div class="checkbox">
                                    <label>{{ Form::checkbox('bebco-checkbox', 'true') }} Add to BEBCO</label>
                                </div>
                            @endif
                            @if (Helpers::hasAccessTo('JACO', Session::get('id')))
                                <div class="checkbox">
                                    <label>{{ Form::checkbox('jaco-checkbox', 'true') }} Add to JACO</label>

                                </div>
                             @endif
                            @if (Helpers::hasAccessTo('JBC', Session::get('id')))
                                <div class="checkbox disabled">
                                    <label>{{ Form::checkbox('jbc-checkbox', 'true') }} Add to JBC</label>
                                </div>
                            @endif

                        </div><!-- /input-group -->
                        <div class="input-group">
                            {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                        </div>
                    {{Form::close()}}
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
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="https://www.gravatar.com/avatar/{{$gravEmail}}?d=http://aeroscripts.x10host.com/images/default.jpg&s=350" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        {{$staff->first_name . ' ' . $staff->last_name}}
                    </div>
                    <div class="profile-usertitle-job">
                        Group - {{$defaultGroup}}
                    </div>
                </div>
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="#"><i class="fa fa-tachometer"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#account-settings-modal"><i class="fa fa-user"></i>Account Settings</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><i class="fa fa-user-plus"></i>New Volunteer</a>
                        </li>
                        <li>
                            <a href="/logout"><i class="glyphicon glyphicon-log-out"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
       </div>
     </div>

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
            <div class="profile-content">
                <div class="row">
                    <div class="col-xs-12"></div>
                </div>
                <div id="listing" class="row">
                    <!-- Highcharts chart is loaded here -->
                </div>
            </div>
        </div>
      </div>
    </div>


        <div class="row profile">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Alerts</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Error!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <div class="flash-message">
                                    <p class="alert alert-{{ $msg }} alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        {{ Session::get('alert-' . $msg) }}
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Volunteer Profiles</div>
                    <div class="panel-body">
                <div class="profile-content" style="float:top;">
                    <div class="row">
                        @foreach($volunteers as $volunteer)
                        <div class="col-lg-4">
                            <div class="well cart-item cart-script">
                                <h4 class="user-name"> {{$volunteer->first_name . ' ' . $volunteer->last_name}}</h4>
                                <div class="descr">
                                    <div class="pull-left icon-script">
                                      <span class="fa fa-user fa-3x"></span>
                                    </div>
                                        <span class="vol-id">Volunteer with the ID: {{$volunteer->id}}</span>
                                </div>
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
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>
<script src="../../public/js/Highcharts.js"></script>

<script src="../../public/js/Chart.js"></script>
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Profile.js"></script>
</body>
</html>