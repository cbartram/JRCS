<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Donation</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/public/css/Toastr_Bootstrap.css">
</head>

<body>

<div class="container">

    <!-- Row for donations that are approved or denied -->
    <div class="row" style="margin-top:25px;">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Donation History <i class="fa fa-history"></i></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Volunteer ID</th>
                                <th>Donation Group</th>
                                <th>Donation Type</th>
                                <th>Donation Value</th>
                                <th>Donation Date</th>
                                <th>Status</th>
                                <th>Approved/Denied By</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($donations as $donation)
                                <tr>
                                    <td>{{$donation->volunteer_id}}</td>
                                    <td>{{$donation->group_name}}</td>
                                    <td>{{$donation->donation_type}}</td>
                                    <td>{{$donation->donation_value}}</td>
                                    <td><span class="label label-primary">{{$donation->date}}</span></td>
                                    @if($donation->status == 'Approved')
                                    <td><span class="label label-success">{{$donation->status}}</span></td>
                                    @else
                                    <td><span class="label label-danger">{{$donation->status}}</span></td>
                                    @endif
                                    <td>{{Helpers::getStaffName($donation->action_by)}}</td>
                                    <td><button class="btn btn-sm btn-warning" data-id="{{$donation->donation_id}}">Re-Open <i class="fa fa-refresh"></i></button></td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row for archived volunteers -->
    <div class="row" style="margin-top:25px;">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Archived Volunteers <i class="fa fa-archive"></i></div>
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>Volunteer ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($volunteers as $volunteer)
                            <tr>
                                <td>{{$volunteer->id}}</td>
                                <td>{{$volunteer->first_name}}</td>
                                <td>{{$volunteer->last_name}}</td>
                                <td>{{$volunteer->email}}</td>
                                <td><button class="btn btn-sm btn-success un-archive" data-id="{{$volunteer->id}}">Renew Volunteer <i class="fa fa-refresh"></i></button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Row for archived programs -->
    <div class="row" style="margin-top:25px;">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Archived Programs <i class="fa fa-archive"></i></div>
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>Program Id</th>
                        <th>Program Name</th>
                        <th>Staff Name</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($programs as $p)
                            <tr>
                                <td>{{$p->id}}</td>
                                <td>{{$p->program_name}}</td>
                                <td>{{Helpers::getStaffName($p->staff_id)}}</td>
                                <td><button class="btn btn-sm btn-primary renew-program" data-id="{{$p->id}}">Renew Program <i class="fa fa-refresh"></i></button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row for archived events -->
    <div class="row" style="margin-top:25px;">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Archived Events <i class="fa fa-archive"></i></div>
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>Event Id</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Title</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($events as $e)
                            <tr>
                                <td>{{$e->id}}</td>
                                <td><span class="label label-success">{{$e->start}}</span></td>
                                <td><span class="label label-danger">{{$e->end}}</span></td>
                                <td>{{$e->title}}</td>
                                <td><button class="btn btn-sm btn-primary renew-event" data-id="{{$e->id}}">Renew Event <i class="fa fa-refresh"></i></button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-3" style="margin-bottom:20px">
            <a href="../profile"><button class="btn btn-block btn-default">
                Back <i class="fa fa-undo"></i>
            </button></a>
        </div>
    </div>
</div> <!-- /container -->

<!-- Local JS Files -->
<script src="/public/js/Archive.js"></script>

</body>
</html>
