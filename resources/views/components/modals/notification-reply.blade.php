<!-- Modal add event open -->
<div class="modal fade" id="notification-reply-modal" tabindex="-1" role="dialog" aria-labelledby="event">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="notification-reply-header">Message From </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <!-- Profile Picture -->
                        <img height="60" width="60" src="" style="margin:10px;" class="notification-reply-picture">
                    </div>
                    <div class="col-md-10">
                        <!-- Message -->
                        <div class="notification-reply-message"></div>
                    </div>
                </div>
                <!-- Message Actions -->
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <a class="notification-reply-read" href=""><button class="btn btn-block btn-primary">Mark as Read <span class="fa fa-check"></span></button></a>
                    </div>
                    <div class="col-md-4">
                        <a class="notification-reply-delete" href=""><button class="btn btn-block btn-danger">Delete <span class="fa fa-trash"></span></button></a>
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
