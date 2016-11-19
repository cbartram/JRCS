<!-- Modal for copy or switch -->
<div class="modal fade" id="donation-denied" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:black;">Donation Denied</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="donation-denied-form" action="">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            {{ csrf_field() }}
                            <textarea class="form-control" placeholder="Brief Description" maxlength="200" name="description"></textarea>
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
