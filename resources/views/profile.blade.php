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
                    <img style="height:130px; width:130px; border-radius:50%" src="https://www.gravatar.com/avatar/{{$gravEmail}}?d=http://demo.clearsense.com/files/CSDE-618/img/gravatar-male.svg&s=350" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        {{$staff->first_name . ' ' . $staff->last_name}}
                    </div>
                    <div class="profile-usertitle-job">
                        <p id="current-group">Group - {{$defaultGroup}}</p>
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
                            <a href="/logout"><i class="fa fa-sign-out"></i>Logout</a>
                        </li>
                    </ul>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                    <div class="col-md-3">
                        <select id="timeframe" class="form-control">
                            <option value="1">1 Day</option>
                            <option value="3">3 Days</option>
                            <option value="5">5 Days</option>
                            <option value="7" selected>1 Week</option>
                            <option value="14">2 Weeks</option>
                            <option value="21">3 Weeks</option>
                            <option value="31" id="month">1 Month</option>
                        </select>
                    </div>
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

                       <div class="row">
                           <div class="col-md-2">
                               <div class="btn-group" role="group">
                                   <button type="button" class="btn btn-md btn-primary" id="prev"><i class="fa fa-chevron-left"></i></button>
                                   <button type="button" class="btn btn-md btn-primary" id="next"><i class="fa fa-chevron-right"></i></button>
                               </div>
                           </div>
                           <div class="col-md-1">
                               <button type="button" class="btn btn-default" id="today">Today</button>
                           </div>
                           <div class="col-md-3 col-md-offset-6">
                               <div class="input-group">
                                   <input type="text" class="form-control" id="goToDate" placeholder="MM/DD/YYYY">
                                   <span class="input-group-btn">
                                    <button type="submit" id="date-btn" class="btn btn-primary">Go To Date <span class="fa fa-arrow"></span></button>
                                </span>
                               </div>
                           </div>
                       </div>

                       <!-- FullCal Calendar is loaded here -->
                       <div id="calendar"></div>

                       <!-- Delete Calendar event button group -->
                       <div class="row">
                           <form method="get" action="/event/remove">
                       <div class="col-md-3 col-md-offset-7" style="margin-top:20px;">
                               <select class="form-control" name="id">
                                   @foreach($log as $event)
                                       {{--If the event is not logged it could have taken place, its just not been logged yet --}}
                                       {{-- todo this condition can be removed depending on what laura says--}}
                                       @if($event->log_status == 0)
                                           <option value="{{$event->id}}">{{$event->title}}</option>
                                       @endif
                                   @endforeach
                               </select>
                       </div>
                       <div class="col-md-2" style="margin-top:20px;">
                           <button type="submit" class="btn btn-danger">Remove Event <span class="fa fa-trash"></span></button>
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
                                <div class="table-responsive">
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
                                {{ $log->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Volunteer Table <span class="fa fa-list"></span> <span class="fa fa-minus fa-2x"></span></div>
                    <div class="panel-body panel-sortable">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>See More</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($volunteers as $volunteer)
                                            <!-- Each Accordian parent row -->
                                            <tr>
                                                <td><span class="label label-primary">{{$volunteer->id}}</span></td>
                                                <td>{{Helpers::getName($volunteer->id)}}</td>
                                                <td>{{Helpers::getGroups($volunteer->id)}}</td>
                                                <td><a id="accordian{{$loop->index}}" role="button" aria-controls="collapse{{$loop->index}}"
                                                       data-toggle="collapse" data-index="{{$loop->index}}" href="#collapse{{$loop->index}}"
                                                       data-target="#collapse{{$loop->index}}" data-id="{{$volunteer->id}}"
                                                       data-render="#chart{{$loop->index}}" aria-expanded="true" class="btn btn-default collapsable">
                                                       <i class="fa fa-angle-down"></i></a>
                                                </td>
                                            </tr>

                                            <!-- Accordian Dropdown -->
                                            <tr>
                                                <td colspan="4" class="no-padd no-border">
                                                    <div class="collapse-content collapse"  id="collapse{{$loop->index}}">
                                                        <div class="row collapse-inner" id="collapse-inner{{$loop->index}}">
                                                            <div class="col-sm-4">
                                                                <h6>Current Volunteer Hours</h6>

                                                                <div class="row">
                                                                    <div class="col-sm-6 text-center">
                                                                        <div class="vitals-icon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                        <div class="vitals-text">
                                                                            <div class="number" ><span class="not-found bebco-number"></span></div>
                                                                            <div class="uom">Bebco</div>
                                                                            <!--<div class="time">Updated _ ago</div>-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 text-center">
                                                                        <div class="vitals-icon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                        <div class="vitals-text">
                                                                            <div class="number" ><span class="not-found jaco-number"></span></div>
                                                                            <div class="uom">Jaco</div>
                                                                            <!--<div class="time">Updated _ ago</div>-->
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <hr />

                                                                <div class="row">
                                                                    <div class="col-sm-6 text-center">
                                                                        <div class="vitals-icon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                        <div class="vitals-text">
                                                                            <div class="number"><span class="not-found jbc-number"></span></div>
                                                                            <div class="uom">Jbc</div>
                                                                            <!--<div class="time">Updated _ ago</div>-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 text-center">
                                                                        <div class="vitals-icon">
                                                                            <i class="fa fa-clock-o"></i>
                                                                        </div>
                                                                        <div class="vitals-text">
                                                                            <div class="number"><span class="not-found all-number"></span></div>
                                                                            <div class="uom">Jrcs</div>
                                                                            <!--<div class="time">Updated _ ago</div>-->
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <h6>Volunteer Hours Over Time</h6>
                                                                <div class="chart-wrap">
                                                                    <!-- Highcharts volunteer chart is loaded here -->
                                                                    <div id="chart{{$loop->index}}" style="height: 280px;"></div>
                                                                    <a class="btn btn-primary btn-block" href="volunteer/search/?group={{$defaultGroup}}&email={{$volunteer->email}}" type="button">View Volunteer Details</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>

    @if($defaultGroup == 'ADMIN' || Session::get('drop') || $defaultGroup == "JRCS")
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
                {{--<div class="row">--}}
                    {{--<div class="col-lg-8 col-lg-offset-3">--}}
                        {{--{{$all->links()}}--}}
                    {{--</div>--}}
                {{--</div>--}}
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
                {{--<div class="row">--}}
                    {{--<div class="col-lg-8 col-lg-offset-3">--}}
                        {{--{{$all->links()}}--}}
                    {{--</div>--}}
                {{--</div>--}}
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
                {{--<div class="row">--}}
                    {{--<div class="col-lg-8 col-lg-offset-3">--}}
                        {{--{{$all->links()}}--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Delete Volunteer <span class="fa fa-trash"></span> <span class="fa fa-minus fa-2x"></span></div>
                <div class="panel-body panel-sortable">
                   <div class="row">
                       <div class="col-lg-4 col-lg-offset-4">
                           <button class="btn btn-block btn-danger" id="delete">Archive Volunteers <span class="fa fa-trash"></span></button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    @endif


</div> <!-- Closes container -->
@endsection