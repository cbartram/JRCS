<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/public/css/images/favicon.ico">

    <title>Volunteer Check-in</title>

    <!-- Latest compiled and minified CSS -->
    <link href="/public/css/CICO.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_collapse_fixed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-logo" href="/"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar_collapse_fixed">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/donation">
                            Donation <span class="fa fa-money"></span>
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            Help <span class="fa fa-question"></span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="/login" id="dropdownProfile">
                            Staff Profile <span class="fa fa-chevron-right user"></span>
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-2" style="margin-top:15px">
            <h2 class="form-signin-heading" align="center">Volunteer Check-in</h2>
        </div>
    </div>

    <div class="row" id="volunteer-login">
        <div class="col-lg-5" style="margin-top:25px">
            <div id="alert-cico"></div>
            <form class="form-signin">
                <input type="email" class="form-control" placeholder="Email" id="volunteer-email" style="width:100%;">
                <div class="row">
                    <div class="col-md-12" style="margin-top:25px">

                        <!-- Volunteer type selector -->
                        <div class="form-group">
                            <select class="form-control" id="volunteer-type" style="width:100%">
                                <option name="default" selected>Select Volunteer Type</option>
                                <option name="program">Program</option>
                                <option name="board">Board</option>
                                <option name="general">General</option>
                                <option name="other">Other</option>
                            </select>
                        </div>

                        <!-- Hidden form only visible to program volunteers -->
                        <div class="input-group" id="volunteer-program">
                            <label for="program">Select Volunteer Program</label>
                            <select class="form-control" id="program">
                                <option name="default" selected>Select Program</option>
                                @foreach($programs as $program)
                                    <option name="{{$program->program_name}}">{{$program->program_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Submit & back buttons -->
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <button class="btn btn-block btn-success" id="volunteer-cico-submit" type="submit">Check-in <i class="fa fa-check-square-o"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Volunteer Check in end -->

        <div class="col-lg-6">
            <!-- Start of the volunteer check in table -->
            <div class="panel panel-default" id="checked-in-table">
                <div class="panel-heading"><strong>Volunteers Checked In <i class="fa fa-check"></i></strong> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Checked-In</th>
                                <th>Check-Out</th>
                                </thead>
                                <tbody>
                                @foreach($volunteers as $v)
                                    <tr id="{{$v->id}}">
                                        <td>{{Helpers::getName($v->volunteer_id)}}</td>
                                        <td>{{$v->email}}{{-- First name and last name goes here --}}</td>
                                        <td><span class="label label-success">{{$v->check_in_timestamp}}</span></td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="{{$v->id}}"> Select
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-7 col-lg-offset-3">
                            <button class="btn btn-block btn-danger" id="check-out">Check-Out <span class="fa fa-sign-out"></span></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-5">
                            {{$volunteers->links()}}
                        </div>
                    </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-4">
                <p class="text-muted">&copy; JRCS Volunteer Management Solutions</p>
            </div>
        </div>
    </div>
</footer>


<!-- Local Libraries -->
<script src="/public/js/CICO.js"></script>

</body>
</html>
