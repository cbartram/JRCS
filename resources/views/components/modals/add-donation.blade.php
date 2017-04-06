<!-- Modal Add volunteer -->
<div class="modal fade" id="add-donation" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:black;">Add a Donation</h4>
            </div>
            <div class="modal-body">
                <form action="/donation/add" method="post">
                    {{Form::token()}}

                    <p><select name="volunteer-select" class="form-control">
                        @foreach($volunteers as $volunteer)
                            <option value="{{$volunteer->id}}">{{$volunteer->id . ' - ' . $volunteer->first_name . ' ' . $volunteer->last_name}}</option>
                        @endforeach
                    </select></p>

                    <p><select name="group" class="form-control" id="group">
                            @foreach($groups as $group)
                                @if($group->getAuth() && $group->getName() != "ADMIN")
                                    <option value="{{$group->getName()}}"> {{$group->getName()}}</option>
                                @endif
                            @endforeach
                    </select></p>

                    <p><select name="donation-type" class="form-control" id="donation-type">
                        <option name="monetary">Monetary</option>
                        <option name="supplies">Supplies</option>
                        <option name="inkind">In Kind</option>
                    </select></p>

                    <p><input type="text" class="form-control" name="amount" id="amount" placeholder="Amount"></p>
                    <p><input type="text" class="form-control" name="type" id="type" placeholder="Type of Supplies"></p>
                    <p><input type="text" class="form-control" name="inkind" id="inkind" placeholder="Type of Work"></p>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-7 col-lg-offset-3">
                        <button type="submit" name="submit" class="btn btn-primary"><span style="margin-top:4px; margin-left:5px;" class="fa fa-plus"></span> Add</button>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>