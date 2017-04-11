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
                    <div class="col-lg-6">
                        <h5>Select your Default group</h5>
                        <hr>
                        {{Form::open(array('url' => '/settings', 'method' => 'post'))}}
                        @if(Helpers::hasAccessTo('BEBCO', Auth::user()->id))
                            <div class="checkbox">
                                <label>{{ Form::radio('group-radio', 'BEBCO') }} Set BEBCO as Default</label>
                            </div>
                        @endif
                        @if(Helpers::hasAccessTo('JACO', Auth::user()->id))
                            <div class="checkbox">
                                <label>{{ Form::radio('group-radio', 'JACO') }} Set JACO as Default</label>

                            </div>
                        @endif
                        @if(Helpers::hasAccessTo('JBC', Auth::user()->id))
                            <div class="checkbox">
                                <label>{{ Form::radio('group-radio', 'JBC') }} Set JBC as Default</label>
                            </div>
                        @endif
                        @if(Helpers::hasAccessTo('JRCS', Auth::user()->id))
                            <div class="checkbox">
                                <label>{{ Form::radio('group-radio', 'JRCS') }} Set JRCS as Default</label>
                            </div>
                        @endif
                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        {{Form::close()}}
                    </div>

                    <div class="col-lg-6">
                        <h5>Promote/Demote Staff</h5>
                        <hr>
                        {{Form::open(array('url' => '/settings/rights', 'method' => 'post'))}}
                        <div class="radio">
                            <label for="promote" id="promote">
                                {{Form::radio('rights', 'promote')}} Promote
                            </label>
                        </div>
                        <div class="radio">
                            <label for="demote" id="demote">
                                {{Form::radio('rights', 'demote')}} Demote
                            </label>
                        </div>

                        <div class="input-group" id="volunteers">
                            <select name="volunteers">
                                @foreach($volunteers as $volunteer)
                                    <option value="{{$volunteer->id}}">{{$volunteer->id . '-' . $volunteer->first_name . ' ' .  $volunteer->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group" style="margin-top:15px;" id="password">
                            <label for="password">
                                {{Form::password('password', array('class' => 'form-control', 'placeholder' => 'Volunteers Password'))}}
                            </label>
                        </div>

                        <div class="input-group" id="checkbox-access">
                            <div class="checkbox">
                                @if(Helpers::hasAccessTo('JACO', Auth::user()->id))
                                    <label>{{Form::checkbox('jaco', 'true')}} JACO Access</label>
                                @endif
                            </div>
                            <div class="checkbox">
                                @if(Helpers::hasAccessTo('BEBCO', Auth::user()->id))
                                    <label>{{Form::checkbox('bebco', 'true')}} BEBCO Access</label>
                                @endif
                            </div>
                            <div class="checkbox">
                                @if(Helpers::hasAccessTo('JBC', Auth::user()->id))
                                    <label>{{Form::checkbox('jbc', 'true')}} JBC Access</label>
                                @endif
                            </div>
                        </div>

                        <div class="input-group" style="margin-bottom:15px;" id="staff">
                            Staff Members
                            <select name="staff" >
                                @foreach($allStaff as $s)
                                    <option value="{{$s->id}}">{{$s->id . '-' . $s->first_name . ' ' . $s->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{Form::submit('Save', array('class' => 'btn btn-primary'))}}
                        {{Form::close()}}
                    </div>
                </div>

                <!-- Start of the staff member view themselves part of the modal -->
                <div class="row">
                    <div class="col-lg-6">
                        <h5>Edit your Views</h5>
                        <hr>
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

                        {{Form::submit('Save', array('class' => 'btn btn-primary')) }}
                        {{Form::close()}}

                        @if(Helpers::isAdmin(Auth::user()->id))
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
                    </div>

                    <div class="col-lg-6">
                        <h5>Reset your Password</h5>
                        <hr>
                        {{Form::open(array('url' => '/password', 'method' => 'post'))}}
                        <p>{{Form::password('password-text', array('placeholder' => 'New Password', 'class' => 'form-control'))}}</p>
                        <p>{{Form::password('password-confirm', array('placeholder' => 'Confirm Password', 'class' => 'form-control'))}}</p>
                        <p>{{Form::submit('Reset Password', array('class' => 'btn btn-primary')) }}</p>
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