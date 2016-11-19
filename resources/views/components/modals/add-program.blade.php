<!-- Modal for copy or switch -->
<div class="modal fade" id="add-program" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:black;">New Program</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="program/add">
                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                                {{ csrf_field() }}
                                <p><input type="text" name="program-name" placeholder="Program Name" class="form-control"></p>
                                <p><input type="hidden" name="id" value="{{Session::get('id')}}"></p>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-7 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" name="submit"><span style="margin-left:4px; margin-top:4px;" class="fa fa-plus"></span> Add</button>
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
