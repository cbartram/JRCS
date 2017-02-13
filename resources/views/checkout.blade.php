@extends('components.navbar-simple')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
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
                                            <input type="checkbox" name="{{$v->id}}"> Select
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


<script src="/public/js/Checkout.js"></script>
<script>
    //start of the editable table plugin integration
    $('.table-bordered').Tabledit({
        url: '/api/v1/cico/update/',
        editButton: false,
        deleteButton: false,
        hideIdentifier: false,
        columns: {
            identifier: [0, 'id'],
            editable: [[3, 'timestamp']]
        },
        onAjax: function() {
            //when an ajax request is sent
            toastr.info('Attempting to update timestamp...');
        },
        onSuccess: function(data, textStatus, jqXHR) {
            console.log(data);
            if (data == false) {
                toastr.error('Error saving timestamp... The format must be YYYY-MM-DD H:MM AM/PM');
            } else {
                toastr.success('Your timestamp has been updated successfully!');

            }
        }
    });
</script>
@endsection