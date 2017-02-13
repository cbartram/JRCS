@extends('components.navbar-simple')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default" style="margin-top:25px;">
                <div class="panel-heading">Volunteer Information</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered volunteer">
                            <thead>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Details</th>
                            </thead>
                            <tbody>
                            @foreach($volunteers as $volunteer)
                            <tr>
                                <td>{{$volunteer->id}}</td>
                                <td>{{$volunteer->first_name}}</td>
                                <td>{{$volunteer->last_name}}</td>
                                <td>{{$volunteer->email}}</td>
                                <td>{{$volunteer->phone}}</td>
                                <td><a href="/volunteer/search?email={{$volunteer->email}}"><button class="btn btn-primary">View Details</button></a></td>
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
        <div class="col-lg-6 col-lg-offset-3" style="margin-top:15px;">
            <a href="/profile">
                <button class="btn btn-block btn-default">Back <span class="fa fa-undo"></span></button>
            </a>
        </div>
    </div>

</div> <!-- /container -->
@endsection

</body>
</html>