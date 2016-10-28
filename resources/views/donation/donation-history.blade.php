
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>

<div class="container">
    <div class="row" style="margin-top:25px;">
        <div class="col-lg-8 col-lg-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Donation History <i class="fa fa-history"></i></div>
                <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>Volunteer ID</th>
                                <th>Donation Group</th>
                                <th>Donation Type</th>
                                <th>Donation Value</th>
                                <th>Donation Date</th>
                                <th>Status</th>
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
                                    <td><button class="btn btn-sm btn-warning" data-id="{{$donation->donation_id}}">Re-Open <i class="fa fa-refresh"></i></button></td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-3">
            <a href="../profile"><button class="btn btn-block btn-default">
                Back <i class="fa fa-undo"></i>
            </button></a>
        </div>
    </div>
</div> <!-- /container -->

<!-- Globally Hosted Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/09e1e27aff.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Local JS Files -->
<script src="../../public/js/VolunteerRESTLibrary.js"></script>
<script src="../../public/js/Donation.js"></script>
</body>
</html>