<!-- Modal open -->
<div class="modal fade" id="pending-donations" tabindex="-1" role="dialog" aria-labelledby="pending-donations">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="pending-donations">Pending Donations</h4>
            </div>
            <div class="modal-body">

                <!-- Donation Table -->
                <table class="table table-striped">
                    <thead>
                    <th>Donation ID</th>
                    <th>Volunteer Name</th>
                    <th>Group Donation</th>
                    <th>Donation Type</th>
                    <th>Donation Value</th>
                    <th>Donation Description</th>
                    <th>Status</th>
                    <th>Donation Date</th>
                    <th>Approve</th>
                    <th>Deny</th>
                    </thead>
                    <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{$donation->donation_id}}</td>
                            <td>{{$donation->first_name . " " . $donation->last_name}}</td>
                            <td>{{$donation->group_name}}</td>
                            <td>{{$donation->donation_type}}</td>
                            @if($donation->donation_value != 'null')
                                <td>{{$donation->donation_value}}</td>
                            @else
                                <td>$0.00</td>
                            @endif
                            <td>{{$donation->donation_description}}</td>
                            <td><span class="label label-warning">{{$donation->status}}</span></td>
                            <td><span class="label label-primary">{{$donation->date}}</span></td>
                            <td>
                                <a href="/donation/approve/{{$donation->donation_id}}"><button type="button" class="btn btn-primary"><span class="fa fa-thumbs-o-up"></span></button></a>
                            </td>
                            <td>
                                <a href="/donation/deny/{{$donation->donation_id}}"><button type="button" class="btn btn-danger"><span class="fa fa-thumbs-o-down"></span></button></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal close -->