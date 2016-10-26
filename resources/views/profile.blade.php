@extends('components.navbar')

@section('content')
<div class="container">

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
                       <div class="row">
                       <div class="col-md-6 col-md-offset-6" style="margin-top:20px;">
                           <form method="get" action="/event/remove">
                           <div class="input-group input-group-lg">
                               <input type="text" class="form-control" name="id" placeholder="Event ID">
                               <span class="input-group-btn">
                                    <button type="submit" class="btn btn-danger">Remove Event <span class="fa fa-trash"></span></button>
                                </span>
                           </div>
                           </form>
                       </div>
                   </div>
                   </div>
               </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Event Log <span class="fa fa-pencil"></span> <span class="fa fa-minus fa-2x"></span></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="color:black;">Event Log</h4>
                                <table class="table table-striped">
                                    <thead>
                                    <th>Event ID</th>
                                    <th>Event Title</th>
                                    <th>Start Date</th>
                                    <th>Attendees</th>
                                    <th>Volunteers</th>
                                    <th>Total Hours Volunteered</th>
                                    <th>Donations</th>
                                    </thead>
                                    <tbody>
                                        @foreach($log as $l)
                                          <tr>
                                            <td>{{$l->event_id}}</td>
                                            <td>{{$l->title}}</td>
                                            <td>{{$l->start}}</td>
                                            <td>@if($l->attendee_count == 0) - @else {{$l->attendee_count}} @endif</td>
                                            <td>@if($l->volunteer_count == 0) - @else {{$l->volunteer_count}} @endif</td>
                                            <td>@if($l->total_volunteer_hours == 0) - @else {{$l->total_volunteer_hours}} @endif</td>
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
                                <h4 class="user-name"> {{$volunteer->first_name . ' ' . $volunteer->last_name . ' - ' .  Helpers::getGroups($volunteer->email)}}</h4>
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

    @if($defaultGroup == 'ADMIN' || Redis::get('drop'))
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