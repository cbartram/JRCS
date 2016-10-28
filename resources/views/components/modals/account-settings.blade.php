<!-- Modal open -->
<div class="modal fade" id="account-settings-modal" tabindex="-1" role="dialog" aria-labelledby="account-settings-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="acct-settings">Account Settings</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Select your Default group</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{Form::open(array('url' => '/settings', 'method' => 'post'))}}
                        @if (Helpers::hasAccessTo('BEBCO', Session::get('id')))
                            <div class="checkbox">
                                <label>{{ Form::radio('group-radio', 'BEBCO') }} Set BEBCO as Default</label>
                            </div>
                        @endif
                        @if (Helpers::hasAccessTo('JACO', Session::get('id')))
                            <div class="checkbox">
                                <label>{{ Form::radio('group-radio', 'JACO') }} Set JACO as Default</label>

                            </div>
                        @endif
                        @if (Helpers::hasAccessTo('JBC', Session::get('id')))
                            <div class="checkbox disabled">
                                <label>{{ Form::radio('group-radio', 'JBC') }} Set JBC as Default</label>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        {{Form::close()}}
                    </div>
                </div>


                <!-- Start of the staff member view themselves part of the modal -->
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Edit your Views</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{Form::open(array('url' => '/settings/self', 'method' => 'post'))}}
                        @if(Session::has('volunteer_id'))
                            @if(Session::has('show-self'))
                                <div class="checkbox">
                                    <label>{{Form::checkbox('self-checkbox', 'true', true) }} Show Yourself</label>
                                </div>
                            @else
                                <div class="checkbox">
                                    <label>{{Form::checkbox('self-checkbox', 'true', false) }} Show Yourself</label>
                                </div>
                            @endif
                        @else
                            <div class="checkbox disabled">
                                <label>{{Form::checkbox('self-checkbox', 'true', false, array('disabled')) }} Show Yourself</label>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        {{Form::close()}}
                    </div>
                </div>

                @if(Helpers::isAdmin(Session::get('id')))
                    <div class="row">
                        <div class="col-lg-12">
                            {{Form::open(array('url' => '/settings/drop', 'method' => 'post'))}}
                            <div class="checkbox">
                                <label>{{Form::checkbox('drop-checkbox', 'true', false) }} Show Drag & Drop for all Groups</label>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                            {{Form::close()}}
                        </div>
                    </div>
            @endif


            <!-- Start of the password reset option -->
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Reset your Password</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{Form::open(array('url' => '/password', 'method' => 'post'))}}
                        {{Form::password('password-text', Input::old('email'), array('placeholder' => 'New Password', 'class' => 'form-control'))}}
                        {{Form::password('password-confirm', Input::old('email'), array('placeholder' => 'Confirm Password', 'class' => 'form-control'))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {{Form::submit('Reset Password', array('class' => 'btn btn-primary')) }}
                        {{Form::close()}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-close" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal close -->