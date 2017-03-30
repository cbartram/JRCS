<!-- Modal Log Event open -->
<div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="log-event-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="event-add">Export Volunteer Data</h4>
            </div>
            <div class="modal-body">
                <form name="export" action="/excel/export" method="get">
                    {{csrf_field()}}
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-2">
                            <label for="start">
                               Start Date <input type="text" id="export-start-date" class="form-control" placeholder="YYYY-MM-DD" name="start">
                            </label>
                    </div>
                    <div class="col-lg-4">
                        <label for="end">
                            End Date <input type="text" id="export-end-date" class="form-control" placeholder="YYYY-MM-DD" name="end">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-2">
                        <select name="group" id="group-select" class="form-control">
                            @foreach($groups as $k => $v)
                                @if($groups[$k] == true && $k != "ADMIN")
                                    <option value="{{$k}}">{{$k}}</option>
                                @endif
                            @endforeach
                            @if($defaultGroup == "ADMIN" || $defaultGroup = "JRCS")
                            <option value="all">All Groups</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-7">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-file-excel-o"></span> Export Data</button>
                        </form>
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