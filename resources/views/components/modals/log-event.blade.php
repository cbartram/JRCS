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
                    <select name="event-id" class="form-control">
                        @foreach($log as $event)
                           @if($event->log_status == 0)
                               <option value="{{$event->id}}">{{$event->title}}</option>
                           @endif
                        @endforeach
                    </select>
                    {{Form::text('attendee_count', Input::old('attendee_count'), ['placeholder' => 'Attendee Count', 'class' => 'form-control']) }}
                    {{Form::textarea('event_description', Input::old('event_description'), ['placeholder' => 'Event Description', 'class' => 'form-control'])}}
                    {{Form::text('volunteer_count', Input::old('volunteer_count'), ['placeholder' => 'Volunteer Count', 'class' => 'form-control']) }}
                    {{Form::text('volunteer_hours', Input::old('volunteer_hours'), ['placeholder' => 'Total Volunteer Hours', 'class' => 'form-control']) }}
                    {{Form::text('donation_amount', Input::old('donation_amount'), ['placeholder' => 'Donation Amount', 'id' => 'donation_amount', 'class' => 'form-control']) }}
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-7">
                        {{Form::button('<span class="fa fa-pencil"></span> Log Event', ['class' => 'btn btn-primary', 'type' => 'submit'])}}
                        {{Form::close()}}
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="modal-close" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal close -->