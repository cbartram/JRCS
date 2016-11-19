<!-- Modal add event open -->
<div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="event">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="event-add">Add a Calendar Event</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="form-group">
                            <p><input type="text" class="form-control" id="start-date" placeholder="Start Date"></p>
                            <p><input type="text" class="form-control" id="end-date" placeholder="End Date (Optional)"></p>
                            <p><input type="text" class="form-control" id="title" placeholder="Event Title"></p>
                            <select name="group" id="group-select" class="form-control">
                                @foreach($groups as $k => $v)
                                    @if($groups[$k] == true && $k != "ADMIN")
                                        <option value="{{$k}}">{{$k}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-7">
                        <button type="button" class="btn btn-primary" id="create-event" data-dismiss="modal"><span class="fa fa-plus"></span> Create Event</button>
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
