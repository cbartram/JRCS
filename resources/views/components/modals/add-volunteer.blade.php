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
                <div class="input-group">
                    <label for="first_name">Add a Volunteer</label>
                    <p>{{ Form::text('first_name', Input::old('email'), array('placeholder' => 'First Name', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('last_name', Input::old('email'), array('placeholder' => 'Last Name', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('address', Input::old('email'), array('placeholder' => 'Address', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('city', Input::old('email'), array('placeholder' => 'City', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('state', Input::old('email'), array('placeholder' => 'State', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('zip', Input::old('email'), array('placeholder' => 'Zip Code', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::text('phone', Input::old('email'), array('placeholder' => 'Phone', 'class' => 'form-control')) }}</p>
                    <p>{{ Form::select('volunteer_type', array('General' => 'General', 'Program' => 'Program', 'Board' => 'Board'), 'General'), array('class' => 'form-control')}}</p>

                    @if (Helpers::hasAccessTo('BEBCO', Session::get('id')))
                        <div class="checkbox">
                            <label>{{ Form::checkbox('bebco-checkbox', 'true') }} Add to BEBCO</label>
                        </div>
                    @endif
                    @if (Helpers::hasAccessTo('JACO', Session::get('id')))
                        <div class="checkbox">
                            <label>{{ Form::checkbox('jaco-checkbox', 'true') }} Add to JACO</label>

                        </div>
                    @endif
                    @if (Helpers::hasAccessTo('JBC', Session::get('id')))
                        <div class="checkbox disabled">
                            <label>{{ Form::checkbox('jbc-checkbox', 'true') }} Add to JBC</label>
                        </div>
                    @endif

                </div><!-- /input-group -->
                <div class="input-group">
                    {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                </div>
                {{Form::close()}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Volunteer close -->