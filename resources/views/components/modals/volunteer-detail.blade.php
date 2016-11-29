<!-- Modal open -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title" style="color:black;" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Volunteer ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                    </thead>
                    <tbody id="table-body">
                    <!-- Load Volunteer Demographic info -->
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-lg-12 volunteer-chart">
                        <!-- Individual Volunteer Highcharts are loaded here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-6">
                        <button type="button" id="archive-volunteer" class="btn btn-primary">Archive Volunteer <span class="fa fa-archive"></span></button>
                    </div>
                    <div class="col-lg-3">
                        <button type="button" id="modal-close" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal close -->