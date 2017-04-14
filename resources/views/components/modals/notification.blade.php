<!-- Modal add event open -->
<div class="modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-labelledby="event">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="event-add">Send a Message</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="form-group">
                            <form id="notify" action="notifications/notify/" method="post">
                                <select class="form-control" name="to" id="to">
                                    @foreach($allStaff as $s)
                                        <option value="{{$s->id}}">{{$s->first_name . ' ' . $s->last_name}}</option>
                                    @endforeach
                                </select>
                                {{ csrf_field() }}
                                <input type="hidden" name="from" id="from" value="{{Auth::user()->id}}">
                                <input type="hidden" name="from-name" value="{{Auth::user()->first_name . ' ' . Auth::user()->last_name}}">
                                <br>
                                <textarea rows="5" cols="10" class="form-control" id="notify_text" name="notify_text" placeholder="What's the Message?" minlength="3" maxlength="140" required></textarea>
                                <br>
                                <button type="submit" class="btn btn-primary">Send Message <span style="margin-left:5px; margin-top:4px" class="fa fa-send"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-2">
                        <button type="button" id="modal-close" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal close -->
