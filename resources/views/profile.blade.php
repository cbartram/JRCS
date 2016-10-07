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
                            <p>{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}</p>
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
                            <a href="#" data-toggle="modal" data-target="#account-settings-modal"><i class="glyphicon glyphicon-user"></i>Account Settings</a>
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
                    <li role="presentation" id="checkout-volunteer"><a href="#"><span class="glyphicon glyphicon-log-out"></span> Checkout Volunteer</a></li>
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
                </ul>
                <div class="row">
                    <div class="col-xs-12" style="height:50px;"></div>
                </div>
                <div id="listing" class="row">
                    <!-- todo Load volunteer profile form -->
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
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
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                            </div>
                            @endif
                        @endforeach
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
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/volunteer_profile.js"></script>
</body>
</html>
@else
    <script type="text/javascript">
        //if the user is not logged in dont let them access the staff page
        window.location = "../";
    </script>
@endif