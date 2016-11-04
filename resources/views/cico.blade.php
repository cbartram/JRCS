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
<!-- Nav Bar at Top -->
<ul>
    <li><a href="#home">Volunteer Check-In</a></li>
    <li><a href="/login">Staff Login</a></li>
    <li style="float: right; background-color: darkred"><a href="/donation">Donation</a></li>
</ul>

<!-- Container -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <div id="alert-cico"></div>
            <br><br><br><br>
            <h2 align="center"> Volunteer Check-in</h2>
            <form class="form-signin">
                <input type="email" class="form-control" placeholder="Email" id="volunteer-email" style="width:100%;">
                <br>
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
                        @foreach($programs as $program)
                            <option name="{{$program->program_name}}">{{$program->program_name}}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Submit & back buttons -->
                <div class="row">
                    <div class="col-md-12" style="height:25px;"></div>
                    <center>
                        <button class="buttonDef button2" id="volunteer-cico-submit" type="submit">Check-in</button>
                    </center>
                    <div class="col-md-12" style="height:25px;"></div>
                </div>
            </form>
        </div>
        <!-- Volunteer Check in end -->
        <!-- Start of the volunteer check in table -->
        <div class="col-sm-8">
            <br><br><br>
            <div class="panel panel-default" id="checked-in-table">
                <div class="panel-heading"><strong>Volunteers Checked In</strong></div>

                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <th>Name</th>
                        <th>Id</th>
                        <th>Checked-In</th>
                        <th>Check-Out</th>
                        </thead>
                        <tbody>
                        @foreach($volunteers as $v)
                            <tr>
                                <td>{{$v->first_name . ' ' . $v->last_name }}</td>
                                <td>{{$v->id}}</td>
                                <td><span class="label label-success">{{$v->check_in_timestamp}}</span></td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="{{$v->email}}">
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <center><button class="btn btn-danger" id="check-out">Check-Out</button></center>
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
