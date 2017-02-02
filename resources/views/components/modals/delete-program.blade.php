<!-- Modal for copy or switch -->
<div class="modal fade" id="delete-program" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:black;">Delete Program</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="program/delete">
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
                            <select class="form-control" name="program">
                                @foreach($programs as $program)
                                    <option value="{{$program->id}}">{{$program->program_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-7">
                        <button type="submit" class="btn btn-primary" name="submit">Submit <span style="margin-top:4px; margin-left:5px;" class="fa fa-plus"></span></button>
                        </form>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
