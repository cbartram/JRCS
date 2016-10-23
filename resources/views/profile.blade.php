@extends('components.navbar')

@section('content')
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


    <!-- Modal add event open -->
    <div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="event">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="event-add">Add a Calendar Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="start-date" placeholder="Start Date">
                        <input type="text" class="form-control" id="end-date" placeholder="End Date">
                        <input type="text" class="form-control" id="title" placeholder="Event Title">
                        <button type="button" class="btn btn-primary" id="create-event" data-dismiss="modal">Create Event</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal close -->


    <!-- Modal Log Event open -->
    <div class="modal fade" id="log-event-modal" tabindex="-1" role="dialog" aria-labelledby="log-event-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="event-add">Log a Recent Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{Form::open(array('url' => '/event'))}}
                            {{Form::text('event-id', Input::old('event-id'), ['placeholder' => 'Event ID', 'class' => 'form-control']) }}
                            {{Form::text('attendee_count', Input::old('attendee_count'), ['placeholder' => 'Attendee Count', 'class' => 'form-control']) }}
                            {{Form::textarea('event_description', Input::old('event_description'), ['placeholder' => 'Event Description', 'class' => 'form-control'])}}
                            {{Form::text('volunteer_count', Input::old('volunteer_count'), ['placeholder' => 'Volunteer Count', 'class' => 'form-control']) }}
                            {{Form::text('volunteer_hours', Input::old('volunteer_hours'), ['placeholder' => 'Total Volunteer Hours', 'class' => 'form-control']) }}
                            {{Form::text('donation_amount', Input::old('donation_amount'), ['placeholder' => 'Donation Amount', 'id' => 'donation_amount', 'class' => 'form-control']) }}

                        {{Form::submit('Log Event', ['class' => 'btn btn-primary'])}}
                        {{Form::close()}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal close -->



    <!-- Modal for copy or switch -->
    <div class="modal fade" id="copy" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:black;">Copy or Switch</h4>
                </div>
                <div class="modal-body">
                    <p>Would you like to copy the volunteer over to the new group
                        or switch the volunteer to the new group?</p>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="label label-warning">Warning!</span>
                            <p>This will add the volunteer to new group without removing them from their current group.</p>
                            <button type="button" id="copy-btn" class="btn btn-primary" data-dismiss="modal">Copy Volunteer <span class="fa fa-files-o"></span></button>
                        </div>
                        <div class="col-md-6">
                            <span class="label label-warning">Warning!</span>
                            <p>This will remove the volunteer from their current group and switch them over to the new group.</p>
                           <button type="button" id="switch-btn" class="btn btn-warning" data-dismiss="modal">Switch Volunteer <span class="fa fa-random"></span></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal open -->
    <div class="modal fade" id="pending-donations" tabindex="-1" role="dialog" aria-labelledby="pending-donations">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:black;" id="pending-donations">Pending Donations</h4>
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
                            <th>Approve</th>
                            <th>Deny</th>
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
                                        <a href="/donation/approve/{{$donation->donation_id}}"><button type="button" class="btn btn-primary"><span class="fa fa-thumbs-o-up"></span></button></a>
                                    </td>
                                    <td>
                                        <a href="/donation/deny/{{$donation->donation_id}}"><button type="button" class="btn btn-danger"><span class="fa fa-thumbs-o-down"></span></button></a>
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
                    <h4 class="modal-title" style="color:black;" id="acct-settings">Account Settings</h4>
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
                    <h4 class="modal-title" style="color:black;" id="vol-add">Add a Volunteer</h4>
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
                <div class="panel-heading">Profile <span class="fa fa-user"></span> <span class="fa fa-minus fa-2x"></span></div>
                <div class="panel-body" id="test">
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
                        <li>
                            <a href="#"><i class="fa fa-tachometer"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#account-settings-modal"><i class="fa fa-cog"></i>Account Settings</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#add-volunteer-modal"><i class="fa fa-user-plus"></i>New Volunteer</a>
                        </li>
                        <li>
                            <a href="#" id="hide-all"><i class="fa fa-eye-slash"></i>Show/Hide All</a>
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
                <div class="panel-heading">Dashboard <span class="fa fa-tachometer"></span> <span class="fa fa-minus fa-2x"></span></div>
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

            <div class="col-md-12">
               <div class="panel panel-default">
                   <div class="panel-heading">Events <span class="fa fa-calendar"></span> <span class="fa fa-minus fa-2x"></span></div>
                   <div class="panel-body">
                       <!-- FullCal Calendar is loaded here -->
                       <div id="calendar"></div>
                   </div>
               </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Event Log <span class="fa fa-pencil"></span> <span class="fa fa-minus fa-2x"></span></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="color:black;">Events Coming up</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <th>Event ID</th>
                                        <th>Title</th>
                                        <th>Start Date</th>
                                    </thead>
                                    <tbody>
                                            @foreach($calendar as $c)
                                           <tr>
                                              <td>{{$c->id}}</td>
                                              <td>{{$c->title}}</td>
                                              <td>{{$c->start}}</td>
                                           </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="color:black;">Event Log</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <th>Event ID</th>
                                    <th>Attendees</th>
                                    <th>Volunteers</th>
                                    <th>Total Hours Volunteered</th>
                                    <th>Donations</th>
                                    </thead>
                                    <tbody>
                                        @foreach($log as $l)
                                          <tr>
                                            <td>{{$l->event_id}}</td>
                                            <td>{{$l->attendee_count}}</td>
                                            <td>{{$l->volunteer_count}}</td>
                                            <td>{{$l->total_volunteer_hours}}</td>
                                            <td>{{$l->donation_amount}}</td>
                                          </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Volunteer Profiles <span class="fa fa-users"></span> <span class="fa fa-minus fa-2x"></span></div>
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

    @if($defaultGroup == 'ADMIN')
    <!-- Start to Swap and Copy Volunteer Profiles -->
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">BEBCO <span class="fa fa-folder"></span> <span class="fa fa-minus fa-2x"></span></div>
                <div class="panel-body panel-sortable">
                    @foreach($all as $a)
                        @if($a->bebco_volunteer == 1)
                            <div class="portlet">
                                <div class="portlet-header"><span class="fa fa-user"></span> {{$a->first_name . " " . $a->last_name}}</div>
                                    <div class="portlet-content">
                                         <p>Volunteer Id:<strong>{{$a->id}}</strong></p>
                                        <p>Email: <strong>{{$a->email}}</strong></p>
                                     </div>
                                 </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">JACO <span class="fa fa-folder"></span> <span class="fa fa-minus fa-2x"></span></div>
                <div class="panel-body panel-sortable">
                    @foreach($all as $a)
                        @if($a->jaco_volunteer == 1)
                            <div class="portlet">
                                <div class="portlet-header"><span class="fa fa-user"></span> {{$a->first_name . " " . $a->last_name}}</div>
                                <div class="portlet-content">
                                    <p>Volunteer Id:<strong>{{$a->id}}</strong></p>
                                    <p>Email: <strong>{{$a->email}}</strong></p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">JBC <span class="fa fa-folder"></span> <span class="fa fa-minus fa-2x"></span></div>
                <div class="panel-body panel-sortable">
                    @foreach($all as $a)
                        @if($a->jbc_volunteer == 1)
                            <div class="portlet">
                                <div class="portlet-header"><span class="fa fa-user"></span> {{$a->first_name . " " . $a->last_name}}</div>
                                <div class="portlet-content">
                                    <p>Volunteer Id:<strong>{{$a->id}}</strong></p>
                                    <p>Email: <strong>{{$a->email}}</strong></p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Delete Volunteer <span class="fa fa-trash"></span> <span class="fa fa-minus fa-2x"></span></div>
                <div class="panel-body panel-sortable">
                    <button class="btn btn-danger" id="delete">Delete Volunteers <span class="fa fa-trash"></span></button>
                </div>
            </div>
        </div>
    </div>
    @endif


</div> <!-- Closes container -->
@endsection