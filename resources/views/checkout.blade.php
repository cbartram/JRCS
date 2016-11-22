<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Volunteer Checkout</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel-default" style="margin-top:25px;">
                <div class="panel-heading">Checkout Volunteers</div>
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-bordered edit">
                        <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Checked-In</th>
                        <th>Check-Out</th>
                        </thead>
                        <tbody>
                        @foreach($volunteers as $v)
                            <tr>
                                <td class="id">{{$v->id}}</td>
                                <td>{{Helpers::getName($v->volunteer_id)}}</td>
                                <td>{{$v->email}}</td>
                                <td class="timestamp">{{$v->check_in_timestamp}}</td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="{{$v->id}}"> Select this Volunteer
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <button id="check-out" class="btn btn-block btn-danger">Check Out <span class="fa fa-sign-out"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-lg-offset-3" style="margin-top:15px;">
            <a href="/profile">
                <button class="btn btn-block btn-default">Back <span class="fa fa-undo"></span></button>
            </a>
        </div>
    </div>

</div> <!-- /container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>
<script src="../../public/js/moment.js"></script>
<script src="../../public/js/jquery.tabledit.min.js"></script>


<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/CICO.js"></script>

</body>
</html>