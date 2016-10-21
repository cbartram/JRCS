<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Check-in</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../../public/css/Login.css" rel="stylesheet">
</head>

<body>

<div class="container">
<div class="row" id="volunteer-login">
    <h2 class="form-signin-heading" align="center">Volunteer Check-in</h2>

    <div class="col-lg-4 col-lg-offset-4">
        <div id="alert-cico"></div>
        <form class="form-signin">
            <input type="email" class="form-control" placeholder="Email" id="volunteer-email" style="width:100%;">
            <div class="row">
                <div class="col-md-12" style="height:25px;"></div>

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
                <div class="form-group" id="volunteer-program">
                    <label for="program">Select Volunteer Program</label>
                    <select class="form-control" id="program">
                        <option name="default" selected>Select Program</option>
                        <option name="SAT">SAT Prep</option>
                        <option name="ACT">ACT Prep</option>
                        <option name="Career">Career Counseling</option>
                    </select>
                </div>

                <!-- Submit & back buttons -->
                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <button class="btn btn-block btn-success" id="volunteer-cico-submit" type="submit">Check-in <i class="fa fa-check-square-o"></i></button>
                    </div>
                    <div class="col-md-12" style="height:25px;"></div>
                    <div class="col-md-12">
                        <a href="/donation"><button type="button" class="btn btn-block btn-success">File a Donation <i class="fa fa-money"></i></button></a>
                        <a href="/login">Staff Login</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Volunteer Check in end -->

<div class="row">
  <div class="col-lg-12">
<!-- Start of the volunteer check in table -->
<div class="panel panel-default" id="checked-in-table">
    <div class="panel-heading"><strong>Volunteers Checked In <i class="fa fa-check"></i></strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Checked-In</th>
                    <th>Check-Out</th>
                    </thead>
                    <tbody>
                    @foreach($volunteers as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->first_name . ' ' . $v->last_name }}</td>
                            <td><span class="label label-success">{{$v->check_in_timestamp}}</span></td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="{{$v->email}}"> Select this Volunteer
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <button class="btn btn-danger" id="check-out">Check-Out</button>
    </div>
</div>
</div>
</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>

<!-- Local Libraries -->
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Login.js"></script>
<script src="../../public/js/CICO.js"></script>
</body>
</html>