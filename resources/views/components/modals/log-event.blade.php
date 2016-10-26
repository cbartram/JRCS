<!-- Modal Log Event open -->
<div class="modal fade" id="log-event-modal" tabindex="-1" role="dialog" aria-labelledby="log-event-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="event-add">Log a Recent Event</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {{Form::open(array('url' => '/event'))}}
                    {{Form::text('event-id', Input::old('event-id'), ['placeholder' => 'Event ID', 'class' => 'form-control']) }}
                    {{Form::text('attendee_count', Input::old('attendee_count'), ['placeholder' => 'Attendee Count', 'class' => 'form-control']) }}
                    {{Form::textarea('event_description', Input::old('event_description'), ['placeholder' => 'Event Description', 'class' => 'form-control'])}}
                    {{Form::text('volunteer_count', Input::old('volunteer_count'), ['placeholder' => 'Volunteer Count', 'class' => 'form-control']) }}
                    {{Form::text('volunteer_hours', Input::old('volunteer_hours'), ['placeholder' => 'Total Volunteer Hours', 'class' => 'form-control']) }}
                    {{Form::text('donation_amount', Input::old('donation_amount'), ['placeholder' => 'Donation Amount', 'id' => 'donation_amount', 'class' => 'form-control']) }}

                    {{Form::submit('Log Event', ['class' => 'btn btn-primary'])}}
                    {{Form::close()}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-close" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal close -->