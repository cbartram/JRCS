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
                    <div class="input-group">
                        {{ csrf_field() }}
                        <textarea class="form-control" placeholder="Brief Description" maxlength="200" name="description"></textarea>
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
