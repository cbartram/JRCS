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
                        <p>{{ Form::text('state', Input::old('state'), array('placeholder' => 'State', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('zip', Input::old('zip'), array('placeholder' => 'Zip Code', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}</p>
                        <p>{{ Form::text('phone', Input::old('phone'), array('placeholder' => 'Phone', 'class' => 'form-control')) }}</p>
                        <p>
                            <select name="volunteer_type" class="form-control">
                                <option>General</option>
                                <option>Program</option>
                                <option>Board</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <label for="checkbox">Volunteer Access</label>
                        @if(Helpers::hasAccessTo('BEBCO', Auth::user()->id)))
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