<!-- Modal Add Volunteer open -->
<div class="modal fade" id="add-volunteer-modal" tabindex="-1" role="dialog" aria-labelledby="add-volunteer-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;" id="vol-add">Add a Volunteer</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => '/add', 'method' => 'post')) }}


                <div class="row">
                    <div class="col-lg-6">
                        <label for="first_name">Add a Volunteer</label>
                        <p>{{ Form::text('first_name', Input::old('first_name'), array('placeholder' => 'First Name', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('last_name', Input::old('last_name'), array('placeholder' => 'Last Name', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('address', Input::old('address'), array('placeholder' => 'Address', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('city', Input::old('city'), array('placeholder' => 'City', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('state', Input::old('state'), array('placeholder' => 'State',  'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('zip', Input::old('zip'), array('placeholder' => 'Zip Code', 'maxlength' => '6', 'onkeypress' => "validate(event)", 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('phone', Input::old('phone'), array('placeholder' => 'Phone', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('nationality', Input::old('nationality'), array('placeholder' => 'Nationality', 'class' => 'form-control')) }}</p>

                        <p>
                            <select name="volunteer_type" class="form-control">
                                <option>General</option>
                                <option>Program</option>
                                <option>Board</option>
                            </select>
                        </p>

                        <h4 style="color:black;">Availability</h4>
                        {{-- Volunteer Information Table --}}
                        <div class="checkbox">
                            <label>{{ Form::checkbox('monday', 'true') }} Monday</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('tuesday', 'true') }} Tuesday</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('wednesday', 'true') }} Wednesday</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('thursday', 'true') }} Thursday</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('friday', 'true') }} Friday</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('saturday', 'true') }} Saturday</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('sunday', 'true') }} Sunday</label>
                        </div>

                        <h4 style="color:black;">Interests</h4>

                        <div class="checkbox">
                            <label>{{ Form::checkbox('transportation', 'true') }} Transportation</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('tanf', 'true') }} TANF</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('esol', 'true') }} Vocational ESOL</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('lawn', 'true') }} Lawn Maintainence Trainer</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('sat', 'true') }} SAT/ACT/GED Prep</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('career', 'true') }} Career Mentoring</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('fundraising', 'true') }} Fundraising</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('event', 'true') }} Event Assistance</label>
                        </div>
                        <div class="checkbox">
                            <label>{{ Form::checkbox('other', 'true') }} Other</label>
                        </div>

                        <h4 style="color:black">Special Skills</h4>
                        {{ Form::textarea('skills', null, ['class' => 'form-control', 'placeholder' => 'Special Skills or Assets']) }}

                        <h4 style="color:black;">Degree & Transportation</h4>
                        <p>{{ Form::text('degree', Input::old('degree'), array('placeholder' => 'Highest Degree', 'class' => 'form-control')) }}</p>
                        <div class="checkbox">
                            <label>{{Form::checkbox('has-transportation', 'true')}} Has Transportation</label>
                        </div>

                        <h4 style="color:black">Languages</h4>
                        {{ Form::textarea('languages', null, ['class' => 'form-control', 'placeholder' => 'Languages Spoken']) }}

                        <h4 style="color:black;">Previous Volunteer Work</h4>
                        {{ Form::textarea('previous', null, ['class' => 'form-control', 'placeholder' => 'Brief Description of Previous Work']) }}

                        <h4 style="color:black">Criminal History</h4>
                        <p>{{ Form::text('criminal', Input::old('degree'), array('placeholder' => 'List Criminal Convictions', 'class' => 'form-control')) }}</p>

                        <h4 style="color:black;">Emergency Contact Information</h4>

                        <p>{{ Form::text('e-first_name', Input::old('e-first_name'), array('placeholder' => 'First Name', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-last_name', Input::old('e-last_name'), array('placeholder' => 'Last Name', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-address', Input::old('e-address'), array('placeholder' => 'Address', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-city', Input::old('e-city'), array('placeholder' => 'City', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-state', Input::old('e-state'), array('placeholder' => 'State', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-zip', Input::old('e-zip'), array('placeholder' => 'Zip Code', 'maxlength' => '6', 'onkeypress' => "validate(event)", 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-email', Input::old('e-email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('e-phone', Input::old('e-phone'), array('placeholder' => 'Phone', 'class' => 'form-control')) }}</p>


                    </div>
                    <div class="col-lg-6">
                        <label for="checkbox">Volunteer Access</label>
                        @if(Helpers::hasAccessTo('BEBCO', Auth::user()->id))
                            <div class="checkbox">
                                <label>{{ Form::checkbox('bebco-checkbox', 'true') }} Add to BEBCO</label>
                            </div>
                        @endif
                        @if(Helpers::hasAccessTo('JACO', Auth::user()->id))
                            <div class="checkbox">
                                <label>{{ Form::checkbox('jaco-checkbox', 'true') }} Add to JACO</label>
                            </div>
                        @endif
                        @if(Helpers::hasAccessTo('JBC', Auth::user()->id))
                            <div class="checkbox disabled">
                                <label>{{ Form::checkbox('jbc-checkbox', 'true') }} Add to JBC</label>
                            </div>
                        @endif
                        @if(Helpers::hasAccessTo('JRCS', Auth::user()->id))
                            <div class="checkbox disabled">
                                <label>{{ Form::checkbox('jrcs-checkbox', 'true') }} Add to JRCS</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-7">
                        <button type="submit" class="btn btn-primary" name="Submit"><i style="margin-top:4px; margin-left:5px;" class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Volunteer close -->