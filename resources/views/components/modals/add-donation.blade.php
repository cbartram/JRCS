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

                    <select name="volunteer-select" class="form-control">
                        @foreach($volunteers as $volunteer)
                            <option value="{{$volunteer->id}}">{{$volunteer->id . ' - ' . $volunteer->first_name . ' ' . $volunteer->last_name}}</option>
                        @endforeach
                    </select>

                    <select name="group" class="form-control" id="group">
                        @foreach($groups as $k => $v)
                            @if($groups[$k] == true && $k != "ADMIN")
                                <option name="{{$k}}">{{$k}}</option>
                            @endif
                        @endforeach
                    </select>

                    <select name="donation-type" class="form-control" id="donation-type">
                        <option name="monetary">Monetary</option>
                        <option name="supplies">Supplies</option>
                        <option name="inkind">In Kind</option>
                    </select>

                    <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">
                    <input type="text" class="form-control" name="type" id="type" placeholder="Type of Supplies">
                    <input type="text" class="form-control" name="inkind" id="inkind" placeholder="Type of Work">
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
            </div>
        </div>
    </div>
</div>