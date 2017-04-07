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
                            <th>City</th>
                            <th>State</th>
                            <th>Zip</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$volunteer[0]->id}}</td>
                                    <td>{{$volunteer[0]->first_name}}</td>
                                    <td>{{$volunteer[0]->last_name}}</td>
                                    <td>{{$volunteer[0]->email}}</td>
                                    <td>{{$volunteer[0]->phone}}</td>
                                    <td>{{$volunteer[0]->city}}</td>
                                    <td>{{$volunteer[0]->state}}</td>
                                    <td>{{$volunteer[0]->zip_code}}</td>
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
                <div class="panel-heading">Additional Information</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered volunteer">
                            <thead>
                                <th>Availability</th>
                                <th>Degree</th>
                                <th>Transportation</th>
                                <th>Languages</th>
                                <th>Criminal History</th>
                                <th>Nationality</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$volunteer[0]->availability}}</td>
                                <td>{{$volunteer[0]->degree}}</td>
                                <td>{!! $volunteer[0]->transportation == 1 ? '<span class="label label-success">True</span>' : '<span class="label label-danger">False</span>'!!}</td>
                                <td>{{$volunteer[0]->languages_spoken}}</td>
                                <td>{{$volunteer[0]->criminal_convictions}}</td>
                                <td>{{$volunteer[0]->nationality}}</td>
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
                <div class="panel-heading">Detailed Information</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <h4 style="color:black;  border-bottom: 1px dotted #000; padding-bottom:5px;">Interests</h4>
                        <p style="word-wrap: break-word;">
                            {{$volunteer[0]->interests}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h4 style="color:black;  border-bottom: 1px dotted #000; padding-bottom:5px;">Special Skills</h4>
                        <p style="word-wrap: break-word;">
                            {{$volunteer[0]->special_skills}}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h4 style="color:black;  border-bottom: 1px dotted #000; padding-bottom:5px;">Previous Volunteer Work</h4>
                        <p style="word-wrap: break-word;">
                            {{$volunteer[0]->previous_volunteer_work}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-9 col-lg-offset-1">
            <div class="panel panel-default" style="margin-top:25px;">
                <div class="panel-heading">Volunteer CICO Log</div>
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
                            <tbody id="detail-cico-table">
                            @foreach($cico as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td class="name">{{Helpers::getName($c->volunteer_id)}}</td>
                                <td class="email">{{$c->email}}</td>
                                <td>{{$c->check_in_timestamp}}</td>
                                <td>{{$c->check_out_timestamp}}</td>
                            </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Additional row to hold the add button -->
                    <div class="row">
                        <div class="col-md-1 col-md-offset-5">
                            <button class="btn btn-warning btn-circle"><span class="fa fa-plus"></span></button>
                            <button class="btn btn-primary btn-save">Save <span class="fa fa-download"></span></button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-cancel">Cancel <span class="fa fa-times"></span></button>
                        </div>
                    </div>
                    {{$cico->appends(request()->input())->links()}}
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

<script src="/public/js/Search.js"></script>
@endsection
