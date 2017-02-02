<!-- Modal Log Event open -->
<div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="search-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="event-add">Search Volunteers</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        {{Form::open(array('url' => '/volunteer/find/search', 'method' => 'get'))}}
                        {{-- They can only search for volunteers in a group for which they are a part of--}}
                        {{Form::hidden('group', $defaultGroup)}}
                        {{Form::text('email', Input::old('email'), ['placeholder' => 'First or Last Name', 'class' => 'form-control']) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-7">
                        {{Form::button('<span class="fa fa-search"></span> Search', ['class' => 'btn btn-primary', 'type' => 'submit'])}}
                        {{Form::close()}}
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