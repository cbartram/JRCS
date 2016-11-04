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

                    <div class="input-group">
                        {{ csrf_field() }}
                        <input type="text" class="form-control" name="program-name" placeholder="Program Name">
                        <input type="hidden" name="id" value="{{Session::get('id')}}">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
            </div>
        </div>
    </div>
</div>
