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
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default" style="margin-top:25px;">
                <div class="panel-heading">Search Results</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered volunteer">
                            <thead>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$volunteer->id}}</td>
                                    <td>{{$volunteer->first_name}}</td>
                                    <td>{{$volunteer->last_name}}</td>
                                    <td>{{$volunteer->email}}</td>
                                    <td>{{$volunteer->phone}}</td>
                                    <td>{{$volunteer->city}}</td>
                                    <td>{{$volunteer->state}}</td>
                                    <td>{{$volunteer->zip_code}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default" style="margin-top:25px;">
                <div class="panel-heading">Search Results</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            </thead>
                            <tbody>
                            @foreach($cico as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{Helpers::getName($c->volunteer_id)}}</td>
                                <td>{{$c->email}}</td>
                                <td>{{$c->check_in_timestamp}}</td>
                                <td>{{$c->check_out_timestamp}}</td>
                            </tr>
                             @endforeach
                            </tbody>
                        </table>
                        {{$cico->links()}}
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>
<script src="../../public/js/jquery.tabledit.min.js"></script>


<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Search.js"></script>

</body>
</html>