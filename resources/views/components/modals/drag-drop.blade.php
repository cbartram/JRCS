<!-- Modal for copy or switch -->
<div class="modal fade" id="copy" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:black;">Copy or Switch</h4>
            </div>
            <div class="modal-body">
                <p>Would you like to copy the volunteer over to the new group
                    or switch the volunteer to the new group?</p>
                <div class="row">
                    <div class="col-md-6">
                        <span class="label label-warning">Warning!</span>
                        <p>This will add the volunteer to new group without removing them from their current group.</p>
                        <button type="button" id="copy-btn" class="btn btn-primary" data-dismiss="modal">Copy Volunteer <span class="fa fa-files-o"></span></button>
                    </div>
                    <div class="col-md-6">
                        <span class="label label-warning">Warning!</span>
                        <p>This will remove the volunteer from their current group and switch them over to the new group.</p>
                        <button type="button" id="switch-btn" class="btn btn-warning" data-dismiss="modal">Switch Volunteer <span class="fa fa-random"></span></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
